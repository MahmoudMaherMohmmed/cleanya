<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'reservations';
    protected $fillable = ['client_id', 'representative_id', 'reception_address_id', 'reception_date', 'reception_time', 'sending_address_id', 'sending_date', 'sending_time', 'delivery_cost', 'pieces_price', 'coupon', 'discount', 'price_after_discount', 'tax', 'tax_amount', 'total_price', 'payment_type', 'transaction_id', 'client_approve', 'status'];

    /**
     * Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Representative
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representative()
    {
        return $this->belongsTo(Client::class, 'representative_id');
    }

    /**
     * Reception address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reception_address()
    {
        return $this->belongsTo(Address::class, 'reception_address_id');
    }

    /**
     * Sending address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sending_address()
    {
        return $this->belongsTo(Address::class, 'sending_address_id');
    }

    /**
     * Items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    /**
     * Review
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
