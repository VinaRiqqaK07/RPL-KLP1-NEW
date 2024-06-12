<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Order;

class MakeOrderModal extends Component
{
    public $customer_name;
    public $table_number;
    public $items = [];
    public $gross_amount;

    protected $rules = [
        'customer_name' => 'required|string|max:255',
        'table_number' => 'required|integer',
    ];

    public function mount()
    {
        // Ambil nilai query string 'table' dari URL
        $this->table_number = request()->query('table', '');
        
        // Ambil items dari session
        $this->items = Session::get('cart', []);
        
        // Hitung gross_amount dari items
        $this->gross_amount = array_reduce($this->items, function ($sum, $item) {
            return $sum + ($item['price'] * $item['qty']);
        }, 0);
    }

    public function submit()
    {
        $this->validate();

        // Create new order
        Order::create([
            'customer_name' => $this->customer_name,
            'table_number' => $this->table_number,
            'items' => json_encode($this->items),
            'gross_amount' => $this->gross_amount,
        ]);

        Session::forget('cart');

        $this->dispatch('close-modal');
        return redirect()->route('payment');
    }

    public function render()
    {
        return view('livewire.customer.make-order-modal');
    }
}
