<template>
<AnimatedDialog  @close="emit('cancel')">
    Are you sure you want to delete <strong>{{name}}</strong>?

    <template #actions>
        <DialogCancelButton @click="dialog.close()">
            Cancel
        </DialogCancelButton>
        <DialogConfirmButton class="ml-4" @click="emit('confirm')">
            Delete
        </DialogConfirmButton>
    </template>
</AnimatedDialog>
</template>

<script lang="ts" setup>
import AnimatedDialog from "@/components/dialogs/AnimatedDialog.vue";
import DialogCancelButton from "@/components/dialogs/DialogCancelButton.vue";
import DialogConfirmButton from "@/components/dialogs/DialogConfirmButton.vue";
import {useDialog} from "@/hooks/dialogs";

const props = defineProps<{
    name: string,
}>();

const dialog = useDialog();

const emit = defineEmits<{
    (e: 'cancel'): void,
    (e: 'confirm'): void,
}>();
</script>
