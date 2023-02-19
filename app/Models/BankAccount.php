<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    public $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'IBAN',
        'image',
        'status',
    ];

    public $translatable = ['bank_name'];
}
