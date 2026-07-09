<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Save } from '@lucide/vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { show, update } from '@/routes/staff-members';
import type { StaffMemberSummary } from '@/types';

const props = defineProps<{
    staffMember: StaffMemberSummary;
}>();

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Modifica persona', href: '#' }],
    },
});
</script>

<template>
    <Head title="Modifica persona" />

    <div class="max-w-3xl p-4 md:p-6">
        <Link
            :href="show(props.staffMember.id)"
            class="mb-6 inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-[var(--fluo-cyan)]"
        >
            <ArrowLeft class="size-4" />
            Profilo
        </Link>

        <section class="rounded-md border border-border bg-card p-5">
            <h1 class="text-2xl font-semibold">Modifica persona</h1>

            <Form
                v-bind="update.form(props.staffMember.id)"
                class="mt-6 grid gap-5"
                v-slot="{ errors, processing }"
            >
                <input type="hidden" name="is_active" value="0" />
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="first_name">Nome</Label>
                        <Input
                            id="first_name"
                            name="first_name"
                            :default-value="props.staffMember.first_name"
                            required
                        />
                        <InputError :message="errors.first_name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="last_name">Cognome</Label>
                        <Input
                            id="last_name"
                            name="last_name"
                            :default-value="props.staffMember.last_name"
                            required
                        />
                        <InputError :message="errors.last_name" />
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            :default-value="props.staffMember.email ?? ''"
                        />
                        <InputError :message="errors.email" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="phone">Telefono</Label>
                        <Input
                            id="phone"
                            name="phone"
                            :default-value="props.staffMember.phone ?? ''"
                        />
                        <InputError :message="errors.phone" />
                    </div>
                </div>
                <label class="flex items-center gap-3 text-sm">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        :checked="props.staffMember.is_active"
                        class="size-4 rounded border-input bg-transparent accent-[var(--fluo-lime)]"
                    />
                    Attivo
                </label>
                <div class="grid gap-2">
                    <Label for="notes">Note</Label>
                    <textarea
                        id="notes"
                        name="notes"
                        :value="props.staffMember.notes ?? ''"
                        class="min-h-24 rounded-md border border-input bg-transparent px-3 py-2 text-sm outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
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
