<?php

namespace App\Livewire;

use App\Livewire\User\Lists;
use App\Models\Uploader;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploaderUser extends Component
{
    use WithFileUploads;

    public $file;

    public $path = '';

    public $userId;

    #[On('send-user-id')]
    public function getUserId($userId)
    {
        if ($this->file) {
            $this->uploadFile();
        }

        if ($this->path !== '') {
            Uploader::create([
                'image' => $this->path,
                'user_id' => $userId,
            ]);
        }

        $this->dispatch('record-updated')->to(Lists::class);
        $this->reset();
    }

    public function uploadFile()
    {
        $str = $this->file->store('public/folder');

        $this->path = str_replace('public', 'storage', $str);
    }

    public function render()
    {
        return view('livewire.uploader-user');
    }
}
