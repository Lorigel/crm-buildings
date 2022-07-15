<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contract\ContractCreated;
use App\Mail\Contract\TechnicDocumentsUploaded;
use App\Mail\Contract\SendMailToCompany;
use DateTime;
use DateTimeZone;
use App\Models\Invoice;
use App\Mail\Contract\InvoiceUploaded;
use App\Mail\Contract\InvoiceApproved;
use App\Http\Controllers\Dashboard\CalculateProfit;
use App\Mail\Contract\ContractNotApproved;
use Illuminate\Support\Facades\Artisan;

// Author: Lorigela Karaj

class ContractController extends Controller
{
    protected $validationMessages = [
        'required' => 'Questo campo è obbligatorio',
        'numeric' => 'Questo campo dovrebbe contenere solo numeri',
        'client_fiscal_code.unique' => 'Questo FC è già in uso',
        'client_vat_number.digits' => 'Partita IVA deve avere :digits numeri',
        'documents.*.name.required_if' => 'Questo campo è obbligatorio',
        'condominiums.*.documents.other-name.required_with' => 'Questo campo è obbligatorio',
    ];

    public function list()
    {
        //symlink
        Artisan::call('storage:link', [] );
        
        $user = Auth::user();

        $contracts = Contract::with('user')->whereHas('user')->orderByDesc('created_at');
        if($user->canApproveContract()){
            $contracts = $contracts->get();
        }
        elseif($user->hasRole('technic')){
            $contracts = $contracts->where('technic', $user->id)->whereNotNull('verified_at')->get();
        }
        elseif($user->hasRole('company')){
            $contracts = $contracts->where('company', $user->id)->whereNotNull('verified_at')->get();
        }
        elseif($user->hasRole('general-contractor')){
            $contracts = $contracts->where('general_contractor', $user->id)->whereNotNull('verified_at')->get();
        }
        else{
            $contracts = $contracts->whereNotNull('verified_at')->whereHas('user', function($query) use($user)
            {
                $query->where('assigned_to', $user->id);
            })->orWhere('user_id', $user->id)->get();
        }

        return view('dashboard.contracts.list', ['contracts' => $contracts]);
    }

    public function view($id)
    {
        $contract = Contract::where('id',$id)->whereHas('User')->first();

        if(!$contract || !Auth::user()->canViewContract($contract)){
            abort('404');
        }

        $technic = User::where('id', $contract->technic)->first();
        $company = User::where('id', $contract->company)->first();
        $documents = Document::where('contract_id', $contract->id)->get();
        foreach($documents as $document){
            if($document->type != 'other'){
                $document->title = collect(array_merge(config('document-type.agent'),config('document-type.technic')))->where('value', $document->type)->first()['name'];
            }
        }

        $invoice = Invoice::where('contract_id', $id)->first();

        return view('dashboard.contracts.details', [
            'contract' => $contract,
            'technic' => $technic,
            'company' => $company,
            'documents' => $documents,
            'invoice' => $invoice
        ]);
    }

    /**
     * Edit the contract, shows the view
     * @param $id
     */
    public function edit($id)
    {
        $contract = Contract::where('id',$id)->whereHas('User')->first();
        if(!$contract && !Auth::user()->canApproveContract()){
            abort('404');
        }
        
        $legal_forms = legal_forms();
        $products = format_option_values(Product::all());
        $technics = format_option_values(UserController::getUsersByRole('technic'));
        $companies = format_option_values(UserController::getUsersByRole('company'));
        $general_contractors = format_option_values(UserController::getUsersByRole('general-contractor'));
        $documents = Document::where('contract_id', $contract->id)->get();
        $invoice = Invoice::where('contract_id', $id)->first();

        return view('dashboard.contracts.edit.index', [
            'contract' => $contract,
            'legal_forms' => $legal_forms,
            'products' => $products,
            'technics' => $technics,
            'companies' => $companies,
            'documents' => $documents,
            'invoice' => $invoice,
            'general_contractors' => $general_contractors
        ]);
    }

    /**
     * Update the contract
     * @param $id
     */
    public function update($id, Request $request)
    {
        $contract = Contract::findOrFail($id);
        $validator = $this->validateUpdate($request->all(), $id);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        $documentsValidator = $this->validateDocuments($data, 'agent');
        if($documentsValidator){
            return $documentsValidator;
        }

        $this->updateData($data, $contract);
        return response()->json(['success' => __('Pratica è salvata')], 200);
    }

