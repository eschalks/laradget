<script setup lang="ts">
import {Toast, ToastStyle} from "@/toasts";
import {computed, ref} from "vue";

const props = defineProps<{
    toast: Toast,
}>();

const isTruncated = ref(true);

const styleClasses = computed(() => {
    switch (props.toast.style) {
        case ToastStyle.Success:
            return 'border-green-500';
        case ToastStyle.Error:
            return 'border-red-500';
    }
});

const classes = computed(() => {
   const result = [styleClasses.value];
   if (isTruncated.value) {
       result.push('truncate');
       result.push('cursor-pointer');
   }
    return result;
});
</script>

<template>
<div class="bg-white shadow border-l-2 px-4 py-2 w-96 max-h-32 mt-4" @click="isTruncated = false" :class="classes" :title="toast.message">
    {{toast.message}}
</div>
</template>
