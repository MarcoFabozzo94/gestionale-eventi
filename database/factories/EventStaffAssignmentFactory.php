<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventStaffAssignment;
use App\Models\StaffMember;
use App\Models\StaffRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventStaffAssignment>
 */
class EventStaffAssignmentFactory extends Factory
{
    protected $model = EventStaffAssignment::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'staff_member_id' => StaffMember::factory(),
            'staff_role_id' => StaffRole::factory(),
            'compensation_cents' => fake()->numberBetween(8000, 40000),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
