<template>
    <tr>
        <td class="w-1/2">{{ category.name }}</td>
        <td class="w-1/8">
            <input type="checkbox" :checked="category.isDebit"/>
        </td>
        <td class="w-1/8">
            <input type="checkbox" :checked="category.monthOffset !== 0" @change="updateMonthOffset"/>
        </td>
        <td class="w-1/4">Icons</td>
    </tr>
</template>

<script lang="ts" setup>
import {App} from "vue";
import {router} from "@inertiajs/vue3";
import {CategoryDto} from "@/generated/generated";

const props = defineProps<{
    category: CategoryDto,
}>();

type FilteredKeyOf<T, TK> = keyof Pick<T, { [K in keyof T]: T[K] extends TK ? K : never }[keyof T]>;

function updateMonthOffset(field: FilteredKeyOf<CategoryDto, boolean>) {
    const newValue = props.category.monthOffset === 0 ? 1 : 0;
    props.category.monthOffset = newValue;

    router.put(route('categories.update', [props.category.id]),
        {
            monthOffset: newValue,
        }
    );
}
</script>
