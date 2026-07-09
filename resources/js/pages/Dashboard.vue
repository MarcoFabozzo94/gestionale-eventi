<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { CalendarDays, Euro, Plus, Users } from '@lucide/vue';
import { dashboard } from '@/routes';
import { create as createEvent, show as showEvent } from '@/routes/events';
import { formatDate, formatEuro, marginClass } from '@/lib/eventManagement';
import type { DashboardMetrics, EventSummary } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

defineProps<{
    metrics: DashboardMetrics;
    upcomingEvents: EventSummary[];
    recentEvents: EventSummary[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <div
            class="flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <p
                    class="text-xs font-semibold text-[var(--fluo-cyan)] uppercase"
                >
                    Gestionale eventi
                </p>
                <h1 class="mt-1 text-2xl font-semibold tracking-normal">
                    Controllo operativo
                </h1>
            </div>
            <Link
                :href="createEvent()"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[var(--fluo-lime)] bg-[var(--fluo-lime)] px-4 text-sm font-semibold text-black transition hover:bg-transparent hover:text-[var(--fluo-lime)]"
            >
                <Plus class="size-4" />
                Nuovo evento
            </Link>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-md border border-border bg-card p-4">
                <CalendarDays class="mb-4 size-5 text-[var(--fluo-cyan)]" />
                <p class="text-sm text-muted-foreground">Eventi</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ metrics.events_count }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <Users class="mb-4 size-5 text-[var(--fluo-cyan)]" />
                <p class="text-sm text-muted-foreground">Personale</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ metrics.staff_count }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <Euro class="mb-4 size-5 text-[var(--fluo-lime)]" />
                <p class="text-sm text-muted-foreground">Venduto</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ formatEuro(metrics.sold_total_cents) }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <Euro class="mb-4 size-5 text-[var(--fluo-magenta)]" />
                <p class="text-sm text-muted-foreground">Costo staff</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums">
                    {{ formatEuro(metrics.staff_cost_total_cents) }}
                </p>
            </div>
            <div class="rounded-md border border-border bg-card p-4">
                <Euro class="mb-4 size-5 text-[var(--fluo-lime)]" />
                <p class="text-sm text-muted-foreground">Margine</p>
                <p
                    class="mt-1 text-2xl font-semibold tabular-nums"
                    :class="marginClass(metrics.margin_total_cents)"
                >
                    {{ formatEuro(metrics.margin_total_cents) }}
                </p>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-[1.1fr_0.9fr]">
            <section class="rounded-md border border-border bg-card">
                <div class="border-b border-border p-4">
                    <h2 class="text-lg font-semibold">Prossimi eventi</h2>
                </div>
                <div
                    v-if="upcomingEvents.length"
                    class="divide-y divide-border"
                >
                    <Link
                        v-for="event in upcomingEvents"
                        :key="event.id"
                        :href="showEvent(event.id)"
                        class="grid gap-3 p-4 transition hover:bg-accent md:grid-cols-[1fr_160px_120px]"
                    >
                        <div>
                            <p class="font-medium">{{ event.title }}</p>
                            <p class="text-sm text-muted-foreground">
                                {{ event.location }}
                            </p>
                        </div>
                        <p class="text-sm text-muted-foreground tabular-nums">
                            {{ formatDate(event.event_date) }}
                        </p>
                        <p class="text-right text-sm tabular-nums">
                            {{ formatEuro(event.sold_price_cents) }}
                        </p>
                    </Link>
                </div>
                <div v-else class="p-6 text-sm text-muted-foreground">
                    Nessun evento in programma.
                </div>
            </section>

            <section class="rounded-md border border-border bg-card">
                <div class="border-b border-border p-4">
                    <h2 class="text-lg font-semibold">Ultimi eventi</h2>
                </div>
                <div v-if="recentEvents.length" class="divide-y divide-border">
                    <Link
                        v-for="event in recentEvents"
                        :key="event.id"
                        :href="showEvent(event.id)"
                        class="flex items-center justify-between gap-4 p-4 transition hover:bg-accent"
                    >
                        <div class="min-w-0">
                            <p class="truncate font-medium">
                                {{ event.title }}
                            </p>
                            <p class="text-sm text-muted-foreground">
                                {{ formatDate(event.event_date) }} ·
                                {{ event.assignments_count ?? 0 }} persone
                            </p>
                        </div>
                        <p class="text-sm tabular-nums">
                            {{ formatEuro(event.sold_price_cents) }}
                        </p>
                    </Link>
                </div>
                <div v-else class="p-6 text-sm text-muted-foreground">
                    Crea il primo evento per vedere lo storico.
                </div>
            </section>
        </div>
    </div>
</template>
