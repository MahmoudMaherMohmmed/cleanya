<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    protected $table = 'reservation_items';
    protected $fillable = ['reservation_id', 'service_id', 'cloth_id', 'piece_cost', 'pieces_number', 'cost'];

    /**
     * Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'client_id');
    }

    /**
     * Service
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Cloth
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cloth()
    {
        return $this->belongsTo(Cloth::class, 'cloth_id');
    }
}
