<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'contract_id',
        'type',
        'title',
        'pdf',
        'user_id'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