    protected function validateUpdate($data, $id)
    {
        $validator = Validator::make($data, [
            'client_name' => 'required',
            'client_surname' => 'required',
            'client_legal_form' => 'required',
            'client_fiscal_code' => 'required|unique:contracts,client_fiscal_code,'.$id,
            'client_vat_number' => 'nullable|numeric|digits:11',
            'client_email' => 'required|email',
            'product' => 'required',
            'amount' => 'nullable|numeric',
            'technic' => 'required',
            'company' => 'required',
            'general_contractor' => 'required',
            'condominiums.*.name' => 'required',
            'condominiums.*.postal_code' => 'nullable|numeric',
            'condominiums.*.residence' => 'required',
            'condominiums.*.fiscal_code' => 'required',
            'condominiums.*.documents.other-name' => 'required_with:condominiums.*.documents.other-file',
            'documents.*.type' => ['required', function($attribute, $value, $fail) use($data){
                $count = collect($data['documents'])
                    ->reject(function ($item) {
                        return $item['type'] === 'other';
                    })
                    ->filter(function ($item) use ($value) {
                        return $item['type'] === $value;
                    })
                    ->count();

                if ($count > 1) {
                    $fail(__('Non riesco a caricare lo stesso documento più di una volta'));
                }
            }],
            'documents.*.name' => ['required_if:documents.*.type,other', function($attribute, $value, $fail) use($data){
                $count = collect($data['documents'])
                    ->reject(function ($item) {
                        return $item['type'] != 'other';
                    })
                    ->filter(function ($item) use ($value) {
                        return $item['name'] === $value;
                    })
                    ->count();

                if ($count > 1) {
                    $fail(__('Non riesco a caricare lo stesso documento più di una volta'));
                }
            }],
            'documents.*.document' => [
                function ($attribute, $value, $fail) use($data, $id) {
                    $index = explode('.', $attribute)[1];
                    $type = data_get($data, "documents.$index.type");
                    $title = data_get($data, "documents.$index.title");

                    if($type != 'other'){
                        $exists = Document::where('contract_id', $id)->where('type', $type)->exists();
                    }
                    else{
                        $exists = Document::where('contract_id', $id)->where('title', $title)->exists();
                    }

                    if (!$exists && !$value) {
                        return $fail('Questo campo è obbligatorio');
                    }
                },
            ],
        ], $this->validationMessages);

        return $validator;
    }

    protected function updateData($data, $contract)
    {
        if(isset($data['condominiums'])){
            $data['condominiums'] = $this->getCondominiums($data['condominiums']);
        }

        $contract->update($data);

        //check if contract agent documents and data are approved or not
        if(isset($data['approved'])){
            if($data['approved']){
                $this->approveContract($contract);
            }
            else{
                $this->cancelContract($contract);
                $agent = User::find($contract->user_id);
                Mail::to($agent->email)->send(new ContractNotApproved($contract));
            }
        }

        //check if technic documents are approved or not
        if(isset($data['reviewed'])){
            if($data['reviewed']){
                $this->reviewContract($contract);
            }
            else{
                $this->cancelContract($contract);
                $technic = User::find($contract->technic);
                Mail::to($technic->email)->send(new ContractNotApproved($contract));
            }
        }
        //check if invoice is approved or not
        if(isset($data['processing'])){
            if($data['processing']){
                $this->approveInvoice($contract);
            }
            else{
                $this->cancelContract($contract);
                $company = User::find($contract->company);
                Mail::to($company->email)->send(new ContractNotApproved($contract));
            }
        }
        //set as finished
        if(isset($data['finished'])){
            if($data['finished']){
                $contract->status = 'finished';
                $contract->save();
            }
        }


        $this->updateDocuments($data['documents'], $contract->id);
    }

    /**set contract as cancelled
     * @param Contract $contract
    */
    protected function cancelContract(Contract $contract)
    {
        $contract->status = 'cancelled';
        $contract->save();
    }

