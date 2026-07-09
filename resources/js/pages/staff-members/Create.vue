<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Save } from '@lucide/vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, store } from '@/routes/staff-members';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Personale', href: index() },
            { title: 'Nuova persona', href: '#' },
        ],
    },
});
</script>

<template>
    <Head title="Nuova persona" />

    <div class="max-w-3xl p-4 md:p-6">
        <Link
            :href="index()"
            class="mb-6 inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-[var(--fluo-cyan)]"
        >
            <ArrowLeft class="size-4" />
            Personale
        </Link>

        <section class="rounded-md border border-border bg-card p-5">
            <h1 class="text-2xl font-semibold">Nuova persona</h1>

            <Form
                v-bind="store.form()"
                class="mt-6 grid gap-5"
                v-slot="{ errors, processing }"
            >
                <input type="hidden" name="is_active" value="0" />
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="first_name">Nome</Label>
                        <Input id="first_name" name="first_name" required />
                        <InputError :message="errors.first_name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="last_name">Cognome</Label>
                        <Input id="last_name" name="last_name" required />
                        <InputError :message="errors.last_name" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" name="email" />
                        <InputError :message="errors.email" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="phone">Telefono</Label>
                        <Input id="phone" name="phone" />
                        <InputError :message="errors.phone" />
                    </div>
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
                <div class="grid gap-2">
                    <Label for="notes">Note</Label>
                    <textarea
                        id="notes"
                        name="notes"
                        class="min-h-24 rounded-md border border-input bg-transparent px-3 py-2 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                    />
                    <InputError :message="errors.notes" />
                </div>
                <Button :disabled="processing" class="w-fit">
                    <Save class="size-4" />
                    Salva persona
                </Button>
            </Form>
        </section>
    </div>
</template>
