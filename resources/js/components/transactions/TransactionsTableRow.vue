<template>
    <tr>
        <td>
            {{ transactionDate }}
        </td>
        <td class="w-16 text-sm">
            <template v-for="line in descriptionLines">
                {{line}}<br />
            </template>
        </td>
        <td>{{ transaction.counterParty?.name }}</td>
        <td>
            <CategorySelect class="w-full" v-model="transaction.categoryId" :save-url="saveUrl" />
        </td>
        <td class="money-col">
            <MoneySpan :amount="transaction.amount"/>
        </td>
    </tr>
</template>

<script lang="ts" setup>

import {computed} from "vue";
import {format, parseISO} from "date-fns";
import MoneySpan from "@/components/MoneySpan.vue";
import CategorySelect from "@/components/forms/CategorySelect.vue";
import {TransactionDto} from "@/generated/generated";

const props = defineProps<{
    transaction: TransactionDto,
}>();

const transactionDate = computed(() => {
    return format(parseISO(props.transaction.transactionAt), 'yyyy-MM-dd');
});

const descriptionLines = computed(() => {
   return props.transaction.description.split("<br>");

});

const saveUrl = computed(() => route('api.transactions.update', [props.transaction.id]));
</script>
