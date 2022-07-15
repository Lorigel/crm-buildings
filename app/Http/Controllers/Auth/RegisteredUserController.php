<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::where('slug', '<>', 'admin')->get();
        $user_roles = $roles->map(function($role){
            return [
                'value' => $role->id,
                'name' => $role->name
            ];
        })->toArray();

        return view('auth.register', [
            'roles' => $user_roles
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = $this->validateData($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $verify_email_token = Str::random(32);

        $user = new User([
            'name' => $request->name,
            'surname' => $request->surname,
            'business_name' => $request->business_name,
            'username' => $request->username,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'role' => $request->role,
            'assigned_to_name' => $request->assigned_to_name,
            'vat_number' => $request->vat_number,
            'fiscal_number' => $request->fiscal_number,
            'phone_number' => $request->phone_number,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'province' => $request->province,
            'pec' => $request->pec,
            'note' => $request->note,
            'token' => $verify_email_token,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'company_email' => $request->company_email,
            'size' => $request->size,
            'bank' => $request->bank,
            'iban' => $request->iban,
            'bic' => $request->bic
        ]);

        if($request->file('image')){
            $image = $this->uploadUserImage($request->file('image'));
            $user->image = $image;
        }
   
        $user->save();

        event(new Registered($user));
        return redirect()
                ->back()
                ->with('msg', 'Il tuo account è stato creato. Devi verificarlo nella tua email. Il tuo account verrà attivato dagli amministratori del sito. Verrai reindirizzato alla pagina di accesso dopo pochi secondi.');
    }

    protected function validateData($request)
    {
        $messages = [
            'required' => 'Questo campo è obbligatorio',
            'vat_number.numeric' => 'Partita IVA dovrebbe contenere solo numeri',
            'vat_number.digits' => 'Partita IVA deve avere :digits numeri',
            'email.email' => 'Questa non è una mail valida',
            'email.unique' => 'Questa email è già in uso',
            'username.unique' => 'Questo nome è già in uso',
            'password.confirmed' => 'Le passwords non corrispondono',
            'password.min' => 'La password deve essere di almeno :min caratteri',
            'gdpr.accepted' => 'Accettato il trattamento dei dati personali',
            'assigned_to_name.required_unless' => 'Questo campo è obbligatorio'
        ];

        $admin_roles = Role::whereIn('slug',Role::ADMIN_ROLES)->get('id')->modelKeys();
        $third_party_roles = Role::whereIn('slug',Role::THIRD_PARTY_ROLES)->get('id')->modelKeys();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'address' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'role' => 'required',
            'assigned_to_name' => 'required_unless:role,'.implode(',',$admin_roles).','.implode(',',$third_party_roles),
            'vat_number' => 'nullable|numeric|digits:11',
            'fiscal_number' => 'required',
            'mobile_number' => 'required',
            'email' =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required','confirmed', Rules\Password::defaults()],
            'gdpr' => 'accepted',
            'birthday' => ['required', 'date'],
            'size' => 'required',
            'bank' => 'required',
            'iban' => 'required',
        ], $messages);

        return $validator;
    }

    protected function uploadUserImage($file)
    {
        $path = 'users/' . str_replace('.pdf','',$file->hashName()) . '/' . $file->getClientOriginalName();
        Storage::put($path, file_get_contents($file->getRealPath()));
        return $path;
    }
}
