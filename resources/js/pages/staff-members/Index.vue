<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Edit, Eye, Plus } from '@lucide/vue';
import { create, edit, index, show } from '@/routes/staff-members';
import { formatEuro } from '@/lib/eventManagement';
import type { StaffMemberSummary } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Personale', href: index() }],
    },
});

defineProps<{
    staffMembers: StaffMemberSummary[];
}>();
</script>

<template>
    <Head title="Personale" />

    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <div
            class="flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <p
                    class="text-xs font-semibold text-[var(--fluo-cyan)] uppercase"
                >
                    Anagrafica
                </p>
                <h1 class="mt-1 text-2xl font-semibold">Personale</h1>
            </div>
            <Link
                :href="create()"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[var(--fluo-lime)] bg-[var(--fluo-lime)] px-4 text-sm font-semibold text-black transition hover:bg-transparent hover:text-[var(--fluo-lime)]"
            >
                <Plus class="size-4" />
                Nuova persona
            </Link>
        </div>

        <section
            class="overflow-hidden rounded-md border border-border bg-card"
        >
            <div
                class="hidden grid-cols-[1fr_150px_150px_150px_96px] border-b border-border px-4 py-3 text-xs font-semibold text-muted-foreground uppercase md:grid"
            >
                <span>Persona</span>
                <span>Stato</span>
                <span class="text-right">Eventi</span>
                <span class="text-right">Guadagnato</span>
                <span class="text-right">Azioni</span>
            </div>
            <div v-if="staffMembers.length" class="divide-y divide-border">
                <div
                    v-for="staffMember in staffMembers"
                    :key="staffMember.id"
                    class="grid gap-3 px-4 py-4 md:grid-cols-[1fr_150px_150px_150px_96px] md:items-center"
                >
                    <div>
                        <p class="font-medium">{{ staffMember.name }}</p>
                        <p class="text-sm text-muted-foreground">
                            {{
                                staffMember.email ??
                                staffMember.phone ??
                                'Contatto non indicato'
                            }}
                        </p>
                    </div>
                    <span
                        class="w-fit rounded-md border px-2 py-1 text-xs"
                        :class="
                            staffMember.is_active
                                ? 'border-[var(--fluo-lime)]/70 text-[var(--fluo-lime)]'
                                : 'border-border text-muted-foreground'
                        "
                    >
                        {{ staffMember.is_active ? 'Attivo' : 'Inattivo' }}
                    </span>
                    <p class="text-right text-sm tabular-nums">
                        {{ staffMember.assignments_count }}
                    </p>
                    <p class="text-right text-sm font-medium tabular-nums">
                        {{ formatEuro(staffMember.total_earned_cents) }}
                    </p>
                    <div class="flex justify-end gap-2">
                        <Link
                            :href="show(staffMember.id)"
                            class="inline-flex size-8 items-center justify-center rounded-md border border-border hover:border-[var(--fluo-cyan)] hover:text-[var(--fluo-cyan)]"
                            aria-label="Apri profilo"
                        >
                            <Eye class="size-4" />
                        </Link>
                        <Link
                            :href="edit(staffMember.id)"
                            class="inline-flex size-8 items-center justify-center rounded-md border border-border hover:border-[var(--fluo-lime)] hover:text-[var(--fluo-lime)]"
                            aria-label="Modifica persona"
                        >
                            <Edit class="size-4" />
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else class="p-6 text-sm text-muted-foreground">
                Nessun membro del personale creato.
            </div>
        </section>
    </div>
</template>
