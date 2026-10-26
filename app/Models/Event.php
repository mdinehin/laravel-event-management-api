<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    /**
     * Define Event-User relationship.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define Event-Attendees relationship.
     *
     * @return HasMany<Attendee, $this>
     */
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
