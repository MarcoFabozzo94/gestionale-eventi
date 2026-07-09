<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Save } from '@lucide/vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, store } from '@/routes/staff-roles';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Ruoli', href: index() },
            { title: 'Nuovo ruolo', href: '#' },
        ],
    },
});
</script>

<template>
    <Head title="Nuovo ruolo" />

    <div class="max-w-2xl p-4 md:p-6">
        <Link
            :href="index()"
            class="mb-6 inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-[var(--fluo-cyan)]"
        >
            <ArrowLeft class="size-4" />
            Ruoli
        </Link>
        <section class="rounded-md border border-border bg-card p-5">
            <h1 class="text-2xl font-semibold">Nuovo ruolo</h1>
            <Form
                v-bind="store.form()"
                class="mt-6 grid gap-5"
                v-slot="{ errors, processing }"
            >
                <input type="hidden" name="is_active" value="0" />
                <div class="grid gap-2">
                    <Label for="name">Nome ruolo</Label>
                    <Input id="name" name="name" required />
                    <InputError :message="errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="description">Descrizione</Label>
                    <textarea
                        id="description"
                        name="description"
                        class="min-h-24 rounded-md border border-input bg-transparent px-3 py-2 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    />
                    <InputError :message="errors.description" />
                </div>
                <label class="flex items-center gap-3 text-sm">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                        class="size-4 rounded border-input bg-transparent accent-[var(--fluo-lime)]"
                    />
                    Attivo
                </label>
                <Button :disabled="processing" class="w-fit">
                    <Save class="size-4" />
                    Salva ruolo
                </Button>
            </Form>
        </section>
    </div>
</template>
