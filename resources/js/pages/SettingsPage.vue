<template>
<PageLayout title="Settings">
    <DefaultCard title="Accounts">
        <template #actions>
            <CardActionLink href="/settings/accounts/import">Add</CardActionLink>
        </template>

        <table class="data-table">
            <tr v-for="account in accounts">
                <td>{{ account.name }}</td>
                <td>
                    <a class="text-blue-500 underline" :href="`/settings/accounts/${account.id}/export`">Export</a>
                </td>
            </tr>
        </table>
    </DefaultCard>
    <DefaultCard title="Access Tokens" class="mt-4">
        <template #actions>
            <CardActionLink href="/settings/tokens/create">Add</CardActionLink>
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
import {format, parseISO} from "date-fns";
import DeleteButton from "@/components/DeleteButton.vue";
import CardActionLink from "@/components/cards/CardActionLink.vue";
import {SettingsPage} from "@/generated/generated";

const props = defineProps<SettingsPage>();


</script>
