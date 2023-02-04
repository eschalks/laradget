<template>
<PageLayout title="Counter Parties">
    <DefaultCard>
        <CounterPartiesTable :counterParties="counterParties" />
    </DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "@/layouts/PageLayout.vue";
import CounterPartiesTable from "@/components/counter_parties/CounterPartiesTable.vue";
import DefaultCard from "@/components/cards/DefaultCard.vue";

const props = defineProps<{
    counterParties: App.Data.Models.CounterPartyDetailsDto[],
}>();
</script>
