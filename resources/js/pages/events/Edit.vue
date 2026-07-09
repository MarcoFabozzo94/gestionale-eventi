<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Save } from '@lucide/vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { centsToEuros } from '@/lib/eventManagement';
import { show, update } from '@/routes/events';
import type { EventSummary } from '@/types';

const props = defineProps<{
    event: EventSummary;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Modifica evento', href: '#' }],
    },
});
</script>

<template>
    <Head title="Modifica evento" />

    <div class="max-w-3xl p-4 md:p-6">
        <Link
            :href="show(props.event.id)"
            class="mb-6 inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-[var(--fluo-cyan)]"
        >
            <ArrowLeft class="size-4" />
            Dettaglio evento
        </Link>

        <section class="rounded-md border border-border bg-card p-5">
            <h1 class="text-2xl font-semibold">Modifica evento</h1>

            <Form
                v-bind="update.form(props.event.id)"
                class="mt-6 grid gap-5"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="title">Titolo evento</Label>
                    <Input
                        id="title"
                        name="title"
                        :default-value="props.event.title"
                        required
                    />
                    <InputError :message="errors.title" />
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="event_date">Data</Label>
                        <Input
                            id="event_date"
                            type="date"
                            name="event_date"
                            :default-value="props.event.event_date"
                            required
                        />
                        <InputError :message="errors.event_date" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="location">Luogo</Label>
                        <Input
                            id="location"
                            name="location"
                            :default-value="props.event.location"
                            required
                        />
                        <InputError :message="errors.location" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="client_name">Cliente</Label>
                        <Input
                            id="client_name"
                            name="client_name"
                            :default-value="props.event.client_name ?? ''"
                        />
                        <InputError :message="errors.client_name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="sold_price_euros">Venduto al cliente</Label>
                        <Input
                            id="sold_price_euros"
                            type="number"
                            step="0.01"
                            min="0"
                            name="sold_price_euros"
                            :default-value="
                                centsToEuros(props.event.sold_price_cents)
                            "
                            required
                        />
                        <InputError :message="errors.sold_price_euros" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <Label for="notes">Note</Label>
                    <textarea
                        id="notes"
                        name="notes"
                        :value="props.event.notes ?? ''"
                        class="min-h-28 rounded-md border border-input bg-transparent px-3 py-2 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    />
                    <InputError :message="errors.notes" />
                </div>
                <Button :disabled="processing" class="w-fit">
                    <Save class="size-4" />
                    Salva modifiche
                </Button>
            </Form>
        </section>
    </div>
</template>
