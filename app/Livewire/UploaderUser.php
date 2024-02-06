<?php

namespace App\Livewire;

use App\Livewire\User\Create;
use App\Livewire\User\Lists;
use App\Models\Uploader;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploaderUser extends Component
{
    use WithFileUploads;

    public $file;

    public $path = '';

    public $userId;

    #[On('reset-file')]
    public function resetFile()
    {
        $this->file = null;
    }

    public function updatedFile()
    {
        $this->dispatch('hidden-old-file')->to(Create::class);
    }

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

    #[On('update-file')]
    public function updateFile(User $user)
    {
        if ($this->file) {
            $image = $user->image->image;
            if ($image) {
                $path = str_replace('storage', 'public', $image);

                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }

            $this->uploadFile();

            $user->image->update(['image' => $this->path]);
        }
    }

    private function uploadFile()
    {
        $str = $this->file->store('public/folder');

        $this->path = str_replace('public', 'storage', $str);
    }

    public function render()
    {
        return view('livewire.uploader-user');
    }
}
