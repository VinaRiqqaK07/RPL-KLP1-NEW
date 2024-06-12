<div
    x-data="{
        showModal: false,
        items: [],
        selectedOrderType: '',
        selectedPaymentType: '',
    }"
    x-show="showModal"
    x-on:open-modal.window="
        items = $event.detail.items
        console.log($event.detail.items)
        console.log($event.detail.selectedOrderType)
        showModal = true
    "
    x-on:close-modal.window="showModal = false"
    x-on:keydown.escape.window="showModal = false"
    style="display: none"
    class="pointer-events-none fixed inset-0 z-50 flex items-end justify-center"
>
    <div x-on:click="showModal = false" class="fixed inset-0 bg-gray-300 opacity-40"></div>
    <div class="pointer-events-auto w-full rounded-t-xl bg-white p-4 shadow-lg">
        {{-- header modal --}}
        <section class="mb-4 mt-1 flex flex-row items-center justify-between">
            <p class="text-xl font-bold">Transaction Detail</p>
            <button x-on:click="showModal = false"><i class="fa-solid fa-circle-xmark fa-xl"></i></button>
        </section>

        <form class="flex gap-5" wire:submit.prevent="saveOrder(selectedOrderType, selectedPaymentType, items)">
            {{-- order type --}}
            <div class="w-1/2 font-medium">
                <p class="mb-2 text-lg font-medium">Order :</p>
                <section class="flex items-start gap-3">
                    <label class="flex items-center gap-2">
                        <input type="radio" wire:model="selectedOrderType" value="dine_in" />
                        <span>
                            <i class="fas fa-utensils"></i>
                            Dine-In
                        </span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" wire:model="selectedOrderType" value="take_away" />
                        <span>
                            <i class="fas fa-shopping-bag"></i>
                            Take Away
                        </span>
                    </label>
                </section>

                {{-- customer detail --}}
                <section class="flex gap-2">
                    <section class="flex w-full flex-col py-1 pe-1">
                        <label class="my-1">Customer Name</label>
                        <input
                            wire:model="customer_name"
                            type="text"
                            placeholder="Type name"
                            class="rounded-lg bg-slate-100 px-2 py-1 focus:border-blue-300 focus:outline-none focus:ring"
                        />
                        @error("customer_name")
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </section>

                    <section class="flex w-full flex-col py-1 pe-1">
                        <label class="my-1">Table Number</label>
                        <input
                            wire:model="table_number"
                            type="number"
                            placeholder="Type number"
                            class="rounded-lg bg-slate-100 px-2 py-1 focus:border-blue-300 focus:outline-none focus:ring"
                        />
                        @error("table_number")
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </section>
                </section>

                {{-- detail order --}}
                <section class="py-1">
                    {{-- @json(json_encode($items)) --}}
                    <template x-if="items.length === 0">
                        <p class="text-lg">No menu selected</p>
                    </template>

                    <label class="text-lg" x-text="'Menu selected (' + items.totalItems + ' item)'"></label>
                    <template x-for="(item, name) in items" :key="name">
                        <template x-if="typeof item !== 'number'">
                            <section class="flex justify-between pe-1">
                                <section class="flex gap-2">
                                    <p x-text="item.qty"></p>
                                    <p x-text="item.name"></p>
                                </section>
                                <section>
                                    <p x-text="'Rp' + new Intl.NumberFormat().format(item.price)"></p>
                                </section>
                            </section>
                        </template>
                    </template>
                </section>
            </div>

            <div class="w-1/2 font-medium">
                {{-- payment type --}}
                <p>Payment Detail</p>
                <section class="flex gap-3 py-1">
                    <section class="flex gap-3 py-1">
                        <label class="flex items-center gap-2">
                            <input type="radio" wire:model="selectedPaymentType" value="cash" />
                            <span>
                                <i class="fas fa-money-bill-wave"></i>
                                Cash
                            </span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" wire:model="selectedPaymentType" value="e-wallet" />
                            <span>
                                <i class="fas fa-wallet"></i>
                                E-Wallet
                            </span>
                        </label>
                    </section>
                </section>

                {{-- payment detail --}}
                <section class="flex flex-col py-1 pe-1">
                    <label class="my-1">Pay Amount</label>
                    <input
                        type="number"
                        placeholder="Type pay amount"
                        class="rounded-lg bg-slate-100 px-2 py-1 focus:border-blue-300 focus:outline-none focus:ring"
                    />
                </section>

                {{-- total --}}
                <section class="flex flex-col gap-1 py-2">
                    <section class="flex justify-between">
                        <p class="text-sm">Sub Total</p>
                        <p class="text-sm" x-text="'Rp' + new Intl.NumberFormat().format(items.subtotal)"></p>
                    </section>

                    {{--
                        <section class="flex justify-between">
                        <p class="text-sm">Discount</p>
                        <p class="text-sm">{{ ($discount ?? 0.5) * 100 }}%</p>
                        </section>
                    --}}

                    <section class="flex justify-between">
                        <p>Total</p>
                        <p x-text="'Rp' + new Intl.NumberFormat().format(items.subtotal)"></p>
                    </section>

                    <button
                        type="submit"
                        class="text-md mt-4 w-full rounded-lg bg-green-600 px-1 py-2 font-semibold text-white hover:bg-green-700"
                    >
                        Pay
                    </button>

                    <button
                        class="text-md mt-2 w-full rounded-lg bg-gray-200 px-1 py-2 font-semibold text-black"
                        wire:click="saveOrder(items)"
                    >
                        Save Order
                    </button>
                </section>
            </div>
        </form>
    </div>
</div>
