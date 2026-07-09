<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use App\Models\EventStaffAssignment;
use Illuminate\Validation\Rule;

class UpdateEventStaffAssignmentRequest extends StoreEventStaffAssignmentRequest
{
    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $event = $this->route('event');
        $assignment = $this->route('assignment');
        $eventId = $event instanceof Event ? $event->id : null;
        $assignmentId = $assignment instanceof EventStaffAssignment ? $assignment->id : null;

        return [
            'staff_member_id' => ['required', 'integer', Rule::exists('staff_members', 'id')],
            'staff_role_id' => [
                'required',
                'integer',
                Rule::exists('staff_roles', 'id'),
                Rule::unique('event_staff_assignments', 'staff_role_id')
                    ->where('event_id', $eventId)
                    ->where('staff_member_id', $this->integer('staff_member_id'))
                    ->ignore($assignmentId),
            ],
            'compensation_euros' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
