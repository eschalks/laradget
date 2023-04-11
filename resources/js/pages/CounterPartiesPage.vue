<template>
<PageLayout title="Counter Parties">
    <DefaultCard>
        <UncategorizedToggle :uncategorized="uncategorized" v-model="isUncategorizedOnly"/>
        <CounterPartiesTable :counterParties="visibleParties"/>
    </DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "@/layouts/PageLayout.vue";
import CounterPartiesTable from "@/components/counter_parties/CounterPartiesTable.vue";
import DefaultCard from "@/components/cards/DefaultCard.vue";
import {computed, ref, watch} from "vue";
import UncategorizedToggle from "@/components/forms/UncategorizedToggle.vue";


const props = defineProps<{
    counterParties: App.Data.Models.CounterPartyDetailsDto[],
    uncategorizedTransactionCounts: Record<number, number>,
}>();

const isUncategorizedOnly = ref(true);
const visibleParties = ref<App.Data.Models.CounterPartyDetailsDto[]>([]);

const uncategorized = computed(() => {
    return props.counterParties.filter(cp => !cp.defaultCategoryId && props.uncategorizedTransactionCounts[cp.id]);
});

watch(isUncategorizedOnly, (isUncategorized) => {
    // Not computed because we want to do this based on what was uncategorized at the of time loading the page or re-applying the filter.
    // (otherwise rows disappear after selecting a category)
    visibleParties.value = isUncategorized ? uncategorized.value : props.counterParties;
}, {immediate: true});
</script>
