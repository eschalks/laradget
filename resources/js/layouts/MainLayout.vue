<template>
<div>
    <MainNavigation />
    <slot />
</div>
</template>

<script lang="ts" setup>
import MainNavigation from "../components/navigation/MainNavigation.vue";
</script>
