<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'check_in',
        'check_out',
        'nb_guests',
        'total_price',
        'status',
        'user_id',
        'accommodation_id',
        'special_requests',
        'cancellation_reason',
    ];

    /**
     * Accessor: number of nights between check-in and check-out.
     */
    public function getNbNightsAttribute(): int
    {
        if (! $this->check_in || ! $this->check_out) {
            return 0;
        }

        return \Carbon\Carbon::parse($this->check_in)
            ->diffInDays(\Carbon\Carbon::parse($this->check_out));
    }

    /**
     * Casts for date attributes so they are Carbon instances in views.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
