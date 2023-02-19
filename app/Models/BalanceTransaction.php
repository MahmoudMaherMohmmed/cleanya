<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BalanceTransaction extends Model
{
    use HasFactory; 
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'bank_transfer_id',
        'amount',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function bank_transfer()
    {
        return $this->belongsTo(BankTransfer::class);
    }
}
