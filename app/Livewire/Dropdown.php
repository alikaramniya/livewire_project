<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class Dropdown extends Component
{
    public $cities;

    public $cityName;

    public $counties = null;

    public function mount()
    {
        $this->cities = City::all();
    }

    public function updatedCityName(City $city)
    {
        $this->counties = $city->counties;

        if ($this->counties->count() == 0) {
            $this->counties = null;
        }
    }

    public function render()
    {
        return view('livewire.dropdown');
    }
}
