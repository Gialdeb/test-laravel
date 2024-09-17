<script setup>
import {onMounted, ref} from "vue";

const props = defineProps({
    token: {
        type: String,
        default: null,
    },
});

const breweries = ref([]);
const currentPage = ref(1);
const hasNextPage = ref(true);

const getBreweries = async (limit = 20) => {
    const response = await axios.get(route('api.breweries.index', {page: currentPage.value, limit: limit, token: props.token}));
    hasNextPage.value = response.data.length > 0;
    if (hasNextPage.value) {
        breweries.value = response.data;
    } else {
        currentPage.value--;
    }
}

onMounted(() => {
    getBreweries();
})

const previousPage = () => {
    currentPage.value = Math.max(0, currentPage.value - 1);
    getBreweries();
}

const nextPage = () => {
    currentPage.value++;
    getBreweries();
}

</script>

<template>

    <div class="flex w-full justify-center">
        <table class="table-auto w-full max-w-12xl bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">ID</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Name</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Brewery Type</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Address 1</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">City</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">State</th>
                <th class="px-4 py-2 text-left text-gray-700 font-semibold">Street</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="brewery in breweries" :key="brewery.id" class="border-t border-gray-200">
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.id }}</td>
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.name }}</td>
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.brewery_type }}</td>
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.address_1 }}</td>
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.city }}</td>
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.state }}</td>
                <td class="px-4 py-2 text-left text-gray-600">{{ brewery.street }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center w-full max-w-4xl mx-auto mt-6 mb-12">
        <button
            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            @click="previousPage">
            Previous
        </button>

        <span class="text-gray-700">Page {{ currentPage }}</span>

        <button
            class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="!hasNextPage"
            @click="nextPage">
            Next
        </button>
    </div>
</template>
