<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventStaffAssignmentRequest;
use App\Http\Requests\Admin\UpdateEventStaffAssignmentRequest;
use App\Models\Event;
use App\Models\EventStaffAssignment;
use Illuminate\Http\RedirectResponse;

class EventStaffAssignmentController extends Controller
{
    public function store(StoreEventStaffAssignmentRequest $request, Event $event): RedirectResponse
    {
        $event->assignments()->create($request->assignmentData());

        return redirect()->route('events.show', $event);
    }

    public function update(
        UpdateEventStaffAssignmentRequest $request,
        Event $event,
        EventStaffAssignment $assignment
    ): RedirectResponse {
        abort_unless($assignment->event()->is($event), 404);

        $assignment->update($request->assignmentData());

        return redirect()->route('events.show', $event);
    }

    public function destroy(Event $event, EventStaffAssignment $assignment): RedirectResponse
    {
        abort_unless($assignment->event()->is($event), 404);

        $assignment->delete();

        return redirect()->route('events.show', $event);
    }
}
