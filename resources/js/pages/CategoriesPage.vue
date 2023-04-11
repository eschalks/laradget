<template>
    <PageLayout title="Categories">
        <CategoryGroupCard v-for="group in categoryGroups" :categoryGroup="group" />
    </PageLayout>
</template>

<script lang="ts" setup>
import {useCategoryGroups} from "@/hooks/page";
import CategoryGroupCard from "@/components/categories/CategoryGroupCard.vue";
import PageLayout from "@/layouts/PageLayout.vue";

const categoryGroups = useCategoryGroups();
</script>
