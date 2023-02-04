<template>
    <label>
        <input type="checkbox" v-model="isUncategorizedOnly"> Show uncategorized only
    </label>

    <table class="data-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>IBAN</th>
            <th>Default Category</th>
        </tr>
        </thead>

        <tbody>
        <CounterPartiesTableRow v-for="counterParty in visibleParties" :counter-party="counterParty" :key="counterParty.id" />
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

const isUncategorizedOnly = ref(false);

// Not computed because we want to do this based on what was uncategorized at time of loading the page.
// (otherwise rows disappear after selecting a category)
const uncategorized = props.counterParties.filter(cp => !cp.defaultCategoryId);

const visibleParties = computed(() => {
   if (isUncategorizedOnly.value) {
       return uncategorized;
   }

   return props.counterParties;
});
</script>
