<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BankTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',	
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'IBAN',
        'image',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function transaction()
    {
        return $this->hasOne(BalanceTransaction::class);
    }
}
