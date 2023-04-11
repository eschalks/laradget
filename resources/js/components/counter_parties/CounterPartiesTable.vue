<template>

    <table class="data-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>IBAN</th>
            <th>Default Category</th>
        </tr>
        </thead>

        <tbody>
        <CounterPartiesTableRow v-for="counterParty in counterParties" :counter-party="counterParty" :key="counterParty.id" />
        </tbody>
    </table>
</template>

<script lang="ts" setup>
import CategorySelect from "@/components/forms/CategorySelect.vue";
import {computed, ref} from "vue";
import CounterPartiesTableRow from "@/components/counter_parties/CounterPartiesTableRow.vue";

const props = defineProps<{
    counterParties: App.Data.Models.CounterPartyDetailsDto[],
}>();
</script>
