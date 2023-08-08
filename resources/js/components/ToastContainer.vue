<script setup lang="ts">
import {toastManager} from "@/toasts";
import ToastItem from "@/components/ToastItem.vue";
import FadeTransition from "@/components/transitions/FadeTransition.vue";



</script>

<template>
<div class="fixed right-1 bottom-1 flex flex-col-reverse ">
    <TransitionGroup>
        <FadeTransition v-for="toast in toastManager.toasts" :key="toast.id">
            <ToastItem :toast="toast" />
        </FadeTransition>
    </TransitionGroup>
</div>
</template>
