<div class="form-group">
    <label for="recipient-password" class="col-form-label">file</label>
    <input type="file" wire:model.blur="file" class="form-control" id="recipient-password">
    @error('file')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
