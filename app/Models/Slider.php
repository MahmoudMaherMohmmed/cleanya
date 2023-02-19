<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['title', 'description', 'image', 'status'];
    public $translatable = ['title', 'description'];
}
