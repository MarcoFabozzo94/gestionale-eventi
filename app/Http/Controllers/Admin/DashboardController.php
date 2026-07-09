<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventStaffAssignment;
use App\Models\StaffMember;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $events = Event::query()->with('assignments')->get();

        return Inertia::render('Dashboard', [
            'metrics' => [
                'events_count' => $events->count(),
                'staff_count' => StaffMember::query()->count(),
                'sold_total_cents' => (int) $events->sum('sold_price_cents'),
                'staff_cost_total_cents' => (int) EventStaffAssignment::query()->sum('compensation_cents'),
                'margin_total_cents' => (int) $events->sum(fn (Event $event): int => $event->marginCents()),
            ],
            'upcomingEvents' => Event::query()
                ->upcoming()
                ->withCount('assignments')
                ->orderBy('event_date')
                ->limit(5)
                ->get()
                ->map(fn (Event $event): array => $this->eventSummary($event)),
            'recentEvents' => Event::query()
                ->withCount('assignments')
                ->latest('event_date')
                ->limit(6)
                ->get()
                ->map(fn (Event $event): array => $this->eventSummary($event)),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function eventSummary(Event $event): array
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'event_date' => $event->event_date?->toDateString(),
            'location' => $event->location,
            'client_name' => $event->client_name,
            'sold_price_cents' => $event->sold_price_cents,
            'assignments_count' => $event->assignments_count ?? 0,
        ];
    }
}
