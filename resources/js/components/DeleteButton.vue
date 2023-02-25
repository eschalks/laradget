<template>
    <button class="p-wide bg-red-500 hover:bg-red-600 text-white" type="button" @click="dialog.open()">
        Delete

        <DeleteDialog  @confirm="onConfirm" :name="name"/>
    </button>
</template>

<script lang="ts" setup>
import DeleteDialog from "@/components/dialogs/DeleteDialog.vue";
import {ref} from "vue";
import {router} from '@inertiajs/vue3';
import {useDialog} from "@/hooks/dialogs";

const props = defineProps<{
    name: string,
    action: string,
    reload?: string[],
}>();

const emit = defineEmits<{
    (e: 'delete'): void,
}>();

const dialog = useDialog();

function onConfirm() {
    router.delete(props.action, {
        onSuccess() {
            if (props.reload) {
                router.reload({
                    only: props.reload
                });
            }

            dialog.close();
        }
    });
}

</script>
