<template>
<PageLayout title="Budget">
    <p>Uncategorized: <MoneySpan :amount="summary.categoryTotals['']"/></p>

    <BudgetCategoryGroupCard
        class="my-4"
        v-for="group in categoryGroups"
        :key="group.id"
        :summary="summary"
        :category-group="group" />
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "@/layouts/PageLayout.vue";
import BudgetCategoryGroupCard from "@/components/budget/BudgetCategoryGroupCard.vue";
import MoneySpan from "@/components/MoneySpan.vue";
import {BudgetPage} from "@/generated/generated";

const props = defineProps<BudgetPage>();
</script>
