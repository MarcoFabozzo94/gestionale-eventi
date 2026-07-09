<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ConvertsEuroAmounts;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventStaffAssignmentRequest extends FormRequest
{
    use ConvertsEuroAmounts;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $event = $this->route('event');
        $eventId = $event instanceof Event ? $event->id : null;

        return [
            'staff_member_id' => ['required', 'integer', Rule::exists('staff_members', 'id')],
            'staff_role_id' => [
                'required',
                'integer',
                Rule::exists('staff_roles', 'id'),
                Rule::unique('event_staff_assignments', 'staff_role_id')
                    ->where('event_id', $eventId)
                    ->where('staff_member_id', $this->integer('staff_member_id')),
            ],
            'compensation_euros' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'staff_role_id.unique' => 'Questa persona ha gia\' questo ruolo per l\'evento selezionato.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function assignmentData(): array
    {
        $validated = $this->validated();

        return [
            'staff_member_id' => $validated['staff_member_id'],
            'staff_role_id' => $validated['staff_role_id'],
            'compensation_cents' => $this->eurosToCents($validated['compensation_euros']),
            'notes' => $validated['notes'] ?? null,
        ];
    }
}
