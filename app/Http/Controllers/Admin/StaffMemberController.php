<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffMemberRequest;
use App\Http\Requests\Admin\UpdateStaffMemberRequest;
use App\Models\StaffMember;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StaffMemberController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('staff-members/Index', [
            'staffMembers' => StaffMember::query()
                ->with('assignments')
                ->withCount('assignments')
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get()
                ->map(fn (StaffMember $staffMember): array => $this->staffMemberPayload($staffMember)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('staff-members/Create');
    }

    public function store(StoreStaffMemberRequest $request): RedirectResponse
    {
        $staffMember = StaffMember::query()->create($request->staffMemberData());

        return redirect()->route('staff-members.show', $staffMember);
    }

    public function show(StaffMember $staffMember): Response
    {
        $staffMember->load(['assignments.event', 'assignments.staffRole']);

        return Inertia::render('staff-members/Show', [
            'staffMember' => $this->staffMemberPayload($staffMember),
            'history' => $staffMember->assignments
                ->sortByDesc(fn ($assignment): string => $assignment->event->event_date?->toDateString() ?? '')
                ->values()
                ->map(fn ($assignment): array => [
                    'id' => $assignment->id,
                    'event_id' => $assignment->event_id,
                    'event_title' => $assignment->event->title,
                    'event_date' => $assignment->event->event_date?->toDateString(),
                    'location' => $assignment->event->location,
                    'role_name' => $assignment->staffRole->name,
                    'compensation_cents' => $assignment->compensation_cents,
                ]),
        ]);
    }

    public function edit(StaffMember $staffMember): Response
    {
        return Inertia::render('staff-members/Edit', [
            'staffMember' => $this->staffMemberPayload($staffMember),
        ]);
    }

    public function update(UpdateStaffMemberRequest $request, StaffMember $staffMember): RedirectResponse
    {
        $staffMember->update($request->staffMemberData());

        return redirect()->route('staff-members.show', $staffMember);
    }

    /**
     * @return array<string, mixed>
     */
    private function staffMemberPayload(StaffMember $staffMember): array
    {
        return [
            'id' => $staffMember->id,
            'first_name' => $staffMember->first_name,
            'last_name' => $staffMember->last_name,
            'name' => $staffMember->fullName(),
            'email' => $staffMember->email,
            'phone' => $staffMember->phone,
            'is_active' => $staffMember->is_active,
            'notes' => $staffMember->notes,
            'assignments_count' => $staffMember->assignments_count ?? $staffMember->assignments()->count(),
            'total_earned_cents' => $staffMember->totalEarnedCents(),
        ];
    }
}
