<template>
    <CardWrapper>
        <CardHeader :title="title" v-if="title">
            <template #actions>
                <slot name="actions"/>
            </template>
        </CardHeader>
        <CardBody>
            <slot/>
        </CardBody>
    </CardWrapper>
</template>

<script lang="ts" setup>
import CardWrapper from "./CardWrapper.vue";
import CardHeader from "./CardHeader.vue";
import CardBody from "./CardBody.vue";

const props = defineProps<{
    title?: string,
}>();
</script>
