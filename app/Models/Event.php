<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'event_date',
        'location',
        'client_name',
        'sold_price_cents',
        'notes',
    ];

    protected $attributes = [
        'sold_price_cents' => 0,
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'sold_price_cents' => 'integer',
        ];
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(EventStaffAssignment::class);
    }

    public function staffMembers(): BelongsToMany
    {
        return $this->belongsToMany(StaffMember::class, 'event_staff_assignments')
            ->withPivot(['staff_role_id', 'compensation_cents', 'notes'])
            ->withTimestamps();
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    public function staffCostCents(): int
    {
        if ($this->relationLoaded('assignments')) {
            return (int) $this->assignments->sum('compensation_cents');
        }

        return (int) $this->assignments()->sum('compensation_cents');
    }

    public function marginCents(): int
    {
        return $this->sold_price_cents - $this->staffCostCents();
    }
}
