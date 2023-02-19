<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Cloth extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    protected $table = "clothes";

    protected $fillable = [
        'title',
        'description',
        'cost',
        'image',
        'status',
    ];

    public $translatable = ['title', 'description'];

    /**
     * Services
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('cost')->withTimestamps()->withTrashed();
    }
}
