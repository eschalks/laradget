<template>
    <DefaultCard :title="categoryGroup.name">
        <template #actions>
            <MoneySpan class="text-white" :amount="totalSpent" />
        </template>
        <table class="w-full">
            <thead>
            <tr>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <BudgetCategoryRow
                v-for="category in categoryGroup.categories"
                :key="category.id"
                :category="category"
                :summary="summary"
            />
            </tbody>
        </table>
    </DefaultCard>
</template>

<script lang="ts" setup>
import DefaultCard from "@/components/cards/DefaultCard.vue";
import BudgetCategoryRow from "@/components/budget/BudgetCategoryRow.vue";
import {computed} from "vue";
import MoneySpan from "@/components/MoneySpan.vue";
import {CategoryGroupDto, PeriodSummary} from "@/generated/generated";

const props = defineProps<{
    summary: PeriodSummary,
    categoryGroup: CategoryGroupDto,
}>();

const totalSpent = computed(() => props.summary.categoryGroupTotals[props.categoryGroup.id]);
</script>
