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
    public $image = null;

    public $method = 'save';

    public $methodName;

    #[On('hidden-old-file')]
    public function hiddenOldFile()
    {
        $this->image = null;
    }

    #[On('user-edit')]
    public function edit(User $user)
    {
        // اگر فایلی از قبل به صورت preview در حال نمایش است ان را پاک میکنم
        $this->dispatch('reset-file')->to(UploaderUser::class); 

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->image = null;

        $this->method = 'update';

        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;

        if ($user->image) {
            $this->image = $user->image->image;
        }
    }

    #(On('new-image'))
    public function getNewImage($path)
    {
        $this->image = $path;
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
        $this->image = null; // hidden show image

        $user = User::create($this->validate());

        $this->reset();

        $this->dispatch('update-list', user: $user->id)->to(Lists::class);
        $this->dispatch('send-user-id', userId: $user->id)->to(UploaderUser::class);
    }

    public function update()
    {
        $this->dispatch('update-file', user: $this->user)->to(UploaderUser::class);

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
