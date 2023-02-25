<template>
<AnimatedDialog :title="`${category.name} Transactions`">
    <ApiResult :path="transactionsPath" v-slot="{result}">
        <BudgetCategoryTransactionsDialogBody :transactions="result" />
    </ApiResult>
</AnimatedDialog>
</template>

<script lang="ts" setup>
import AnimatedDialog from "@/components/dialogs/AnimatedDialog.vue";
import ApiResult from "@/components/ApiResult.vue";
import {computed} from "vue";
import BudgetCategoryTransactionsDialogBody from "@/components/budget/BudgetCategoryTransactionsDialogBody.vue";

const props = defineProps<{
    category: App.Data.Models.CategoryDto,
    summary: App.Data.Responses.PeriodSummary,
}>();

const transactionsPath = computed(() => {
    const from = props.summary.startsAt;
    const until = props.summary.endsAt;
    return `transactions?category_id=${props.category.id}&from=${from}&until=${until}`;
});
</script>
