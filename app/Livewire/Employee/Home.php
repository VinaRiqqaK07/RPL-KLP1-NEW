<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\Modal;

class Home extends Component
{
    public $category;
    public $menus;
    public $search;
    public $items = [];

    protected $queryString = [
        'category' => ['except' => 'semua']
    ];

    public function mount()
    {
        $this->category = request()->query('category', 'semua');
        $this->loadMenus();
    }

    public function updatedSearch()
    {
        $this->loadMenus();
    }

    public function setCategory($currentCategory)
    {
        $this->category = $currentCategory;
        $this->loadMenus();
    }

    public function loadMenus()
    {
        $query = Menu::query();

        if ($this->category !== 'semua') {
            $activeCategory = Category::where('name', $this->category)->first();
            $query->where('categories_id', $activeCategory->id);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->menus = $query->get();
    }

    public function addItem(Menu $menu)
    {
        if(isset($this->items[$menu->id])) {
            $item = $this->items[$menu->id];

            $this->items[$menu->id] = [
                'name' => $menu->name,
                'qty' => $item['qty'] + 1,
                'price' => $menu->price * ($item['qty'] + 1),
                'note' => $item['note']
            ];
        } else {
            $this->items[$menu->id] = [
                'name' => $menu->name,
                'qty' => 1,
                'price' => $menu->price,
                'note' => ''
            ];
        }
    }

    public function increaseQuantity($id)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['qty']++;
            $this->items[$id]['price'] += Menu::findOrFail($id)->price;
        }
    }

    public function decreaseQuantity($id)
    {
        if (isset($this->items[$id]) && $this->items[$id]['qty'] > 1) {
            $this->items[$id]['qty']--;
            $this->items[$id]['price'] -= Menu::findOrFail($id)->price;
        } elseif (isset($this->items[$id]) && $this->items[$id]['qty'] === 1) {
            unset($this->items[$id]);
        }
    }

    public function removeItem($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }
    }

    
    public function updateNote($id, $note)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['note'] = $note;
        }
    }

    public function clearItems()
    {
        $this->items = [];
    }

    public function getHasItemsProperty()
    {
        return !empty($this->items);
    }

    public function getSubtotalProperty()
    {
        return array_sum(array_column($this->items, 'price'));
    }

    public function getTotalItemsProperty()
    {
        return array_sum(array_column($this->items, 'qty'));
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.employee.home', [
            'menus' => $this->menus,
            'subtotal' => $this->subtotal,
            'totalItems' => $this->totalItems,
            'hasItems' => $this->hasItems
        ]);
    }
}
