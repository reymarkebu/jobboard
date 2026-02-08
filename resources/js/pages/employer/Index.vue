<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from "@/components/ui/textarea";
import { toTypedSchema } from '@vee-validate/zod';
import { Form, Field as VeeField } from 'vee-validate';
import * as z from 'zod';
import { ref } from 'vue';

import {
    Field,
    FieldDescription,
    FieldError,
    FieldGroup,
    FieldLabel,
} from '@/components/ui/field';

import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableFooter,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Job Listings',
        href: '/employer/index',
    },
];

interface JobOpening {
    id: number;
    title: string;
    description: string;
    created_at: string;
    updated_at: string;
}


interface Props {
    jobOpenings: JobOpening[];
}

const props = defineProps<Props>();

console.log(props);

const open = ref(false);
const isSubmitting = ref(false);

const form = useForm({
    title: '',
    description: '',
});

const formSchema = toTypedSchema(z.object({
    title: z.string().min(2).max(255),
    description: z.string().min(2).max(500),
}))

function createJobOpening(values: any) {
    isSubmitting.value = true;

    console.log("submit", values);

    Object.assign(form, {
        title: values.title,
        description: values.description,
    });

    form.post('/employer/store', {
        onSuccess: () => {
            console.log("Job opening created successfully");

            open.value = false;   // Close the dialog
            form.reset();         // Reset form fields
        }, 
        onFinish: () => {
            isSubmitting.value = false;
        },
    });



}

</script>

<template>

    <Head title="Job Listings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-3">
            <div class="container py-5 mx-auto">
                <Form v-slot="{ handleSubmit }" as="" :validation-schema="formSchema">
                    <Dialog v-model:open="open">
                        <DialogTrigger as-child>
                            <Button @click="open = true" class="ml-auto">
                                Post a Job
                            </Button>
                        </DialogTrigger>
                        <DialogContent class="w-full max-w-4xl">
                            <DialogHeader>
                                <DialogTitle>Post a Job</DialogTitle>
                                <DialogDescription></DialogDescription>
                            </DialogHeader>

                            <form id="dialogForm" @submit="handleSubmit($event, createJobOpening)">
                                <FieldGroup>
                                    <VeeField v-slot="{ componentField, errors }" name="title">
                                        <Field :data-invalid="!!errors.length">
                                            <FieldLabel for="title">
                                                Job Title
                                            </FieldLabel>
                                            <Input id="title" type="text" placeholder="Job Title"
                                                v-bind="componentField" />
                                            <FieldError v-if="errors.length"
                                                :errors="errors.map(e => ({ message: e }))" />
                                            <!-- Inertia backend validation errors -->
                                            <FieldError v-if="form.errors['title']"
                                                :errors="[{ message: form.errors['title'] }]" />
                                        </Field>
                                    </VeeField>
                                    <VeeField v-slot="{ componentField, errors }" name="description">
                                        <Field :data-invalid="!!errors.length">
                                        <FieldLabel for="description">
                                            Description
                                        </FieldLabel>
                                        <Textarea id="description" placeholder="Description" v-bind="componentField" />
                                        <FieldError v-if="errors.length" :errors="errors.map(e => ({ message: e }))" />
                                        <FieldError v-if="form.errors.description" :errors="[{ message: form.errors.description }]" />
                                        </Field>
                                    </VeeField>
                                    
                                </FieldGroup>
                            </form>

                            <DialogFooter>
                                <Button type="submit" form="dialogForm" :disabled="isSubmitting">
                                {{ isSubmitting ? 'Saving...' : 'Create Job Opening' }}
                                </Button>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>

                </Form>

                <!-- Table -->
                <Table>
                    <TableCaption>A list of your recent job openings.</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Created At</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <!-- Example rows -->
                        <TableRow v-for="job in props.jobOpenings" :key="job.id">
                            <TableCell>{{ job.title }}</TableCell>
                            <TableCell>{{ job.description }}</TableCell>
                            <TableCell>{{ job.created_at }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
