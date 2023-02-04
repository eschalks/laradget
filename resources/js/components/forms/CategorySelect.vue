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
import {usePage} from "@inertiajs/inertia-vue3";
import {computed, Ref, watch} from "vue";
import axios from "axios";

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

const page = usePage();

const categoryGroups = computed(() => {
   return page.props.value.categoryGroups as App.Data.Models.CategoryGroupDto[];
});

function onInput(e: InputEvent) {
    emit('update:modelValue', (e.target as HTMLSelectElement).value);
}

watch(() => props.modelValue, async (newId) => {
   if (props.saveUrl) {
       const data: Record<string, unknown> = {};
       data[props.saveField] = newId;

       await axios.put(props.saveUrl, {
          category_id: newId,
       });
   }
});

</script>
