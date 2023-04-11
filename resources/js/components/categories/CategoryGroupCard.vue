<template>
    <DefaultCard class="my-4" :title="categoryGroup.name">
        <template #actions>
            <CardActionButton>Add</CardActionButton>
        </template>

        <table class="data-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Debit</th>
                <th>Month Shift</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <CategoryRow v-for="category in categoryGroup.categories" :category="category" :key="category.id" />
            </tbody>
        </table>
    </DefaultCard>
</template>

<script lang="ts" setup>
import DefaultCard from "@/components/cards/DefaultCard.vue";
import CardActionButton from "@/components/cards/CardActionButton.vue";
import CategoryRow from "@/components/categories/CategoryRow.vue";

const props = defineProps<{
    categoryGroup: App.Data.Models.CategoryGroupDto,
}>();
</script>
