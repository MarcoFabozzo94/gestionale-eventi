<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Edit } from '@lucide/vue';
import { show as showEvent } from '@/routes/events';
import { edit, index } from '@/routes/staff-members';
import { formatDate, formatEuro } from '@/lib/eventManagement';
import type { StaffHistoryItem, StaffMemberSummary } from '@/types';

const props = defineProps<{
    staffMember: StaffMemberSummary;
    history: StaffHistoryItem[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Personale', href: index() },
            { title: 'Profilo', href: '#' },
        ],
    },
});
</script>

<template>
    <Head :title="props.staffMember.name" />

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
                    Personale
                </Link>
                <p
                    class="text-xs font-semibold text-[var(--fluo-cyan)] uppercase"
                >
                    Profilo staff
                </p>
                <h1 class="mt-1 text-2xl font-semibold">
                    {{ props.staffMember.name }}
                </h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    {{ props.staffMember.email ?? 'Email non indicata' }} ·
                    {{ props.staffMember.phone ?? 'Telefono non indicato' }}
                </p>
            </div>
            <Link
                :href="edit(props.staffMember.id)"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-border px-4 text-sm font-medium transition hover:border-[var(--fluo-lime)] hover:text-[var(--fluo-lime)]"
            >
                <Edit class="size-4" />
                Modifica
            </Link>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-md border border-border bg-card p-4">
                <p class="text-sm text-muted-foreground">Eventi fatti</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ props.staffMember.assignments_count }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <p class="text-sm text-muted-foreground">Totale guadagnato</p>
                <p
                    class="mt-1 text-2xl font-semibold text-[var(--fluo-lime)] tabular-nums"
                >
                    {{ formatEuro(props.staffMember.total_earned_cents) }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <p class="text-sm text-muted-foreground">Stato</p>
                <p class="mt-1 text-2xl font-semibold">
                    {{ props.staffMember.is_active ? 'Attivo' : 'Inattivo' }}
                </p>
            </div>
        </div>

        <section
            class="overflow-hidden rounded-md border border-border bg-card"
        >
            <div class="border-b border-border p-4">
                <h2 class="text-lg font-semibold">Storico eventi</h2>
            </div>
            <div
                class="hidden grid-cols-[1fr_150px_180px_140px_130px] border-b border-border px-4 py-3 text-xs font-semibold text-muted-foreground uppercase md:grid"
            >
                <span>Evento</span>
                <span>Data</span>
                <span>Luogo</span>
                <span>Ruolo</span>
                <span class="text-right">Compenso</span>
            </div>
            <div v-if="props.history.length" class="divide-y divide-border">
                <Link
                    v-for="item in props.history"
                    :key="item.id"
                    :href="showEvent(item.event_id)"
                    class="grid gap-3 px-4 py-4 transition hover:bg-accent md:grid-cols-[1fr_150px_180px_140px_130px] md:items-center"
                >
                    <p class="font-medium">{{ item.event_title }}</p>
                    <p class="text-sm text-muted-foreground tabular-nums">
                        {{ formatDate(item.event_date) }}
                    </p>
                    <p class="text-sm">{{ item.location }}</p>
                    <span
                        class="w-fit rounded-md border border-[var(--fluo-cyan)]/60 px-2 py-1 text-xs text-[var(--fluo-cyan)]"
                    >
                        {{ item.role_name }}
                    </span>
                    <p class="text-right text-sm font-medium tabular-nums">
                        {{ formatEuro(item.compensation_cents) }}
                    </p>
                </Link>
            </div>
            <div v-else class="p-6 text-sm text-muted-foreground">
                Questa persona non e' ancora stata assegnata a eventi.
            </div>
        </section>
    </div>
</template>
