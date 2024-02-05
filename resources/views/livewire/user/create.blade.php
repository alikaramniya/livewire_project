<form wire:submit="{{ $method }}">
    <div class="form-group">
        <label for="recipient-name" class="col-form-label">name</label>
        <input type="text" wire:model="name" class="form-control" id="recipient-name">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="recipient-email" class="col-form-label">email</label>
        <input type="email" wire:model="email" class="form-control" id="recipient-email">
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="recipient-password" class="col-form-label">password</label>
        <input type="password" wire:model="password" class="form-control" id="recipient-password">
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <livewire:uploader-user />
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Send message</button>
        <div wire:loading>
            @if ($method === 'save')
               Saving ... 
            @elseif($method === 'update')
               Updating ...
            @endif
        </div>
    </div>
</form>
