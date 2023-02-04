<template>
    <tr>
        <td>{{ category.name }}</td>
        <td></td>
        <td class="tabular-nums text-right"><MoneySpan :amount="summary.transactionTotals[category.id]" /></td>
    </tr>
</template>

<script lang="ts" setup>

import MoneySpan from "@/components/MoneySpan.vue";

const props = defineProps<{
    summary: App.Data.Responses.PeriodSummary,
    category: App.Data.Models.CategoryDto,
}>();
</script>
