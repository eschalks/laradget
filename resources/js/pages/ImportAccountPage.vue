<template>
    <PageLayout title="Import Accounts">
        <FormCard submit-text="Import" :form="form" :enabled="form.accounts.length > 0">
            <ApiResult path="import/accounts" v-slot="{result}">
                <div v-for="account in result">
                    <ImportableAccount :account="account" :key="account.id" v-model="form.accounts" />
                </div>
            </ApiResult>
        </FormCard>
    </PageLayout>
</template>

<script lang="ts" setup>
import FormCard from "../components/cards/FormCard.vue";
import PageLayout from "../layouts/PageLayout.vue";
import ApiResult from "../components/ApiResult.vue";
import ImportableAccount from "../components/import/ImportableAccount.vue";
import {useForm} from "@inertiajs/inertia-vue3";

const form = useForm({
    accounts: [],
});


</script>
