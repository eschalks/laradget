<template>
<PageLayout title="Transactions">
    <DefaultCard>
        <TransactionsTable :transactions="transactions" />
    </DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "@/layouts/PageLayout.vue";
import DefaultCard from "@/components/cards/DefaultCard.vue";
import TransactionsTable from "@/components/transactions/TransactionsTable.vue";

const props = defineProps<{
    transactions: App.Data.Models.TransactionDto[],
}>();

</script>
