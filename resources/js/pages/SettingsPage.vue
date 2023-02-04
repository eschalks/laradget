<template>
<PageLayout title="Settings">
<DefaultCard title="Accounts">
<template #actions>
    <CardAction href="/settings/accounts/import">Add</CardAction>
</template>
</DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "../layouts/PageLayout.vue";
import DefaultCard from "../components/cards/DefaultCard.vue";
import CardAction from "../components/cards/CardAction.vue";
</script>
