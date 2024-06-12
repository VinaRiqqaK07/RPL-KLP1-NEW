<?php

namespace App\Livewire\Employee\Order;

use Livewire\Component;
use App\Models\Order;

class OrderList extends Component
{
    public $orderList;

    public function mount()
    {
        $this->orderList = Order::all(); 
    }

    public function render()
    {
        return view('livewire.employee.order.order-list');
    }
}
