<div class="form-group">
    <label>Operator :</label>
    <select class="form-control" wire:model='operatorId'>
        @foreach ($data as $operator)
            {{-- <livewire:operator.show :operator="$operator" :key="$operator->id" /> --}}
            <option value="{{ $operator->id }}">{{ Str::ucfirst($operator->operator_name) }}</option>
        @endforeach
    </select>
    <hr />
</div>
