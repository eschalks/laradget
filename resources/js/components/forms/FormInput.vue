<template>
    <FormGroup :name="name" :label="label">
        <input :type="type" :id="name" @input="onInput" />
    </FormGroup>
</template>

<script lang="ts" setup>
import FormGroup from "@/components/forms/FormGroup.vue";
import {injectForm} from "@/hooks/forms";
import {watch} from "vue";

const props = withDefaults(defineProps<{
    type?: string,
    name: string,
    label: string,
}>(), {
    type: 'text',
});

const form = injectForm<Record<string, string>>();
watch(form, newForm => {
    if (!(props.name in newForm.data())) {
        throw Error(`Form data does not contain the key ${props.name}. Please check if your input name has a typo, or add the field to the appropriate useForm.`);
    }
}, {immediate: true})


function onInput(e: InputEvent) {
    form.value[props.name] = (e.target as HTMLInputElement).value;
}
</script>
