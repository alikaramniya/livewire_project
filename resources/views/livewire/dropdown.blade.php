<div class="offset-3 col-6">
    <div class="mb-3">
        <select wire:model.live="cityName" class="form-select" aria-label="Default select example">
            <option>Open this select menu</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    </div>
    @if ($counties)
    <div class="offset-3 col-6">
        <div class="mb-3">
            <select class="form-select" aria-label="Default select example">
                @foreach ($counties as $county)
                    <option value="{{ $county->id }}">{{ $county->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
</div>
