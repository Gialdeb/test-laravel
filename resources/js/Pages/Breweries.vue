<script setup>
import {Head} from '@inertiajs/vue3';
import BreweriesList from "@/Pages/Partials/BreweriesList.vue";

defineProps({
    token: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Breweries"/>
    <div
        class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
                <BreweriesList :token="token"/>
            </div>
        </div>
    </div>
</template>
