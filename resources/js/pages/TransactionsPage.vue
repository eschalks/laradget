<template>
<PageLayout title="Transactions">
    <DefaultCard>
        <UncategorizedToggle v-model="showUncategorizedOnly" :uncategorized="uncategorizedTransactions" />
        <TransactionsTable :transactions="visibleTransactions" />
    </DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "@/layouts/PageLayout.vue";
import DefaultCard from "@/components/cards/DefaultCard.vue";
import TransactionsTable from "@/components/transactions/TransactionsTable.vue";
import {computed, ref, watch} from "vue";
import UncategorizedToggle from "@/components/forms/UncategorizedToggle.vue";
import {TransactionDto, TransactionsPage} from "@/generated/generated";

const props = defineProps<TransactionsPage>();

const visibleTransactions = ref<TransactionDto[]>([]);
const showUncategorizedOnly = ref(false);
const uncategorizedTransactions = computed(() => {
    return props.transactions.filter(t => !t.categoryId);
});

watch(() => showUncategorizedOnly.value, (newValue) => {
    visibleTransactions.value = newValue ? uncategorizedTransactions.value : props.transactions;
}, {immediate: true});

</script>
