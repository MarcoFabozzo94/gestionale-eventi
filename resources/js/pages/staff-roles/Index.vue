<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Edit, Plus } from '@lucide/vue';
import { create, edit, index } from '@/routes/staff-roles';
import type { StaffRoleSummary } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Ruoli', href: index() }],
    },
});

defineProps<{
    staffRoles: StaffRoleSummary[];
}>();
</script>

<template>
    <Head title="Ruoli" />

    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <div
            class="flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <p
                    class="text-xs font-semibold text-[var(--fluo-cyan)] uppercase"
                >
                    Catalogo
                </p>
                <h1 class="mt-1 text-2xl font-semibold">Ruoli</h1>
            </div>
            <Link
                :href="create()"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[var(--fluo-lime)] bg-[var(--fluo-lime)] px-4 text-sm font-semibold text-black transition hover:bg-transparent hover:text-[var(--fluo-lime)]"
            >
                <Plus class="size-4" />
                Nuovo ruolo
            </Link>
        </div>

        <section
            class="overflow-hidden rounded-md border border-border bg-card"
        >
            <div
                class="hidden grid-cols-[1fr_140px_140px_64px] border-b border-border px-4 py-3 text-xs font-semibold text-muted-foreground uppercase md:grid"
            >
                <span>Ruolo</span>
                <span>Stato</span>
                <span class="text-right">Utilizzi</span>
                <span class="text-right">Azioni</span>
            </div>
            <div v-if="staffRoles.length" class="divide-y divide-border">
                <div
                    v-for="role in staffRoles"
                    :key="role.id"
                    class="grid gap-3 px-4 py-4 md:grid-cols-[1fr_140px_140px_64px] md:items-center"
                >
                    <div>
                        <p class="font-medium">{{ role.name }}</p>
                        <p class="text-sm text-muted-foreground">
                            {{ role.description ?? 'Nessuna descrizione' }}
                        </p>
                    </div>
                    <span
                        class="w-fit rounded-md border px-2 py-1 text-xs"
                        :class="
                            role.is_active
                                ? 'border-[var(--fluo-lime)]/70 text-[var(--fluo-lime)]'
                                : 'border-border text-muted-foreground'
                        "
                    >
                        {{ role.is_active ? 'Attivo' : 'Inattivo' }}
                    </span>
                    <p class="text-right text-sm tabular-nums">
                        {{ role.assignments_count ?? 0 }}
                    </p>
                    <div class="flex justify-end">
                        <Link
                            :href="edit(role.id)"
                            class="inline-flex size-8 items-center justify-center rounded-md border border-border hover:border-[var(--fluo-lime)] hover:text-[var(--fluo-lime)]"
                            aria-label="Modifica ruolo"
                        >
                            <Edit class="size-4" />
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else class="p-6 text-sm text-muted-foreground">
                Nessun ruolo creato.
            </div>
        </section>
    </div>
</template>
