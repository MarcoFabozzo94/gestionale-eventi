<?php

use App\Models\Event;
use App\Models\EventStaffAssignment;
use App\Models\StaffMember;
use App\Models\StaffRole;
use App\Models\User;

test('guest users cannot access the event management dashboard', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('authenticated admins can visit the event management dashboard', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('dashboard'));

    $response->assertOk();
});

test('admin can create an event with a sold price', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('events.store'), [
            'title' => 'Corporate Launch',
            'event_date' => '2026-09-12',
            'location' => 'Milano',
            'client_name' => 'Acme Srl',
            'sold_price_euros' => '2500.00',
            'notes' => 'Evento serale.',
        ]);

    $event = Event::query()->first();

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('events.show', $event));

    expect($event)
        ->title->toBe('Corporate Launch')
        ->sold_price_cents->toBe(250000);
});

test('admin can assign a staff member to an event with role and compensation', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create(['sold_price_cents' => 250000]);
    $staffMember = StaffMember::factory()->create();
    $staffRole = StaffRole::factory()->create(['name' => 'Steward']);

    $response = $this
        ->actingAs($user)
        ->post(route('events.assignments.store', $event), [
            'staff_member_id' => $staffMember->id,
            'staff_role_id' => $staffRole->id,
            'compensation_euros' => '120.00',
            'notes' => 'Turno completo.',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('events.show', $event));

    $assignment = EventStaffAssignment::query()->first();

    expect($assignment)
        ->event_id->toBe($event->id)
        ->staff_member_id->toBe($staffMember->id)
        ->staff_role_id->toBe($staffRole->id)
        ->compensation_cents->toBe(12000);
});

test('admin sees a validation error when assigning the same staff member with the same role twice', function () {
    $user = User::factory()->create();
    $event = Event::factory()->create();
    $staffMember = StaffMember::factory()->create();
    $staffRole = StaffRole::factory()->create();

    EventStaffAssignment::factory()
        ->for($event)
        ->for($staffMember)
        ->for($staffRole, 'staffRole')
        ->create();

    $response = $this
        ->actingAs($user)
        ->from(route('events.show', $event))
        ->post(route('events.assignments.store', $event), [
            'staff_member_id' => $staffMember->id,
            'staff_role_id' => $staffRole->id,
            'compensation_euros' => '900.00',
            'notes' => null,
        ]);

    $response
        ->assertSessionHasErrors('staff_role_id')
        ->assertRedirect(route('events.show', $event));

    expect(EventStaffAssignment::query()->count())->toBe(1);
});

test('event financial totals are calculated from assignments', function () {
    $event = Event::factory()->create(['sold_price_cents' => 250000]);
    EventStaffAssignment::factory()->for($event)->create(['compensation_cents' => 12000]);
    EventStaffAssignment::factory()->for($event)->create(['compensation_cents' => 25000]);

    expect($event->staffCostCents())->toBe(37000);
    expect($event->marginCents())->toBe(213000);
});

test('staff profile includes event history and total earned', function () {
    $user = User::factory()->create();
    $staffMember = StaffMember::factory()->create();
    $role = StaffRole::factory()->create(['name' => 'Coordinator']);
    $event = Event::factory()->create([
        'title' => 'Fashion Week',
        'event_date' => '2026-10-02',
        'location' => 'Roma',
    ]);

    EventStaffAssignment::factory()
        ->for($event)
        ->for($staffMember)
        ->for($role, 'staffRole')
        ->create(['compensation_cents' => 30000]);

    $response = $this
        ->actingAs($user)
        ->get(route('staff-members.show', $staffMember));

    $response->assertOk();

    expect($staffMember->totalEarnedCents())->toBe(30000);
});
