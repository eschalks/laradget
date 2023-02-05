<template>
<PageLayout title="Settings">
    <DefaultCard title="Accounts">
        <template #actions>
            <CardAction href="/settings/accounts/import">Add</CardAction>
        </template>

        <div v-for="account in accounts">
            {{ account.name }}
        </div>
    </DefaultCard>
    <DefaultCard title="Access Tokens" class="mt-4">
        <template #actions>
            <CardAction href="/settings/tokens/create">Add</CardAction>
        </template>
    </DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "../layouts/PageLayout.vue";
import DefaultCard from "../components/cards/DefaultCard.vue";
import CardAction from "../components/cards/CardAction.vue";

const props = defineProps<{
    accounts: App.Data.Vue.SettingsPageAccount[],
    tokens: App.Data.Vue.SettingsPagePersonalAccessToken[],
}>();


</script>
