<template>
    <TransitionRoot appear :show="dialog.isOpen" as="template">
        <Dialog as="div" @close="close" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25"/>
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            v-if="isBodyLoaded"
                            class="w-full max-w-xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                v-if="title"
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                {{ title }}
                            </DialogTitle>
                            <div class="mt-2">
                                <slot />
                            </div>

                            <div class="mt-4 flex justify-end items-center">
                                <slot name="actions" />
<!--                                <button-->
<!--                                    type="button"-->
<!--                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"-->
<!--                                    @click="close"-->
<!--                                >-->
<!--                                    Got it, thanks!-->
<!--                                </button>-->
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script lang="ts" setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot,} from '@headlessui/vue';
import {useDialog} from "@/hooks/dialogs";
import {ref, watch} from "vue";

const dialog = useDialog();

const props = withDefaults(defineProps<{
    title?: string,
    lazy?: boolean,
}>(), {
  lazy: true,
});

// If this was ever opened, used to delay the rendering of the body until the first time the dialog is opened.
const isBodyLoaded = ref(!props.lazy);

const emit = defineEmits<{
    (e: 'close'): void,
}>();

watch(() => dialog.isOpen, (isOpen) => {
    if (isOpen) {
        isBodyLoaded.value = true;
    }
});

function close() {
    dialog.close();
    emit('close');
}

</script>
