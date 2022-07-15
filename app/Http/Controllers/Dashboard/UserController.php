<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Mail\SendMailToRegisteredUser;
use App\Mail\UserActivationMail;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DateTime;
use DateTimeZone;
use App\Http\Controllers\SubscriberController;
use App\Models\Subscriber;
use Maatwebsite\Excel\HeadingRowImport;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
            public function orgcharts()
                {
                    $user = Auth::user();

                    if($user->hasRole('admin') || $user->hasRole('master')){
                        $users = User::where('id', '<>', $user->id)->with('role')->orderBy('id','desc')->get();
                    }
                    else{
                        $users = User::where('id', '<>', $user->id)
                                    ->where('assigned_to', $user->id)
                                    ->where('email_verified_at', '<>', null)
                                    ->where('account_verified_at', '<>', null)
                                    ->orderBy('id','desc')->get();
                    }


                    return view('dashboard.admin.users.listing', ['users' => $users]);
                }

    public function list()
    {
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('master')){
            $users = User::where('id', '<>', $user->id)->with('role')->orderBy('id','desc')->get();
        }
        else{
            $users = User::where('id', '<>', $user->id)
                        ->where('assigned_to', $user->id)
                        ->where('email_verified_at', '<>', null)
                        ->where('account_verified_at', '<>', null)
                        ->orderBy('id','desc')->get();
        }


        return view('dashboard.admin.users.list', ['users' => $users]);
    }

    public function new()
    {
        $roles = $this->getUserRoles();
        $users = $this->getUsers();
        $assigned_to = $users->map(function($user){
            return [
                'name' => $user->name . ' ' . $user->surname,
                'value' => $user->id
            ];
        });

        return view('dashboard.admin.users.add', [
            'roles' => $roles,
            'assigned_to' => $assigned_to
        ]);
    }

    public function add(Request $request)
    {
        $messages = [
            'required' => 'Questo campo è obbligatorio',
            'email.email' => 'Questa non è una mail valida',
            'email.unique' => 'Questa email è già in uso',
            'username.unique' => 'Questo nome è già in uso',
            'assigned_to.required_unless' => 'Questo campo è obbligatorio'
        ];

        $admin_roles = Role::whereIn('slug',Role::ADMIN_ROLES)->get('id')->modelKeys();
        $third_party_roles = Role::whereIn('slug',Role::THIRD_PARTY_ROLES)->get('id')->modelKeys();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'assigned_to' => 'required_unless:role,'.implode(',',$admin_roles).','.implode(',',$third_party_roles)
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $role = Role::find($data['role']);

        if(in_array($role->slug, Role::ADMIN_ROLES) || in_array($data['role'], Role::THIRD_PARTY_ROLES)){
            if($data['assigned_to']){
                $data['assigned_to'] = null;
            }
        }

        $user = new User($data);

        $now = (new DateTime('now', new DateTimeZone('Europe/Rome')))->format('Y-m-d H:i:s');
        $user->email_verified_at = $now;
        $user->account_verified_at = $now;
        $user->save();

        if(!$user){
            return redirect()->back()->with('msg', __('User is not registered'));
        }

        $this->sendEmailToRegisteredUser($user);
        return redirect()->back()->with('msg',  __('Utente creato.The user has been notified via email. After the user verifies his email, you can activate the account here'));
    }

    protected function sendEmailToRegisteredUser($user)
    {
        $token = Str::random(20);
        $user->token = $token;
        $user->save();

        Mail::to($user->email)->send(new SendMailToRegisteredUser($user, $token));
    }

    public function acceptInvitation()
    {
        if(!request()->t){
            abort(404);
        }

        if(Auth::user()){
            return redirect('dashboard');
        }
        $token = request()->t;
        $user = User::where('token', $token)->first();

        if(!$user){
            abort(404);
        }

        return view('public.set-password', ['user_id' => $user->id, 'token' => $token]);
    }

    public function setPassword(Request $request)
    {
        if(!$request->get('user_id')){
            return redirect()->back()->with('msg',  __('Password is not set'));
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($request->get('user_id'));

        $status = $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return $status == true
                    ? redirect()->route('login')
                    : back()->with('msg', __('Password is not set'));
    }

    public function editProfile($id = null)
    {
        $user = $id ? User::where('id', $id)->first() : Auth::user();

        if(!$user){
            return;
        }

        if($user != Auth::user()){
            $auth_user = Auth::user();
            if($auth_user->hasRole('supervisor') && $user->assigned_to <> $auth_user->id){
                abort(404);
            }
        }

        $subscribed = Subscriber::where('email', $user->email)->where('status', 'subscribed')->first() ? true : false;
        $can_edit_assigned_to = (Auth::user())->canEditAssignedTo();

        $users = $this->getUsers();
        $assigned_to = $users->map(function($user){
            return [
                'name' => $user->name . ' ' . $user->surname,
                'value' => $user->id
            ];
        });

        return view('dashboard.user.edit', [
            'user' => $user,
            'subscribed' => $subscribed,
            'can_edit_assigned_to' => $can_edit_assigned_to,
            'roles' => $this->getUserRoles(),
            'assigned_to' => $assigned_to
        ]);
    }

    public function update(Request $request)
    {
        $validator = $this->validateUpdate($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $user = User::findOrFail($data['user_id']);

        $profile_data = [
            "business_name",
            "name",
            "surname",
            "address",
            "postal_code",
            "city",
            "province",
            "vat_number",
            "fiscal_number",
            "phone_number",
            "mobile_number",
            "pec",
            "username",
            "note",
            "assigned_to",
            'profit',
            'assigned_to_name',
            'role'
        ];

        foreach($data as $key => $value){
            if(in_array($key, $profile_data)){
                $user->$key = $value;
            }
        }

        //activate user profile
        if(isset($data['is_active'])){
            if(!$user->account_verified_at){
                $user->account_verified_at = (new DateTime('now', new DateTimeZone('Europe/Rome')))->format('Y-m-d H:i:s');
                //send activation email to user
                Mail::to($user->email)->send(new UserActivationMail($user));
            }
        }
        else{
            $user->account_verified_at = null;
        }

        if(in_array($data['role'],Role::whereIn('slug',array_merge(Role::ADMIN_ROLES, Role::THIRD_PARTY_ROLES))->get('id')->modelKeys())){
            $user->assigned_to = null;
        }

        $user->save();

        //change password
        if($data['password']){
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();
        }

        //subscribe or unsubscribe
        isset($data['newsletter']) ? $this->subscribeUser($user->email) : $this->unsubscribeUser($user->email);

        return redirect()
                ->back()
                ->with('msg', 'Salvato');
    }

    protected function validateUpdate($request)
    {
        $messages = [
            'required' => 'Questo campo è obbligatorio',
            'vat_number.numeric' => 'Partita IVA dovrebbe contenere solo numeri',
            'vat_number.digits' => 'Partita IVA deve avere 11 numeri',
            'profit.required_if' => 'Questo campo è obbligatorio',
            'required_unless' => 'Questo campo è obbligatorio',
        ];

        $admin_roles = Role::whereIn('slug',Role::ADMIN_ROLES)->get('id')->modelKeys();
        $third_party_roles = Role::whereIn('slug',Role::THIRD_PARTY_ROLES)->get('id')->modelKeys();
        $general_contractor = Role::where('slug','general-contractor')->first()['id'];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'vat_number' => 'nullable|numeric|digits:11',
            'fiscal_number' => 'required',
            'mobile_number' => 'required',
            'assigned_to_name' => 'required_unless:role,'.implode(',',$admin_roles).','.implode(',',$third_party_roles),
            'assigned_to' => 'required_unless:role,'.implode(',',$admin_roles).','.implode(',',$third_party_roles),
            'username' => 'required|unique:users,username,'.$request->get('user_id'),
            'password' => ['nullable','confirmed', Rules\Password::defaults()],
            'profit' => 'required_if:role,'.$general_contractor
        ], $messages);

        return $validator;
    }

     /**
     * Subscribe user
     *
     * @var string
     * @return boolean
     */
    protected function subscribeUser($email)
    {
        $subscription_handler = new SubscriberController();
        $subscription_handler->addSubscriber($email);
    }


     /**
     * Unsubscribe user
     *
     * @var string
     * @return boolean
     */
    protected function unsubscribeUser($email)
    {
        $subscription_handler = new SubscriberController();
        $subscription_handler->unsubscribe($email);
    }


     /**
     * Decide to show or hide assigned to field based on user role
     *
     * @var array
     * @return array
     */
    public function showAssignedTo(Request $request)
    {
        if($request->get('role')){
            $user_role = Role::findOrFail($request->get('role'));

            if(!$user_role){
                return;
            }

            if(in_array($user_role->slug, Role::ADMIN_ROLES) || in_array($user_role->slug, Role::THIRD_PARTY_ROLES)){
                return;
            }

            if(Auth::user() && (Auth::user())->canEditAssignedTo()){
                return [
                    'show_select' => true
                ];
            }
            // $assigned_to_role = Role::where('priority', $user_role->priority - 1)->first();
            // if(!$assigned_to_role || $assigned_to_role->slug == 'admin'){
            //     return;
            // }

            // $users = User::where('role', $assigned_to_role->id)->get();
            // return [
            //     'users' => collect($users)->map(function($user){
            //         return [
            //             'id' => $user->id,
            //             'name' => $user->name . ' ' . $user->surname
            //         ];
            // })];

            return [
                'show_text_input' => true
            ];
        }
    }


    /**
     * return import view
     * * @return \Illuminate\View\View
     */
    public function import()
    {
        $roles = $this->getUserRoles();

        return view('dashboard.admin.users.import', [
            'roles' => $roles
        ]);
    }

    /**
     * import users from csv
     * @param  Illuminate\Http\Request $request
     */
    public function handleImport(Request $request)
    {
        $this->validate($request, [
            'importFile' => 'required|max:1024',
            'role' => 'required'
        ]);

        $rowFields = [
            'nome',
            'cognome',
            'email',
            // 'assegnato_a',
            'username',
        ];

        $headings = (new HeadingRowImport)->toArray(request()->file('importFile'))[0][0];

        foreach($rowFields as $field){
            if(!in_array($field, $headings)){
                return back()->withErrors(['Manca colonna \'' . $field . '\'. Dovresti includere colonne: \'nome\', \'cognome\', \'email\', \'username\', nel file.']);
            }
        }

        $role = $request->input('role');

        (new UsersImport($role))->queue(request()->file('importFile'), null, \Maatwebsite\Excel\Excel::CSV);

        $message = $this->showImportMessage();

        return back()->with('status', $message);
    }

    protected function showImportMessage()
    {
        $message = 'L\'importazione è completata';
        if( (Session::has('updated_rows') && count(Session::get('updated_rows')) > 0) || ( Session::has('failed_rows') && count(Session::get('failed_rows')) > 0 )){
            $message .= ', ma erano presenti ';
        }

        if( Session::has('updated_rows') && count(Session::get('updated_rows')) > 0 ){
            $message .= count(Session::get('updated_rows')) . ' duplicati alle linee ';
            foreach ( Session::get('updated_rows') as $key => $row ) {
                if( $key != (count(Session::get('updated_rows')) -1) ){
                    $message .= $row . ', ';
                }
                else{
                    $message .= $row;
                }
            }
        }

        if( Session::has('failed_rows') && count(Session::get('failed_rows')) > 0 ){
            if( Session::has('updated_rows') && count(Session::get('updated_rows')) > 0 ){
                $message .= ', e ';
            }
            $message .=  count(Session::get('failed_rows')) . ' errori alle linee ';
            foreach (Session::get('failed_rows') as $key => $row ) {
                $row = $row->jsonSerialize();
                if( $key != (count(Session::get('failed_rows')) -1 ) ){
                    $message .= $row['row'] . ', ';
                }
                else{
                    $message .= $row['row'];
                }
            }

            $message .= '<br>Errori: <br>';
            foreach (Session::get('failed_rows') as $key => $row ) {
                $row = $row->jsonSerialize();
                $message .= 'Lineea ' . $row['row'] . ':<br>';
                foreach($row['errors'] as $error){
                    $message .= '- ' . $error . '<br>';
                }
            }
        }

        return $message;
    }

    protected function getUserRoles()
    {
        $roles = Role::all();
        $user_roles = $roles->map(function($role){
            return [
                'value' => $role->id,
                'name' => $role->name
            ];
        })->toArray();

        return $user_roles;
    }

    public function getUsers()
    {
        $admin = Role::where('slug','admin')->first();
        $users = User::where('role', '<>', $admin->id)
                    ->where('email_verified_at', '<>', null)
                    ->where('account_verified_at', '<>', null)->get();

        return $users;
    }

    public static function getUsersByRole($role)
    {
        $role = Role::where('slug', $role)->first();
        $users = User::where('role', $role->id)
                    ->where('email_verified_at', '<>', null)
                    ->where('account_verified_at', '<>', null)->get();
        return $users;
    }

    public function viewRelated()
    {
        $roles = collect(Role::whereIn('slug', array_merge(Role::FIRST_PARTY_ROLES, Role::SECOND_PARTY_ROLES, ['master']))->get())->keyBy('id')->toArray();
        $users = User::whereIn('role', array_keys($roles))
                    ->where('email_verified_at', '<>', null)
                    ->where('account_verified_at', '<>', null)->get();

        $users = $this->buildUserHierarchy($users);

        return view('dashboard.admin.users.relationships', ['users' => $users]);
    }

    protected function buildUserHierarchy($users, $user_id = null, $level = 0)
    {
        $users_tree = [];
        $parents = collect($users)->where("assigned_to", "==", $user_id)->values();

        foreach ($parents as $child) {
            $child->users = $this->buildUserHierarchy($users, $child->id, $level + 1);
            $item = [
                'id' => $child->id,
                'name' => $child->name . ' ' . $child->surname,
                'email' => $child->email,
                'role' => Role::find($child->role)->name,
                'users' => $this->buildUserHierarchy($users, $child->id, $level + 1),
            ];

            $users_tree[$child->id] =  $item;
        }
        return $users_tree;
    }

    /**
     * Deletes a user
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => __('User eliminato')], 200);
    }
}
