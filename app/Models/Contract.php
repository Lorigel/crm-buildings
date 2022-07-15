<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    const STATUSES = [
        'pending' => 'In sospeso', //contract created
        'open' => 'Aperta', //contract is waiting for technic docs
        'review' => 'In revisione', //technic has uploaded docs and waiting for review
        'cancelled' => 'Anullata',  //contract not doable
        'in_approval' => 'In approvazione', //company can upload invoice and waits for approval
        'processing' => 'In lavorazione', //contract is set as doable
        'finished' => 'Chiusa' 
    ];

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'client_name',
        'client_surname',
        'client_company_name',
        'client_creation_date',
        'client_legal_form',
        'client_representive',
        'client_administrator_fiscal_code',
        'client_fiscal_code',
        'client_vat_number',
        'client_address',
        'client_postal_code',
        'client_city',
        'client_province',
        'client_phone_number',
        'client_mobile_number',
        'client_email',
        'product',
        'amount',
        'address',
        'referral',
        'note',
        'condominiums',
        'technic',
        'company',
        'verified_at',
        'general_contractor'
    ];

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product');
    }

    public function hasStatus($status)
    {
        return $this->status == $status ? true : false;
    }

    public function invoice()
    {
        return $this->hasOne('App\Models\Invoice');
    }
}
