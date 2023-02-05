<template>
    <CardWrapper>
        <CardHeader :title="title" v-if="title">
            <slot name="actions" />
        </CardHeader>
        <form method="post" @submit.stop.prevent="submit()">
            <CardBody>
                <slot />
            </CardBody>

            <div class="p-wide bg-gray-200 flex items-center">
                <div class="flex-1">
                    <slot name="footer" />
                </div>
                <div class="flex-grow-0 flex-shrink-0">
                    <SubmitButton :disabled="!canSubmit">{{ submitText }}</SubmitButton>
                </div>
            </div>
        </form>
    </CardWrapper>
</template>

<script lang="ts" setup>
import CardWrapper from "./CardWrapper.vue";
import CardHeader from "./CardHeader.vue";
import CardBody from "./CardBody.vue";
import SubmitButton from "../buttons/SubmitButton.vue";
import {InertiaForm} from "@inertiajs/vue3";
import {computed, ref, toRef, toRefs, watch} from "vue";
import {provideForm} from "@/hooks/forms";

const props = withDefaults(defineProps<{
    title?: string,
    action?: string,
    submitText: string,
    form: InertiaForm<unknown>,
    enabled?: boolean,
}>(), {
    enabled: true,
});

const isSubmitting = ref(false);
const canSubmit = computed(() => props.enabled && !isSubmitting.value);
provideForm(toRef(props, 'form'));


async function submit() {
    if (!canSubmit.value) {
        return;
    }

    isSubmitting.value = true;

    try {
        const path = props.action ?? document.location.pathname;
        await props.form.post(path);
    } finally {
        isSubmitting.value = false;
    }
}
</script>
