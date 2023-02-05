<template>
    <div class="w-screen h-screen bg-blue-200 flex justify-center items-center">
        <FormCard submit-text="Login" :form="form" class="max-w-lg" title="Budget Login">
            <FormInput label="Username" type="email" name="username" />
            <FormInput label="Password" type="password" name="password" />

            <template #footer v-if="showErrors">
                <span class="text-red-500">Invalid credentials</span>
            </template>
        </FormCard>
    </div>
</template>


<script lang="ts" setup>
import {useForm} from "@inertiajs/vue3";
import {ValidationErrors} from "../forms";
import {computed} from "vue";
import FormCard from "@/components/cards/FormCard.vue";
import FormInput from "@/components/forms/FormInput.vue";

const props = defineProps<{
    errors?: ValidationErrors,
}>();

const showErrors = computed(() => props.errors && Object.keys(props.errors).length > 0)

const form = useForm({
    username: '',
    password: '',
});
</script>
