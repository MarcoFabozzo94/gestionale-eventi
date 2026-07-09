<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ConvertsEuroAmounts;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    use ConvertsEuroAmounts;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'sold_price_euros' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function eventData(): array
    {
        $validated = $this->validated();

        return [
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'client_name' => $validated['client_name'] ?? null,
            'sold_price_cents' => $this->eurosToCents($validated['sold_price_euros']),
            'notes' => $validated['notes'] ?? null,
        ];
    }
}
