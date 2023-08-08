<template>
<select :value="modelValue" @input="onInput">
    <optgroup v-for="categoryGroup in categoryGroups" :label="categoryGroup.name" :key="categoryGroup.id">
        <option v-for="category in categoryGroup.categories" :key="category.id" :value="category.id">
            {{ category.name }}
        </option>

    </optgroup>
</select>
</template>

<script lang="ts" setup>
import {watch} from "vue";
import {useCategoryGroups} from "@/hooks/page";
import {apiAxios} from "@/ajax";

const props = withDefaults(defineProps<{
    modelValue: string | number | null,
    saveUrl?: string,
    saveField?: string,
}>(), {
    saveField: 'category_id'
});

const emit = defineEmits<{
    (e: 'update:modelValue', value: number | string | null): void,
}>();


const categoryGroups = useCategoryGroups();

function onInput(e: InputEvent) {
    emit('update:modelValue', (e.target as HTMLSelectElement).value);
}

watch(() => props.modelValue, async (newId) => {
   if (props.saveUrl) {
       const data: Record<string, unknown> = {};
       data[props.saveField] = newId;

       await apiAxios.put(props.saveUrl, {
          categoryId: newId,
       });
   }
});

</script>
