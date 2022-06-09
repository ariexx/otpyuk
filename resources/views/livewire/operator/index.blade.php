<div class="form-group">
    <label>Operator :</label>
    <select class="form-control" wire:model='operatorId'>
        @foreach ($data as $operator)
            <livewire:operator.show :operator="$operator" :key="$operator->id" />
        @endforeach
    </select>
    <hr />
</div>
