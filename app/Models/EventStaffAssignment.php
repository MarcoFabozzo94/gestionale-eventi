<?php

namespace App\Models;

use Database\Factories\EventStaffAssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventStaffAssignment extends Model
{
    /** @use HasFactory<EventStaffAssignmentFactory> */
    use HasFactory;

    protected $fillable = [
        'event_id',
        'staff_member_id',
        'staff_role_id',
        'compensation_cents',
        'notes',
    ];

    protected $attributes = [
        'compensation_cents' => 0,
    ];

    protected function casts(): array
    {
        return [
            'compensation_cents' => 'integer',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function staffMember(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class);
    }

    public function staffRole(): BelongsTo
    {
        return $this->belongsTo(StaffRole::class);
    }
}
