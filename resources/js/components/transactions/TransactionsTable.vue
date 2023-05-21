<template>

    <table class="data-table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Counter Party</th>
            <th>Category</th>
            <th class="money-col">Amount</th>
        </tr>
        </thead>
        <tbody>
        <TransactionsTableRow v-for="transaction in transactions" :transaction="transaction" :key="transaction.id"/>
        </tbody>
    </table>
</template>

<script lang="ts" setup>
import TransactionsTableRow from "@/components/transactions/TransactionsTableRow.vue";
import {TransactionDto} from "@/generated/generated";

const props = defineProps<{
    transactions: TransactionDto[],
}>();
</script>
