<?php

namespace App\Livewire\User;

use App\Livewire\UploaderUser;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public ?User $user;

    public $name = '';
    public $email = '';
    public $password = '';

    public $method = 'save';

    #[On('user-edit')]
    public function edit(User $user)
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';

        $this->method = 'update';

        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
    }

    #[On('empty-user-field')]
    public function emtpyFields()
    {
        $this->method = 'save';

        $this->reset();
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function save()
    {
        $user = User::create($this->validate());

        $this->reset();

        $this->dispatch('send-user-id', userId: $user->id)->to(UploaderUser::class);
        $this->dispatch('update-list', user: $user->id)->to(Lists::class);
    }

    public function update()
    {
        $data = $this->only(['name', 'email']);

        if (trim($this->password)) {
            $data = $this->only('name', 'email', 'password');
        }

        try {
            $updateState = $this->user->update($data);
        } catch (\Exception) {
            $updateState = false;
        }

        if ($updateState) {
            $this->dispatch('record-updated')->to(Lists::class);
        }
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