    protected function approveContract($contract)
    {
        if(!$contract->verified_at){
            $contract->verified_at = (new DateTime('now', new DateTimeZone('Europe/Rome')))->format('Y-m-d H:i:s');
            //update status
            $contract->status = 'open';
            $contract->save();
            //send mail to Technic
            $user = User::find($contract->user_id);
            $technic = User::find($contract->technic);
            if($technic){
                Mail::to($technic->email)->send(new ContractCreated($user, $contract));
            }
        }
    }

    /**set contract as approved
     * @param Contract $contract
     */
    protected function reviewContract(Contract $contract)
    {
        $contract->status = 'in_approval';
        $contract->save();
        //send mail to Company
        $company = User::find($contract->company);
        if($company){
            Mail::to($company->email)->send(new SendMailToCompany($contract));
        }
    }

    /**approve invoice
     * @param Contract $contract
     */
    protected function approveInvoice(Contract $contract)
    {
        $contract->status = 'processing';
        $contract->save();
        //send mail to all users related with the contract
        $agent = User::find($contract->user_id);
        $company = User::find($contract->company);
        $technic = User::find($contract->technic);

        Mail::to([$agent->email, $company->email, $technic->email])->send(new InvoiceApproved($contract));

        //send mail to General Contractor
        $general_contractor = User::find($contract->general_contractor);
        Mail::to($general_contractor->email)->send(new ContractCreated($agent,$contract));
    }

    public function updateDocuments($documents, $contract_id)
    {
        $contract_documents = Document::where('contract_id', $contract_id)->get()->keyBy('id');

        foreach($documents as $document){
            if($document['type'] != 'other'){
                $saved_document = Document::where('contract_id', $contract_id)->where('type',$document['type'])->first();
            }
            else{
                $saved_document = Document::where('contract_id', $contract_id)->where('title',$document['name'])->first();
            }

            if($saved_document){
                $contract_documents->forget($saved_document->id);
            }

            if($document['document']){
                if(!$saved_document){
                    $this->saveDocument($document, $contract_id,Auth::user()->id);
                }
                else{
                    $exists = Storage::exists('documents/' . $saved_document->pdf);
                    if($exists){
                        Storage::delete('documents/' . $saved_document->pdf);
                    }
                    $path = $document['type'] . '/' . str_replace('.pdf','',$document['document']->hashName()) . '/' . $document['document']->getClientOriginalName();
                    Storage::put('documents/' . $path, file_get_contents($document['document']->getRealPath()));
                    $saved_document->pdf = $path;
                    $saved_document->save();
                }
            }
        }

        if(!empty($contract_documents)){
            foreach ($contract_documents as $doc) {
                $doc->delete();
            }
        }
    }

    public function new()
    {
        $legal_forms = legal_forms();

        $products = Product::all();
        $companies = UserController::getUsersByRole('company');
        $companies = !empty($companies) ? $companies->map(function($company){
            return [
                'value' => $company->id,
                'name' => $company->name
            ];
        }) : [];

        $technics = UserController::getUsersByRole('technic');
        $technics = !empty($technics) ? $technics->map(function($technic){
            return [
                'value' => $technic->id,
                'name' => $technic->name
            ];
        }) : [];
        $general_contractors = format_option_values(UserController::getUsersByRole('general-contractor'));

        return view('dashboard.contracts.create.index', [
            'legal_forms' => $legal_forms,
            'products' => $products->map(function($product){
                return [
                    'value' => $product->id,
                    'name' => $product->name
                ];
            }),
            'technics' => $technics,
            'companies' => $companies,
            'general_contractors' => $general_contractors
        ]);
    }

    /**
     * create a new contract
     * @param Illuminate\Http\Request $request
     */
    public function create(Request $request)
    {
        $validator = $this->validateCreate($request->all());

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();

        $documentsValidator = $this->validateDocuments($data, 'agent');
        if($documentsValidator){
            return $documentsValidator;
        }

        $this->save($data);
        return response()->json(['success' => __('Pratica è caricata')], 200);
    }

