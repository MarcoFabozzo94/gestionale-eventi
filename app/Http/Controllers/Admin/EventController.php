<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use App\Models\StaffMember;
use App\Models\StaffRole;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('events/Index', [
            'events' => Event::query()
                ->with('assignments')
                ->orderBy('event_date')
                ->get()
                ->map(fn (Event $event): array => $this->eventPayload($event)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('events/Create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = Event::query()->create($request->eventData());

        return redirect()->route('events.show', $event);
    }

    public function show(Event $event): Response
    {
        $event->load(['assignments.staffMember', 'assignments.staffRole']);

        return Inertia::render('events/Show', [
            'event' => $this->eventPayload($event),
            'assignments' => $event->assignments->map(fn ($assignment): array => [
                'id' => $assignment->id,
                'staff_member_id' => $assignment->staff_member_id,
                'staff_member_name' => $assignment->staffMember->fullName(),
                'staff_role_id' => $assignment->staff_role_id,
                'staff_role_name' => $assignment->staffRole->name,
                'compensation_cents' => $assignment->compensation_cents,
                'notes' => $assignment->notes,
            ]),
            'staffMembers' => StaffMember::query()->active()->orderBy('last_name')->orderBy('first_name')->get()->map(fn (StaffMember $staffMember): array => [
                'id' => $staffMember->id,
                'name' => $staffMember->fullName(),
            ]),
            'staffRoles' => StaffRole::query()->active()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function edit(Event $event): Response
    {
        return Inertia::render('events/Edit', [
            'event' => $this->eventPayload($event),
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->eventData());

        return redirect()->route('events.show', $event);
    }

    /**
     * @return array<string, mixed>
     */
    private function eventPayload(Event $event): array
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'event_date' => $event->event_date?->toDateString(),
            'location' => $event->location,
            'client_name' => $event->client_name,
            'sold_price_cents' => $event->sold_price_cents,
            'staff_cost_cents' => $event->staffCostCents(),
            'margin_cents' => $event->marginCents(),
            'notes' => $event->notes,
        ];
    }
}
