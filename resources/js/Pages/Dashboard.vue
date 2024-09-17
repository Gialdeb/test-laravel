<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BreweriesList from "@/Pages/Partials/BreweriesList.vue";

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
})

const breweryUrl = route('breweries.index', {token: props.token});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <p class="text-gray-700">Ciao <strong>{{ $page.props.auth.user.name }}</strong>,</p>
                    <p class="text-gray-700">
                        Il tuo token è <strong>{{ token }}</strong>
                    </p>
                    <br>
                    <p class="text-gray-700">
                        Puoi visualizzare la lista delle birrerie utilizzando il token
                        <strong>(da non loggato)</strong> al seguente URL:
                    </p>
                    <a class="text-blue-500 hover:underline" :href="breweryUrl" target="_blank">
                        {{ breweryUrl }}
                    </a>
                    <br>
                    <h1 class="text-2xl font-semibold mt-6">Breweries Table</h1><br>
                    <BreweriesList/>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
