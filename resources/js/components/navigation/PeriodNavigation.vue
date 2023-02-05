<template>
    <div>
        <nav class="flex flex-1">
            <MainNavigationItem href="/budget">Budget</MainNavigationItem>
            <MainNavigationItem href="/transactions">Transactions</MainNavigationItem>
        </nav>
    </div>
</template>

<script lang="ts" setup>
import MainNavigationItem from "@/components/navigation/MainNavigationItem.vue";
import {usePage} from "@inertiajs/vue3";
import {watch} from "vue";


const page = usePage();

watch(() => page.props, (newProps) => {

}, {immediate: true});
</script>
