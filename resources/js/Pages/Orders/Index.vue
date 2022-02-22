<template>
    <Head title="Ordenes" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Órdenes
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Listado de ordenes de los pedidos recien ordenados.
            </p>
        </template>

        <FlashMessage />

        <div class="py-12">
            <div class="mx-4 max-w-7xl lg:mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                    <dl
                        class="grid overflow-hidden grid-cols-1 mt-5 bg-white rounded-lg divide-y divide-gray-200 shadow md:grid-cols-2 md:divide-y-0 md:divide-x"
                    >
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-base font-normal text-gray-900">
                                Total pedidos del día de hoy
                            </dt>
                            <dd
                                class="flex justify-between items-baseline mt-1 md:block lg:flex"
                            >
                                <div
                                    class="flex items-baseline text-2xl font-semibold text-indigo-600"
                                >
                                    {{ todayOrders }}
                                </div>
                            </dd>
                        </div>

                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-base font-normal text-gray-900">
                                Pedidos pendientes
                            </dt>
                            <dd
                                class="flex justify-between items-baseline mt-1 md:block lg:flex"
                            >
                                <div
                                    class="flex items-baseline text-2xl font-semibold text-indigo-600"
                                >
                                    {{ pendingOrders }}
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>

                <Table>
                    <template #default>
                        <template
                            :key="order.id"
                            v-for="(order, index) in orders.data"
                        >
                            <tr
                                :class="{
                                    'animate__animated animate__fadeIn': !index,
                                }"
                            >
                                <td
                                    class="px-6 py-4 space-y-2 w-32 text-sm font-medium whitespace-nowrap"
                                >
                                    <p class="text-xl text-gray-800">
                                        Order # {{ order.id }}
                                    </p>
                                    <p class="text-gray-700">
                                        Total: $ {{ order.foods.total_price }}
                                    </p>
                                    <p class="text-gray-700">
                                        Mesa: # {{ order.table_number }}
                                    </p>
                                    <p class="text-gray-700">
                                        Cliente: {{ order.client_name }}
                                    </p>
                                    <button
                                        @click="finalizeOrder(order)"
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Finalizar Pedido
                                    </button>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap"
                                >
                                    <p class="mb-1 font-bold">Platos:</p>
                                    <ul
                                        class="rounded-lg border border-gray-200 divide-y divide-gray-200"
                                    >
                                        <li
                                            class="flex items-center px-3 py-2"
                                            v-for="food in order.foods.data"
                                            :key="food.id"
                                        >
                                            <span
                                                class="inline-flex justify-center items-center p-1 w-6 h-6 mr-2 text-yellow-800 bg-yellow-100 rounded-full"
                                                >{{ food.quantity }}</span
                                            >
                                            {{ food.name }}
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </template>
                    </template>
                    <template #footer>
                        <div class="text-center py-4 bg-white text-gray-600">
                            <p
                                v-if="!orders.data.length"
                                class="flex justify-center items-center"
                            >
                                No se han creado ordenes aún
                                <svg
                                    aria-hidden="true"
                                    focusable="false"
                                    data-prefix="fal"
                                    data-icon="face-astonished"
                                    class="w-6 h-6 ml-3"
                                    role="img"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"
                                >
                                    <path
                                        fill="currentColor"
                                        d="M192 352C192 316.7 220.7 288 256 288C291.3 288 320 316.7 320 352V384C320 419.3 291.3 448 256 448C220.7 448 192 419.3 192 384V352zM256 320C238.3 320 224 334.3 224 352V384C224 401.7 238.3 416 256 416C273.7 416 288 401.7 288 384V352C288 334.3 273.7 320 256 320zM200.4 224C200.4 237.3 189.6 248 176.4 248C163.1 248 152.4 237.3 152.4 224C152.4 210.7 163.1 200 176.4 200C189.6 200 200.4 210.7 200.4 224zM312.4 224C312.4 210.7 323.1 200 336.4 200C349.6 200 360.4 210.7 360.4 224C360.4 237.3 349.6 248 336.4 248C323.1 248 312.4 237.3 312.4 224zM192 128C187.6 128 183.2 128.3 178.1 128.9C157.8 131.7 138.4 141.2 122.9 155.7C116.5 161.7 106.3 161.4 100.3 154.9C94.28 148.5 94.62 138.3 101.1 132.3C121.1 113.6 146.6 100.9 174.8 97.13C180.4 96.38 186.2 96 192 96C200.8 96 208 103.2 208 112C208 120.8 200.8 128 192 128zM333 128.9C328.8 128.3 324.4 128 320 128C311.2 128 304 120.8 304 112C304 103.2 311.2 96 320 96C325.8 96 331.6 96.38 337.2 97.13C365.4 100.9 390.9 113.6 410.9 132.3C417.4 138.3 417.7 148.5 411.7 154.9C405.7 161.4 395.5 161.7 389.1 155.7C373.6 141.2 354.2 131.7 333 128.9zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 32C132.3 32 32 132.3 32 256C32 379.7 132.3 480 256 480C379.7 480 480 379.7 480 256C480 132.3 379.7 32 256 32z"
                                    ></path>
                                </svg>
                            </p>
                        </div>
                    </template>
                </Table>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import StackedList from "@/Pages/Shared/StackedList";
import Table from "@/Pages/Shared/Table";
import { Inertia } from "@inertiajs/inertia";
import { computed } from "vue";
import FlashMessage from "@/Pages/Shared/FlashMessage";

let props = defineProps({
    orders: Object,
    todayOrders: Number,
    pendingOrders: Number,
    completedOrders: Number,
    userId: Number,
});

function finalizeOrder(order) {
    Inertia.post(
        route("orders.finalize", { id: order.id }),
        {},
        {
            onBefore: () =>
                confirm(`Seguro desea finalizar la order # ${order.id}?`),
        }
    );
}

Echo.channel(`update-order-list`).listen("UpdateOrdersEvent", (e) => {
    Inertia.reload();
});
</script>
