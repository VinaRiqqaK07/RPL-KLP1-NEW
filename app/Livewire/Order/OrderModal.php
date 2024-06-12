<?php

namespace App\Livewire\Order;

use App\Models\Order;
use LivewireUI\Modal\ModalComponent;

class OrderModal extends ModalComponent
{

    public $customer_name;
    public $table_number;

    public function render()
    {
        return view('livewire.employee.order.order-modal');
    }

    // public function saveOrder($selectedOrderType, $selectedPaymentType, $items)
    public function saveOrder($items)
    {
        // Validate the form data if needed
        $this->validate([
            'customer_name' => 'required',
            'table_number' => 'required|integer',
        ]);

        // dd($items['subtotal']);

        // Create a new order instance
        $order = new Order();
        $order->customer_name = $this->customer_name;
        $order->table_number = $this->table_number;
        $order->order_type = 'dine_in';
        $order->payment_type = 'cash';
        // Assuming payment amount is also filled from the form
        // $order->payment_amount = $this->payment_amount;
        $order->items = json_encode($items); // Assuming $items is an array
        // $order->gross_amount = $items['subtotal'];
        $order->gross_amount = 100000;
        $order->save();

        $this->dispatch('closeModal');
    }
}
