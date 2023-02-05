<template>
    <PageLayout title="Create Access Token">
        <FormCard submit-text="Create" :form="form">
            <FormInput name="name" label="Name" />
        </FormCard>
    </PageLayout>
</template>

<script lang="ts" setup>
import FormCard from "@/components/cards/FormCard.vue";
import {useForm} from "@inertiajs/vue3";
import FormInput from "@/components/forms/FormInput.vue";
import PageLayout from "@/layouts/PageLayout.vue";

const form = useForm({
    name: '',
});
</script>
