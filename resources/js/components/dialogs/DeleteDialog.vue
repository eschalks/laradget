<template>
<AnimatedDialog :is-open="isOpen" @close="emit('cancel')">
    Are you sure you want to delete <strong>{{name}}</strong>?

    <template #actions>
        <DialogCancelButton @click="emit('cancel')">
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

const props = defineProps<{
    name: string,
    isOpen: boolean,
}>();

const emit = defineEmits<{
    (e: 'cancel'): void,
    (e: 'confirm'): void,
}>();
</script>
