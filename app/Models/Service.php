<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
    ];

    public $translatable = ['title', 'description'];

    /**
     * Clothes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clothes()
    {
        return $this->belongsToMany(Cloth::class)->withPivot('cost')->withTimestamps()->withTrashed();
    }

    /**
     * Reservations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class)->withPivot('cost');
    }
}
