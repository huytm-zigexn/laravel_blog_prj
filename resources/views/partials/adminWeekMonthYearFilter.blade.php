<div class="row mb-3">
    <div class="col">
        <select wire:model.live="{{ $prefix }}Week" class="form-select">
            <option value="">All Weeks</option>
            @for($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}">Week {{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="col">
        <select wire:model.live="{{ $prefix }}Month" class="form-select">
            <option value="">All Months</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}">{{$m}}</option>
            @endfor
        </select>
    </div>
    <div class="col">
        <select wire:model.live="{{ $prefix }}Year" class="form-select">
            @for($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>
    </div>
</div>