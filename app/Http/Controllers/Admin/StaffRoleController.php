<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffRoleRequest;
use App\Http\Requests\Admin\UpdateStaffRoleRequest;
use App\Models\StaffRole;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StaffRoleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('staff-roles/Index', [
            'staffRoles' => StaffRole::query()
                ->withCount('assignments')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('staff-roles/Create');
    }

    public function store(StoreStaffRoleRequest $request): RedirectResponse
    {
        StaffRole::query()->create($request->staffRoleData());

        return redirect()->route('staff-roles.index');
    }

    public function edit(StaffRole $staffRole): Response
    {
        return Inertia::render('staff-roles/Edit', [
            'staffRole' => $staffRole,
        ]);
    }

    public function update(UpdateStaffRoleRequest $request, StaffRole $staffRole): RedirectResponse
    {
        $staffRole->update($request->staffRoleData());

        return redirect()->route('staff-roles.index');
    }
}
