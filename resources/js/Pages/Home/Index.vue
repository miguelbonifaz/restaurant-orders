<template>
    <Head title="Restaurant" />

    <div class="flex justify-center">
        <h2
            class="inline-block px-4 py-2 my-16 text-3xl font-medium text-center text-white uppercase bg-gray-800 rounded"
        >
            Place your order
        </h2>
    </div>

    <div class="px-6 mx-auto max-w-6xl">
        <ul class="mb-6 space-y-2">
            <li
                v-for="order in orders"
                :key="order.id"
                :class="{
                    'animate__animated animate__fadeInUp': order.quantity > 0,
                    'animate__animated animate__fadeOut': order.quantity === 0,
                }"
                class="flex items-center justify-between px-4 py-3 bg-white rounded-lg shadow-lg"
            >
                <span class="text-gray-700" v-text="order.name"></span>
                <div class="flex items-center space-x-2">
                    $
                    <span>{{ calculatePrice(order) }}</span>
                    <button
                        @click="decrementOrder(order)"
                        type="button"
                        class="inline-flex items-center p-1 text-white bg-indigo-600 rounded-full border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 12H4"
                            ></path>
                        </svg>
                    </button>
                    <span
                        v-text="order.quantity"
                        class="text-lg font-bold text-gray-600"
                    ></span>
                    <button
                        @click="order.quantity++"
                        type="button"
                        class="inline-flex items-center p-1 text-white bg-indigo-600 rounded-full border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg
                            class="w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </li>
            <template v-if="orders.length">
                <div class="flex justify-end">
                    <button
                        type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Confirmar Orden
                        <svg
                            class="w-6 h-6 ml-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </button>
                </div>
            </template>
        </ul>

        <StackedList>
            <li v-for="plate in plates.data" :key="plate.id">
                <a href="#" class="block hover:bg-gray-50">
                    <div class="px-4 py-4">
                        <div class="flex items-center">
                            <span
                                class="inline-block flex-shrink-0 mr-4 w-12 h-12 bg-gray-200 rounded-full"
                            >
                            </span>
                            <div class="w-full">
                                <p
                                    class="font-medium text-indigo-600 flex justify-between mb-2"
                                >
                                    {{ plate.name }}
                                    <span
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold bg-gray-100 text-gray-800"
                                    >
                                        ${{ plate.price }}
                                    </span>
                                </p>
                                <p
                                    class="inline-flex text-sm font-semibold leading-5 text-gray-800 rounded-full"
                                >
                                    {{ plate.description }}
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-end items-end mt-4">
                            <div class="flex items-end">
                                <button
                                    @click.prevent="addOrder(plate)"
                                    type="button"
                                    class="flex inline-flex justify-center items-center w-11 h-11 text-base font-medium text-white text-gray-700 rounded-md rounded-full border-2 border-transparent"
                                    :class="{
                                        'bg-indigo-600 hover:bg-white hover:border-indigo-600 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500':
                                            !isOrdered(plate),
                                        'bg-gray-300': isOrdered(plate),
                                    }"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                        ></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </StackedList>
    </div>

    <Modal>
        <template v-slot:default> content@! </template>
        <template v-slot:footer>
            <button
                type="button"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                Realizar Pedido
            </button>
        </template>
    </Modal>
</template>

<style scoped></style>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import Modal from "@/Pages/Shared/Modal";
import StackedList from "@/Pages/Shared/StackedList";
import { computed, reactive, ref } from "vue";

const props = defineProps({
    plates: Object,
});

let orders = reactive([]);

function calculatePrice({ price, quantity }) {
    return (price * quantity).toFixed(2);
}

function isOrdered(plate) {
    return orders.some((order) => order.id === plate.id);
}

function decrementOrder(order) {
    if (order.quantity === 0) {
        return null;
    }

    order.quantity--;

    if (order.quantity === 0) {
        setTimeout(() => {
            orders.splice(orders.indexOf(order), 1);
        }, 800);
    }
}

function addOrder(plate) {
    if (orders.find((order) => order.id === plate.id)) {
        return;
    }

    orders.push({
        id: plate.id,
        name: plate.name,
        description: plate.description,
        price: plate.price,
        quantity: 1,
    });
}
</script>
