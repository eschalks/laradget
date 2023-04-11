<template>

    <tr>
        <td>{{ counterParty.name }}</td>
        <td>{{ counterParty.iban }}</td>
        <td>
            <CategorySelect v-model="counterParty.defaultCategoryId" :save-url="categorySaveUrl" />
        </td>
    </tr>
</template>

<script lang="ts" setup>
import CategorySelect from "@/components/forms/CategorySelect.vue";
import {computed} from "vue";

const props = defineProps<{
    counterParty: App.Data.Models.CounterPartyDetailsDto,
}>();

const categorySaveUrl = computed(() => route('api.counter_parties.default_category.update', [props.counterParty.id]));

</script>
