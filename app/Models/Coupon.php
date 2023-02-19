<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    protected $fillable = [
        'code',
        'discount',
        'active_from',
        'active_to',
        'description',
        'available_use_count',
        'status',
    ];

    public $translatable = ['description'];

}
