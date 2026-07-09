<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Edit, Eye, Plus } from '@lucide/vue';
import { create, edit, index, show } from '@/routes/events';
import { formatDate, formatEuro, marginClass } from '@/lib/eventManagement';
import type { EventSummary } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Eventi', href: index() }],
    },
});

defineProps<{
    events: EventSummary[];
}>();
</script>

<template>
    <Head title="Eventi" />

    <div class="flex flex-1 flex-col gap-6 p-4 md:p-6">
        <div
            class="flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <p
                    class="text-xs font-semibold text-[var(--fluo-cyan)] uppercase"
                >
                    Operazioni
                </p>
                <h1 class="mt-1 text-2xl font-semibold">Eventi</h1>
            </div>
            <Link
                :href="create()"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-md border border-[var(--fluo-lime)] bg-[var(--fluo-lime)] px-4 text-sm font-semibold text-black transition hover:bg-transparent hover:text-[var(--fluo-lime)]"
            >
                <Plus class="size-4" />
                Nuovo evento
            </Link>
        </div>

        <section
            class="overflow-hidden rounded-md border border-border bg-card"
        >
            <div
                class="hidden grid-cols-[1fr_150px_180px_130px_130px_96px] border-b border-border px-4 py-3 text-xs font-semibold text-muted-foreground uppercase md:grid"
            >
                <span>Evento</span>
                <span>Data</span>
                <span>Luogo</span>
                <span class="text-right">Venduto</span>
                <span class="text-right">Margine</span>
                <span class="text-right">Azioni</span>
            </div>
            <div v-if="events.length" class="divide-y divide-border">
                <div
                    v-for="event in events"
                    :key="event.id"
                    class="grid gap-3 px-4 py-4 md:grid-cols-[1fr_150px_180px_130px_130px_96px] md:items-center"
                >
                    <div>
                        <p class="font-medium">{{ event.title }}</p>
                        <p class="text-sm text-muted-foreground">
                            {{ event.client_name ?? 'Cliente non indicato' }}
                        </p>
                    </div>
                    <p class="text-sm text-muted-foreground tabular-nums">
                        {{ formatDate(event.event_date) }}
                    </p>
                    <p class="text-sm">{{ event.location }}</p>
                    <p class="text-right text-sm tabular-nums">
                        {{ formatEuro(event.sold_price_cents) }}
                    </p>
                    <p
                        class="text-right text-sm font-medium tabular-nums"
                        :class="marginClass(event.margin_cents ?? 0)"
                    >
                        {{ formatEuro(event.margin_cents ?? 0) }}
                    </p>
                    <div class="flex justify-end gap-2">
                        <Link
                            :href="show(event.id)"
                            class="inline-flex size-8 items-center justify-center rounded-md border border-border hover:border-[var(--fluo-cyan)] hover:text-[var(--fluo-cyan)]"
                            aria-label="Apri evento"
                        >
                            <Eye class="size-4" />
                        </Link>
                        <Link
                            :href="edit(event.id)"
                            class="inline-flex size-8 items-center justify-center rounded-md border border-border hover:border-[var(--fluo-lime)] hover:text-[var(--fluo-lime)]"
                            aria-label="Modifica evento"
                        >
                            <Edit class="size-4" />
                        </Link>
                    </div>
                </div>
            </div>
            <div v-else class="p-6">
                <p class="text-sm text-muted-foreground">
                    Nessun evento creato.
                </p>
            </div>
        </section>
    </div>
</template>
