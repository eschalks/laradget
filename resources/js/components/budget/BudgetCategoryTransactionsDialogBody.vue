<template>
    <table class="data-table">
        <thead>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="transaction in transactions.data">
            <td>
                {{ transaction.description }}
            </td>
            <td>
                <MoneySpan :amount="transaction.amount" />
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script lang="ts" setup>
import {PaginatedResponse} from "@/hooks/api";
import MoneySpan from "@/components/MoneySpan.vue";
import {TransactionDto} from "@/generated/generated";

const props = defineProps<{
    transactions: PaginatedResponse<TransactionDto>,
}>();


</script>
