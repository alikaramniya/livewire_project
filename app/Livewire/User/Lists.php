<?php

namespace App\Livewire\User;

use App\Models\Uploader;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class Lists extends Component
{
    public $users;

    public $stateSelectAll;

    public $sureMessage = 'از پاک کردن کاربر های انتخاب شده مطمعن هستید';

    public $fields = [];

    public $checked = '';

    public function mount()
    {
        $users = User::get();

        if ($users->count()) {
            $this->users = $users;
        } else {
            $this->users = collect([]);
        }
    }

    public function updated($name, $value)
    {
        if ($name == 'stateSelectAll' && $this->stateSelectAll) {
            $this->fields = $this->users->pluck('id');
        } elseif ($name == 'stateSelectAll') {
            $this->fields = [];
        }

        if (str_starts_with($name, 'field')) {
            if (count($this->fields) === $this->users->count()) {
                $this->stateSelectAll = true;
                $this->dispatch('record-updated');
            }

            if (in_array($value, (array) $this->fields)) {
                return;
            }

            $this->stateSelectAll = false;
        }

        if ($this->stateSelectAll) {
            $this->sureMessage = 'آیا از پاک کردن همه کاربر ها مطمعن هستید';
        }
    }

    public function deleteAll()
    {
        if ($this->stateSelectAll == true) {
            $images = Uploader::pluck('image')->toArray();

            if ($images) {
                $this->deleteFileAndDirectory($images);
            }

            DB::table('users')->delete();

            $this->users = [];

            $this->stateSelectAll = false;
        } else {
            if ($this->fields) {
                $images = Uploader::whereIn('user_id', $this->fields)->pluck('image')->toArray();

                if ($images) {
                    $this->deleteFileAndDirectory($images);
                }

                User::whereIn('id', $this->fields)->delete();

                $this->fields = [];

                $this->dispatch('record-updated');
            }
        }
    }

    public function delete($userId): void
    {
        $user = User::with('image')->find($userId);

        if ($user->image) {
            $this->deleteFileAndDirectory([$user->image->image]);
        }

        try {
            $state = $user->delete();
        } catch (\Exception) {
            $state = false;
        }

        if ($state) {
            $this->users = $this->users->reject(
                fn ($user) => $user->id === $userId
            );
        }
    }

    private function deleteFileAndDirectory($images): void
    {
        foreach ($images as $image) {
            $path = str_replace('storage', 'public', $image);

            if (Storage::fileExists($path)) {
                Storage::delete($path);
            }
        }
    }

    #[On('update-list')]
    public function updateList(User $user)
    {
        if ($this->users) {
            /* $this->users->prepend($user); */ // desc
            $this->users->push($user); // asc
        }
    }

    #[On('record-updated')]
    public function render()
    {
        return view('livewire.user.lists');
    }
}
