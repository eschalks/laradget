<template>
    <tr>
        <td>{{ category.name }}</td>
        <td></td>
        <td class="tabular-nums text-right">
            <DialogOpenLink @click="isTransactionsDialogOpen = true" class="hover:text-blue-500">
                <MoneySpan :amount="summary.categoryTotals[category.id]"/>

                <BudgetCategoryTransactionsDialog
                    :category="category"
                    :summary="summary"
                />
            </DialogOpenLink>
        </td>
    </tr>
</template>

<script lang="ts" setup>

import MoneySpan from "@/components/MoneySpan.vue";
import BudgetCategoryTransactionsDialog from "@/components/budget/BudgetCategoryTransactionsDialog.vue";
import {ref} from "vue";
import DialogOpenLink from "@/components/DialogOpenLink.vue";
import {CategoryDto, PeriodSummary} from "@/generated/generated";

const props = defineProps<{
    summary: PeriodSummary,
    category: CategoryDto,
}>();


const isTransactionsDialogOpen = ref(false);
</script>
