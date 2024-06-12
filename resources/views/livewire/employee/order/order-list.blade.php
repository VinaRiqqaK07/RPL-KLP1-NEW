<div x-data="{ showOrderList: false }">
    <div
        x-show="showOrderList"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-300 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center"
        style="display: none"
    >
        <section
            class="fixed right-0 top-[60px] mb-4 me-6 mt-4 h-[84vh] w-[55vh] overflow-y-auto rounded-xl bg-[#F6FFF2] pt-4"
        >
            <section class="px-6">
                <section class="flex items-center justify-between">
                    <h1 class="text-lg font-semibold">Order List</h1>
                    <button x-on:click="showOrderList = false">
                        <i id="closeOrderList" class="fa-solid fa-xmark text-xl font-semibold"></i>
                    </button>
                </section>
                <p>Displaying today list order</p>
                <section class="flex gap-3 py-1">
                    <!-- Kategori pesanan -->
                    <section class="flex items-start gap-1">
                        <div class="flex items-center justify-between gap-2 rounded-lg bg-[#D9D9D9] px-3 py-2">
                            <i class="fa-regular fa-circle-check"></i>
                            <p class="text-xs font-semibold">In Progress</p>
                        </div>
                    </section>
                    <section class="flex items-start gap-1">
                        <div class="flex items-center justify-between gap-2 rounded-lg bg-[#D9D9D9] px-3 py-2">
                            <i class="fa-solid fa-circle-check"></i>
                            <p class="text-xs font-semibold">Completed</p>
                        </div>
                    </section>
                </section>
                <!-- Daftar pesanan -->
                @foreach ($orderList as $orderId => $order)
                    <section class="my-2 rounded-lg bg-gray-100 p-1 shadow-lg">
                        <section class="flex items-center justify-center gap-3 p-2">
                            <section class="h-full w-fit">
                                <i class="fa-solid fa-clipboard-list text-4xl text-green-500"></i>
                            </section>
                            <section class="w-full">
                                <section class="mb-2">
                                    <h3 class="text-sm font-medium">A.N. {{ $order["customer_name"] }}</h3>
                                    <p class="text-sm font-normal">Table : {{ $order["table_number"] }}</p>
                                </section>
                            </section>
                            <section>
                                <i class="fa-solid fa-chevron-right"></i>
                            </section>
                        </section>
                    </section>
                @endforeach
            </section>
        </section>
    </div>
</div>
