<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $fillable = ['reservation_id','review_text', 'score'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
