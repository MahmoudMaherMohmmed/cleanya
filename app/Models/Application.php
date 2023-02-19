<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Application extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['title', 'description', 'working_days', 'from', 'to', 'tax', 'email_1', 'email_2', 'phone_1', 'phone_2', 'facebook_link', 'whatsapp_link', 'twitter_link', 'instagram_link', 'snapchat_link', 'youtube_link', 'linkedin_link', 'tiktok_link', 'api_url', 'api_key', 'api_username', 'api_password', 'soft_opening', 'lat', 'lng', 'logo'];
    public $translatable = ['title', 'description'];
}
