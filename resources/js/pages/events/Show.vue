<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Edit, Plus, Trash2 } from '@lucide/vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { destroy, store } from '@/routes/events/assignments';
import { edit, index } from '@/routes/events';
import { formatDate, formatEuro, marginClass } from '@/lib/eventManagement';
import type { EventAssignment, EventSummary, SelectOption } from '@/types';

const props = defineProps<{
    event: EventSummary;
    assignments: EventAssignment[];
    staffMembers: SelectOption[];
    staffRoles: SelectOption[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Eventi', href: index() },
            { title: 'Dettaglio evento', href: '#' },
        ],
    },
});
</script>

<template>
    <Head :title="props.event.title" />

    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <div
            class="flex flex-col justify-between gap-4 md:flex-row md:items-start"
        >
            <div>
                <Link
                    :href="index()"
                    class="mb-4 inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-[var(--fluo-cyan)]"
                >
                    <ArrowLeft class="size-4" />
                    Eventi
                </Link>
                <p
                    class="text-xs font-semibold text-[var(--fluo-cyan)] uppercase"
                >
                    {{ formatDate(props.event.event_date) }} ·
                    {{ props.event.location }}
                </p>
                <h1 class="mt-1 text-2xl font-semibold">
                    {{ props.event.title }}
                </h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    {{ props.event.client_name ?? 'Cliente non indicato' }}
                </p>
            </div>
            <Link
                :href="edit(props.event.id)"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-border px-4 text-sm font-medium transition hover:border-[var(--fluo-lime)] hover:text-[var(--fluo-lime)]"
            >
                <Edit class="size-4" />
                Modifica
            </Link>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-md border border-border bg-card p-4">
                <p class="text-sm text-muted-foreground">Venduto</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ formatEuro(props.event.sold_price_cents) }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <p class="text-sm text-muted-foreground">Costo staff</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ formatEuro(props.event.staff_cost_cents ?? 0) }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <p class="text-sm text-muted-foreground">Margine</p>
                <p
                    class="mt-1 text-2xl font-semibold tabular-nums"
                    :class="marginClass(props.event.margin_cents ?? 0)"
                >
                    {{ formatEuro(props.event.margin_cents ?? 0) }}
                </p>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-[1fr_360px]">
            <section
                class="overflow-hidden rounded-md border border-border bg-card"
            >
                <div class="border-b border-border p-4">
                    <h2 class="text-lg font-semibold">Personale assegnato</h2>
                </div>
                <div
                    class="hidden grid-cols-[1fr_160px_140px_64px] border-b border-border px-4 py-3 text-xs font-semibold text-muted-foreground uppercase md:grid"
                >
                    <span>Persona</span>
                    <span>Ruolo</span>
                    <span class="text-right">Compenso</span>
                    <span class="text-right">Azioni</span>
                </div>
                <div
                    v-if="props.assignments.length"
                    class="divide-y divide-border"
                >
                    <div
                        v-for="assignment in props.assignments"
                        :key="assignment.id"
                        class="grid gap-3 px-4 py-4 md:grid-cols-[1fr_160px_140px_64px] md:items-center"
                    >
                        <div>
                            <p class="font-medium">
                                {{ assignment.staff_member_name }}
                            </p>
                            <p
                                v-if="assignment.notes"
                                class="text-sm text-muted-foreground"
                            >
                                {{ assignment.notes }}
                            </p>
                        </div>
                        <span
                            class="w-fit rounded-md border border-[var(--fluo-cyan)]/60 px-2 py-1 text-xs text-[var(--fluo-cyan)]"
                        >
                            {{ assignment.staff_role_name }}
                        </span>
                        <p class="text-right text-sm font-medium tabular-nums">
                            {{ formatEuro(assignment.compensation_cents) }}
                        </p>
                        <Form
                            v-bind="
                                destroy.form({
                                    event: props.event.id,
                                    assignment: assignment.id,
                                })
                            "
                            class="flex justify-end"
                        >
                            <button
                                type="submit"
                                class="inline-flex size-8 items-center justify-center rounded-md border border-border text-[var(--fluo-red)] hover:border-[var(--fluo-red)]"
                                aria-label="Rimuovi assegnazione"
                            >
                                <Trash2 class="size-4" />
                            </button>
                        </Form>
                    </div>
                </div>
                <div v-else class="p-6 text-sm text-muted-foreground">
                    Nessun membro assegnato a questo evento.
                </div>
            </section>

            <section class="rounded-md border border-border bg-card p-4">
                <h2 class="text-lg font-semibold">Aggiungi persona</h2>
                <Form
                    v-bind="store.form(props.event.id)"
                    class="mt-4 grid gap-4"
                    v-slot="{ errors, processing }"
                >
                    <div class="grid gap-2">
                        <Label for="staff_member_id">Membro staff</Label>
                        <select
                            id="staff_member_id"
                            name="staff_member_id"
                            class="h-10 rounded-md border border-input bg-transparent px-3 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                            required
                        >
                            <option value="">Seleziona persona</option>
                            <option
                                v-for="staffMember in props.staffMembers"
                                :key="staffMember.id"
                                :value="staffMember.id"
                            >
                                {{ staffMember.name }}
                            </option>
                        </select>
                        <InputError :message="errors.staff_member_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="staff_role_id">Ruolo</Label>
                        <select
                            id="staff_role_id"
                            name="staff_role_id"
                            class="h-10 rounded-md border border-input bg-transparent px-3 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                            required
                        >
                            <option value="">Seleziona ruolo</option>
                            <option
                                v-for="role in props.staffRoles"
                                :key="role.id"
                                :value="role.id"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                        <InputError :message="errors.staff_role_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="compensation_euros">Compenso</Label>
                        <Input
                            id="compensation_euros"
                            name="compensation_euros"
                            type="number"
                            step="0.01"
                            min="0"
                            required
                        />
                        <InputError :message="errors.compensation_euros" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="notes">Note</Label>
                        <textarea
                            id="notes"
                            name="notes"
                            class="min-h-20 rounded-md border border-input bg-transparent px-3 py-2 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                        />
                        <InputError :message="errors.notes" />
                    </div>
                    <Button :disabled="processing" class="w-full">
                        <Plus class="size-4" />
                        Aggiungi
                    </Button>
                </Form>
            </section>
        </div>
    </div>
</template>