    protected function validateCreate($data)
    {
        $validator = Validator::make($data, [
            'client_name' => 'required',
            'client_surname' => 'required',
            'client_legal_form' => 'required',
            'client_fiscal_code' => 'required|unique:contracts',
            'client_vat_number' => 'nullable|numeric|digits:11',
            'client_email' => 'required|email',
            'product' => 'required',
            'amount' => 'nullable|numeric',
            'technic' => 'required',
            'company' => 'required',
            'condominiums.*.name' => 'required',
            'condominiums.*.postal_code' => 'nullable|numeric',
            'condominiums.*.residence' => 'required',
            'condominiums.*.fiscal_code' => 'required',
            'condominiums.*.documents.other-name' => 'required_with:condominiums.*.documents.other-file',
            'documents.*.type' => ['required', function($attribute, $value, $fail) use($data){
                $count = collect($data['documents'])
                    ->reject(function ($item) {
                        return $item['type'] === 'other';
                    })
                    ->filter(function ($item) use ($value) {
                        return $item['type'] === $value;
                    })
                    ->count();

                if ($count > 1) {
                    $fail(__('Non riesco a caricare lo stesso documento più di una volta'));
                }
            }],
            'documents.*.document' => 'required',
            'documents.*.name' => ['required_if:documents.*.type,other', function($attribute, $value, $fail) use($data){
                $count = collect($data['documents'])
                    ->reject(function ($item) {
                        return $item['type'] != 'other';
                    })
                    ->filter(function ($item) use ($value) {
                        return $item['name'] === $value;
                    })
                    ->count();

                if ($count > 1) {
                    $fail(__('Non riesco a caricare lo stesso documento più di una volta'));
                }
            }],
        ], $this->validationMessages);

        return $validator;
    }

    protected function validateDocuments($data, $type)
    {
        if(!isset($data['documents'])){
            return response()->json(['error' => __('Dovresti caricare i documenti')], 400);
        }
        //get required docs
        $required_docs = $this->getRequiredDocuments($type);
        foreach($data['documents'] as $key=>$document){
            if(in_array($document['type'], $required_docs)){
                unset($required_docs[array_search($document['type'], $required_docs)]);
            }
        }
        //check if all required docs are uploaded
        if(!empty($required_docs)){
            $docs = collect(config('document-type.' . $type))->whereIn('value',$required_docs)->toArray();
            $message = 'Documenti ';
            foreach($docs as $doc){
                $message .= $doc['name'] . ', ';
            }
            $message .= 'sono obbligatorio';
            return response()->json(['error' => $message], 400);
        }

        return;
    }

    /**
     * saves the contract
     * @param array $data
     */
    public function save($data)
    {
        if(isset($data['condominiums'])){
            $data['condominiums'] = $this->getCondominiums($data['condominiums']);
        }
        $data['user_id'] = Auth::user()->id;
        $contract = new Contract($data);
        $contract->status = 'pending';
        $contract->save();

        $this->uploadDocuments($data['documents'], $contract->id, $data['user_id']);

        //set email to admin when contract created
        $this->sendContractCreatedMail($contract);
    }

    protected function getCondominiums($condominiums)
    {
        foreach($condominiums as $index=>$condominium){
            if($condominium['documents']){
                if(is_array($condominium['documents'])){
                    foreach($condominium['documents'] as $type => $document){
                        if($type != 'other-name'){
                            $condominiums[$index]['documents'][$type] = $this->uploadCondominiumDocument($document);
                        }
                    }
                }
                else{
                    $condominiums[$index]['documents'] = json_decode($condominium['documents']);
                }
                
            }
        }
        return json_encode($condominiums);
    }

    /**upload condomonium documents */
    public function uploadCondominiumDocument($document)
    {
        $path = str_replace('.pdf','',$document->hashName()) . '/' . $document->getClientOriginalName();
        Storage::put('condominiums/' . $path, file_get_contents($document->getRealPath()));
        return $path;
    }

    public function uploadDocuments($documents, $contract_id, $user_id)
    {
        foreach($documents as $document){
            $this->saveDocument($document, $contract_id, $user_id);
        }
    }

    protected function saveDocument($document, $contract_id, $user_id)
    {
        $path = $document['type'] . '/' . str_replace('.pdf','',$document['document']->hashName()) . '/' . $document['document']->getClientOriginalName();
        Storage::put('documents/' . $path, file_get_contents($document['document']->getRealPath()));
        $doc = new Document([
            'contract_id' => $contract_id,
            'type' => $document['type'],
            'title' => $document['name'] ?? null,
            'pdf' => $path,
            'user_id' => $user_id
        ]);

        $doc->save();
    }

