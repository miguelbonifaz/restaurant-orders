<template>
    <Head title="Ordenes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Órdenes
            </h2>
            <p class="mt-1 text-sm text-gray-600">Listado de ordenes de los pedidos recien ordenados.</p>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl mx-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

<!--                        <StackedList>-->
<!--                            <li v-for="plate in plates.data" :key="plate.id">-->
<!--                                <a href="#" class="block hover:bg-gray-50">-->
<!--                                    <div class="px-4 py-4">-->
<!--                                        <div class="flex items-center">-->
<!--                            <span-->
<!--                                class="inline-block flex-shrink-0 mr-4 w-12 h-12 bg-gray-200 rounded-full"-->
<!--                            >-->
<!--                            </span>-->
<!--                                            <div class="w-full">-->
<!--                                                <p-->
<!--                                                    class="font-medium text-indigo-600 flex justify-between mb-2"-->
<!--                                                >-->
<!--                                                    {{ plate.name }}-->
<!--                                                    <span-->
<!--                                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold bg-gray-100 text-gray-800"-->
<!--                                                    >-->
<!--                                        ${{ plate.price }}-->
<!--                                    </span>-->
<!--                                                </p>-->
<!--                                                <p-->
<!--                                                    class="inline-flex text-sm font-semibold leading-5 text-gray-800 rounded-full"-->
<!--                                                >-->
<!--                                                    {{ plate.description }}-->
<!--                                                </p>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="flex justify-end items-end mt-4">-->
<!--                                            <div class="flex items-end">-->
<!--                                                <button-->
<!--                                                    @click.prevent="addOrder(plate)"-->
<!--                                                    type="button"-->
<!--                                                    class="flex inline-flex justify-center items-center w-11 h-11 text-base font-medium text-white text-gray-700 rounded-md rounded-full border-2 border-transparent"-->
<!--                                                    :class="{-->
<!--                                        'bg-indigo-600 hover:bg-white hover:border-indigo-600 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500':-->
<!--                                            !isOrdered(plate),-->
<!--                                        'bg-gray-300': isOrdered(plate),-->
<!--                                    }"-->
<!--                                                >-->
<!--                                                    <svg-->
<!--                                                        class="w-6 h-6"-->
<!--                                                        fill="none"-->
<!--                                                        stroke="currentColor"-->
<!--                                                        viewBox="0 0 24 24"-->
<!--                                                        xmlns="http://www.w3.org/2000/svg"-->
<!--                                                    >-->
<!--                                                        <path-->
<!--                                                            stroke-linecap="round"-->
<!--                                                            stroke-linejoin="round"-->
<!--                                                            stroke-width="2"-->
<!--                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"-->
<!--                                                        ></path>-->
<!--                                                    </svg>-->
<!--                                                </button>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                        </StackedList>-->

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
}
</script>
