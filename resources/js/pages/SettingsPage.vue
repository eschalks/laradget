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

        <table class="data-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Last used</th>
                <th></th>
            </tr>
            </thead>
            <tr v-for="token in tokens" :key="token.id">
                <td>{{ token.name }}</td>
                <td>
                    {{ token.lastUsedAt ? format(parseISO(token.lastUsedAt), 'yyyy-MM-dd HH:mm') : '-' }}
                </td>
                <td class="text-right"><DeleteButton :action="`/settings/tokens/${token.id}`" :name="token.name" /></td>
            </tr>
        </table>
    </DefaultCard>
</PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "../layouts/PageLayout.vue";
import DefaultCard from "../components/cards/DefaultCard.vue";
import CardAction from "../components/cards/CardAction.vue";
import {format, parseISO} from "date-fns";
import DeleteButton from "@/components/DeleteButton.vue";

const props = defineProps<{
    accounts: App.Data.Vue.SettingsPageAccount[],
    tokens: App.Data.Vue.SettingsPagePersonalAccessToken[],
}>();


</script>