    protected function getRequiredDocuments($user_role)
    {
        return $user_role == 'technic' ?
            array_keys(collect(config('document-type.technic'))->where('required',true)->keyby('value')->toArray())
            :
            array_keys(collect(config('document-type.agent'))->where('required',true)->keyby('value')->toArray());
    }

    /**
     * Send notification to admins when contract created
     * @param Contract $contract
     */
    protected function sendContractCreatedMail(Contract $contract)
    {
        $admins = UserController::getUsersByRole('admin');
        $masters = UserController::getUsersByRole('master');
        $users = $admins->merge($masters)->map(function($user){
            return $user->email;
        })->toArray();

        $user = User::find($contract->user_id);

        Mail::to($users)->send(new ContractCreated($user, $contract));
    }


    /**
     * upload technic documents
     */
    public function updateTechnicDocuments($id, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'documents.*.type' => ['required', function($attribute, $value, $fail) use($data){
                $count = collect($data['documents'])
                    ->reject(function ($item) {
                        return $item['type'] === 'other';
                    })
                    ->filter(function ($item) use ($value) {
                        return $item['type'] === $value;
                    })
                    ->count();

                if ($count > 1) {
                    $fail(__('Non riesco a caricare lo stesso documento più di una volta'));
                }
            }],
            'documents.*.document' => 'required',
            'documents.*.name' => ['required_if:documents.*.type,other', function($attribute, $value, $fail) use($data){
                $count = collect($data['documents'])
                    ->reject(function ($item) {
                        return $item['type'] != 'other';
                    })
                    ->filter(function ($item) use ($value) {
                        return $item['name'] === $value;
                    })
                    ->count();

                if ($count > 1) {
                    $fail(__('Non riesco a caricare lo stesso documento più di una volta'));
                }
            }],
        ], $this->validationMessages);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $documentsValidator = $this->validateDocuments($data, 'technic');
        if($documentsValidator){
            return $documentsValidator;
        }

        $this->uploadDocuments($data['documents'], $id, Auth::user()->id);

        $contract = Contract::find($id);
        $contract->status = 'review';
        $contract->save();

        //send email to admin
        $this->sendTechnicDocsUploadedMail($contract);
        return response()->json(['success' => __('Documenti caricati')], 200);
    }

     /**
     * Send notification to admins when contract created
     * @param Contract $contract
     */
    protected function sendTechnicDocsUploadedMail(Contract $contract)
    {
        $admins = UserController::getUsersByRole('admin');
        $masters = UserController::getUsersByRole('master');
        $users = $admins->merge($masters)->map(function($user){
            return $user->email;
        })->toArray();

        Mail::to($users)->send(new TechnicDocumentsUploaded($contract));
    }

      /**
     * Uploads company invoice
     * @param Contract $contract
     */
    public function uploadInvoice($id, Request $request)
    {
        $this->validate($request,  [
            'invoice' => 'required'
        ], $this->validationMessages);

        $invoice_doc = $request->all()['invoice'];

        $path = str_replace('.pdf','',$invoice_doc->hashName()) . '/' . $invoice_doc->getClientOriginalName();
        Storage::put('invoices/' . $path, file_get_contents($invoice_doc->getRealPath()));
        $invoice = new Invoice([
            'contract_id' => $id,
            'pdf' => $path,
            'user_id' => Auth::user()->id
        ]);

        $invoice->save();

        //send email to admin
        $this->sendInvoiceUploadedMail($id);
        return response()->json(['success' => __('La fattura e caricato')], 200);
    }

     /**
     * Send notification to admin and masters when invoice uploaded
     * @param $contract_id
     */
    protected function sendInvoiceUploadedMail($contract_id)
    {
        $contract = Contract::find($contract_id);
        $admins = UserController::getUsersByRole('admin');
        $masters = UserController::getUsersByRole('master');
        $users = $admins->merge($masters)->map(function($user){
            return $user->email;
        })->toArray();

        Mail::to($users)->send(new InvoiceUploaded($contract));
    }

    /**
     * Show profit details
     */
    public function profitDetails($id)
    {
        $contract = Contract::findOrFail($id);
        if(!$contract->hasStatus('processing') && !$contract->hasStatus('finished')){
            abort('404');
        }

        $profit = (new CalculateProfit($contract))->calculate();
        $user = User::find($contract->user_id);

        return view('dashboard.contracts.profit', [
            'profit' => $profit,
            'user' => $user
        ]);
    }
}
