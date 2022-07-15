<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\UserRegistered;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'role',
        'assigned_to_name',
        'assigned_to',
        'password',
        'token',
        'username',
        'business_name',
        'address',
        'postal_code',
        'city',
        'province',
        'vat_number',
        'phone_number',
        'fiscal_number',
        'mobile_number',
        'pec',
        'note',
        'email_verified_at',
        'account_verified_at',
        'birthday',
        'company_email',
        'size',
        'bank',
        'iban',
        'bic',
        'image',
        'profit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'account_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo('App\Models\Role', 'role');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserRegistered($this));
    }

    public function isAdmin()
    {
        $admin_role = \App\Models\Role::where('slug', 'admin')->first();
        return $this->role === $admin_role->id ? true : false;
    }

    public function hasRole($role_slug)
    {
        $role = Role::where("slug", $role_slug)->first();
        if(!$role){
            return false;
        }
        return $this->role == $role->id ? true : false;
    }

    public function canEditUser()
    {
        //admin and masters can view and edit all users
        $supervisor = Role::where('slug','supervisor')->first();

        if(in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) || $this->role == $supervisor->id){
            return true;
        }

        return false;
    }

    public function canEditAssignedTo()
    {
        return in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) ? true : false;
    }

    public function canAddUser()
    {
        return in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) ? true : false;
    }

    protected function getRoles($roles)
    {
        return Role::whereIn('slug', $roles)->get('id')->modelKeys();
    }

    public function canCreateContract()
    {
        return in_array($this->role, $this->getRoles(Role::agents())) ? true : false;
    }

    public function canApproveContract()
    {
        return in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) ? true : false;
    }

    public function canViewContract($contract)
    {
        if(in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) || $contract->user_id == $this->id){
            return true;
        }

        if($this->hasRole('technic') && $contract->technic == $this->id){
            return true;
        }

        if($this->hasRole('company') && $contract->company == $this->id){
            return true;
        }

        if($this->hasRole('general-contractor') && $contract->general_contractor == $this->id){
            return true;
        }

        if($contract->assigned_to == $this->id){
            return true;
        }

        return false;
    }

    public function canAddGeneralContractor()
    {
        return in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) ? true : false;
    }

    public function canAddProfitToGeneralContractors()
    {
        return in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) ? true : false;
    }

    public function canViewProfitDetails()
    {
        return in_array($this->role, $this->getRoles(Role::ADMIN_ROLES)) ? true : false;
    }

    public function users()
    {
        return $this->hasMany($this,'assigned_to');
    }
}
