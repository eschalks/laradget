<template>
    <button class="p-wide bg-red-500 hover:bg-red-600 text-white" type="button" @click="isDialogOpen = true">
        Delete

        <DeleteDialog :isOpen="isDialogOpen" @confirm="onConfirm" @cancel="onCancel" :name="name"/>
    </button>
</template>

<script lang="ts" setup>
import DeleteDialog from "@/components/dialogs/DeleteDialog.vue";
import {ref} from "vue";
import {router} from '@inertiajs/vue3';

const props = defineProps<{
    name: string,
    action: string,
    reload?: string[],
}>();

const emit = defineEmits<{
    (e: 'delete'): void,
}>();

const isDialogOpen = ref(false);


function onConfirm() {
    router.delete(props.action, {
        onSuccess() {
            if (props.reload) {
                router.reload({
                    only: props.reload
                });
            }

            isDialogOpen.value = false;
        }
    });
}

function onCancel() {
    isDialogOpen.value = false;
}
</script>
