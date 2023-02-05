<template>
    <PageLayout title="New Token">
        <DefaultCard>
            <div>
                Your newly created token: {{ token }}
            </div>

            <div class="flex mt-4 w-full justify-between items-center flex-wrap">
                <div class="bg-gray-200 border border-gray-400 inset-shadow p-wide">
                    <img :src="qr" alt="QR Code" />
                </div>

                <div>
                    <a class="block px-8 py-6 text-xl bg-blue-500 text-white" :href="url">Open in app</a>
                </div>
            </div>
        </DefaultCard>
    </PageLayout>
</template>

<script lang="ts" setup>
import PageLayout from "@/layouts/PageLayout.vue";
import DefaultCard from "@/components/cards/DefaultCard.vue";

const props = defineProps<{
    token: string,
    qr: string,
    url: string,
}>()
</script>
