# Gestionale Eventi MVP Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build the internal admin MVP for managing events, staff, roles, assignments, compensation, and event profitability.

**Architecture:** Add focused Laravel models, migrations, form requests, and Inertia controllers for the event-management domain. Use Vue pages under `resources/js/pages` and the existing authenticated sidebar layout, with a dark squared visual system driven by `resources/css/app.css`.

**Tech Stack:** Laravel 13, Inertia Laravel 3, Vue 3, Tailwind CSS 4, Pest 4, Wayfinder.

## Global Constraints

- Admin-only internal area behind the existing `auth` and `verified` middleware.
- No new dependencies.
- Staff members are not application users in the MVP.
- Store money values as integer cents in the database.
- UI must be squared, functional, dark, and accented with fluo colors.
- Prefer existing UI components and layout conventions.
- Write Pest feature tests for core behavior.

---

### Task 1: Domain Schema and Models

**Files:**
- Create: `database/migrations/2026_07_09_000001_create_event_management_tables.php`
- Create: `app/Models/Event.php`
- Create: `app/Models/StaffMember.php`
- Create: `app/Models/StaffRole.php`
- Create: `app/Models/EventStaffAssignment.php`
- Create: `database/factories/EventFactory.php`
- Create: `database/factories/StaffMemberFactory.php`
- Create: `database/factories/StaffRoleFactory.php`
- Create: `database/factories/EventStaffAssignmentFactory.php`
- Test: `tests/Feature/EventManagementTest.php`

**Interfaces:**
- Produces Eloquent relationships and computed accessors used by controllers:
  - `Event::assignments()`
  - `Event::staffMembers()`
  - `Event::staffCostCents()`
  - `Event::marginCents()`
  - `StaffMember::assignments()`
  - `StaffMember::totalEarnedCents()`

- [ ] Write failing tests for model calculations and relationships.
- [ ] Add migrations, models, casts, factories, and relationship methods.
- [ ] Run `php artisan test --compact tests/Feature/EventManagementTest.php`.

### Task 2: Backend Admin Routes and Controllers

**Files:**
- Modify: `routes/web.php`
- Create: `app/Http/Controllers/Admin/DashboardController.php`
- Create: `app/Http/Controllers/Admin/EventController.php`
- Create: `app/Http/Controllers/Admin/StaffMemberController.php`
- Create: `app/Http/Controllers/Admin/StaffRoleController.php`
- Create: `app/Http/Controllers/Admin/EventStaffAssignmentController.php`
- Create: `app/Http/Requests/Admin/StoreEventRequest.php`
- Create: `app/Http/Requests/Admin/UpdateEventRequest.php`
- Create: `app/Http/Requests/Admin/StoreStaffMemberRequest.php`
- Create: `app/Http/Requests/Admin/UpdateStaffMemberRequest.php`
- Create: `app/Http/Requests/Admin/StoreStaffRoleRequest.php`
- Create: `app/Http/Requests/Admin/UpdateStaffRoleRequest.php`
- Create: `app/Http/Requests/Admin/StoreEventStaffAssignmentRequest.php`
- Create: `app/Http/Requests/Admin/UpdateEventStaffAssignmentRequest.php`
- Test: `tests/Feature/EventManagementTest.php`

**Interfaces:**
- Produces route names:
  - `dashboard`
  - `events.index`, `events.create`, `events.store`, `events.show`, `events.edit`, `events.update`
  - `staff-members.index`, `staff-members.create`, `staff-members.store`, `staff-members.show`, `staff-members.edit`, `staff-members.update`
  - `staff-roles.index`, `staff-roles.create`, `staff-roles.store`, `staff-roles.edit`, `staff-roles.update`
  - `events.assignments.store`, `events.assignments.update`, `events.assignments.destroy`

- [ ] Write failing feature tests for admin pages and core mutations.
- [ ] Add resource controllers and form requests.
- [ ] Run the focused feature tests.

### Task 3: Inertia Pages and Navigation

**Files:**
- Modify: `resources/js/components/NavMain.vue`
- Modify: `resources/js/components/AppSidebar.vue`
- Modify: `resources/js/pages/Dashboard.vue`
- Create: `resources/js/pages/events/Index.vue`
- Create: `resources/js/pages/events/Create.vue`
- Create: `resources/js/pages/events/Edit.vue`
- Create: `resources/js/pages/events/Show.vue`
- Create: `resources/js/pages/staff-members/Index.vue`
- Create: `resources/js/pages/staff-members/Create.vue`
- Create: `resources/js/pages/staff-members/Edit.vue`
- Create: `resources/js/pages/staff-members/Show.vue`
- Create: `resources/js/pages/staff-roles/Index.vue`
- Create: `resources/js/pages/staff-roles/Create.vue`
- Create: `resources/js/pages/staff-roles/Edit.vue`
- Modify: `resources/js/types/index.ts`

**Interfaces:**
- Consumes props returned by admin controllers.
- Produces functional admin screens for dashboard, events, staff members, and roles.

- [ ] Build dense dark admin pages using existing layout and UI components.
- [ ] Use form submissions compatible with Inertia.
- [ ] Keep mobile tables readable.
- [ ] Run `npm run types:check`.

### Task 4: Visual System

**Files:**
- Modify: `resources/css/app.css`

**Interfaces:**
- Produces CSS variables aligned with the design spec and used by Tailwind utility classes.

- [ ] Update app theme variables to the black/fluo direction.
- [ ] Keep existing auth/settings screens readable.
- [ ] Run `npm run build`.

### Task 5: Final Verification

**Files:**
- All changed files.

- [ ] Run `vendor/bin/pint --dirty --format agent`.
- [ ] Run `php artisan test --compact tests/Feature/EventManagementTest.php`.
- [ ] Run `npm run types:check`.
- [ ] Run `npm run build`.
- [ ] If PHP is unavailable, report that backend tests and Pint could not be executed in this session.
