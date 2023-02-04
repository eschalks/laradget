<template>
    <div class="flex items-center">
        <div class="mr-4">
            <input type="checkbox" :id="inputId" :checked="isSelected" @input="toggle()"/>
        </div>

        <label class="p-wide" :for="inputId">
            {{ account.display_name }}<br>
            <small>{{ account.account_number.iban }}</small>
        </label>
    </div>
</template>

<script lang="ts" setup>
import {computed} from "vue";

const props = defineProps<{
    account: App.TrueLayer.AccountTL,
    modelValue: string[],
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', ids: string[]): void,
}>();


const isSelected = computed(() => props.modelValue.indexOf(props.account.account_id) >= 0);
const inputId = computed(() => `account_${props.account.account_id}`);

function toggle() {
    const {account_id} = props.account;
    const newValue = isSelected.value ? props.modelValue.filter(id => id !== account_id) : [...props.modelValue, account_id];
    emit('update:modelValue', newValue);
}

</script>
