<?php

namespace App\Http\Requests\Admin;

use App\Models\StaffRole;
use Illuminate\Validation\Rule;

class UpdateStaffRoleRequest extends StoreStaffRoleRequest
{
    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $staffRole = $this->route('staff_role');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('staff_roles', 'name')->ignore($staffRole instanceof StaffRole ? $staffRole->id : null),
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
