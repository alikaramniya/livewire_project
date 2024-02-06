<div class="form-group">
    @if ($file)
        <div style="text-align: center;">
            <img src="{{ $file->temporaryUrl() }}" class="" width="100" height="50" alt="">
        </div>
    @endif
    <label for="recipient-password" class="col-form-label">file</label>
    <input type="file" wire:model.blur="file" class="form-control" id="recipient-password">
    @error('file')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
