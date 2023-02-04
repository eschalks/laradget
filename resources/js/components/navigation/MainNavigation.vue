<template>
<div class="bg-blue-500 flex items-end px-4 pt-4">
    <div class="container mx-auto">
        <div class="flex">
            <PeriodNavigation />
            <div class="flex flex-shrink-0">
                <MainNavigationItem href="/counter_parties">Parties</MainNavigationItem>
                <MainNavigationItem href="/settings">Settings</MainNavigationItem>
            </div>
        </div>
    </div>
</div>
</template>

<script lang="ts" setup>
import MainNavigationItem from "./MainNavigationItem.vue";
import PeriodNavigation from "@/components/navigation/PeriodNavigation.vue";
</script>
