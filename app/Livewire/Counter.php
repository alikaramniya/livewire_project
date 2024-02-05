<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public $maxCount = 5;

    public function increment()
    {
        if ($this->count < $this->maxCount) {
            $this->count++;
        }
    }

    public function decrement()
    {
        if ($this->count > 0) {
            $this->count--;
        }
    }

    public function render()
    {
        return view('livewire.counter')->layoutData([
            'title' => 'welcome to livewire',
        ]);
    }
}
