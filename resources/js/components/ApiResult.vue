<template>
    <slot v-if="result" :result="result"></slot>
    <span v-else-if="error" class="text-red-500">{{ error }}</span>
    <span v-else>
        Loading...
    </span>
</template>

<script lang="ts" setup>
import {ref, watch} from "vue";
import axios, {AxiosError} from "axios";

const props = defineProps<{
    path: string,
}>();

const result = ref<unknown | null>(null);
const error = ref<string | null>(null);

watch(() => props.path, async (path) => {
    result.value = null;
    error.value = null;

    try {
        const response = await axios.get(`/api/${path}`);
        result.value = response.data;
    } catch (e: any) {
        if (e instanceof AxiosError) {
            error.value = e.cause?.message ?? e.code ?? 'Unknown error';
            return;
        }

        if (e.message) {
            error.value = e.message;
            return;
        }

        error.value = "Unknown error";
    }

}, {immediate: true});

</script>
