<div class="row my-1 py-2">
@if($deleted)
    <div class="col-12 mb-1 text-muted text-center">{{ __('basic.actions.removed', ['name' => "Relation with {$user->name}"]) }}</div>
@else
    <div class="col-12 col-md-4 mb-1">
        {{ $user->name }}
    </div>

    <div wire:ignore class="col-12 col-md-4 form-group mb-1">
        <select name="role" wire:model="selectedRole" id="relate-business-{{ $user->getKey() }}">
            @foreach ($this->roles as $role => $roleTitle)
            <option value="{{ $role }}" @if($selectedRole === $role) selected @endif>{{ $roleTitle }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-1">
        @can("backend.{$this->authKey}.update")
        <button {{ ($saved) ? 'disabled' : '' }}
            wire:click="save"
            class="mr-0 btn btn-sm btn-icon{{ ($saved) ? ' d-none' : ' btn-info' }}"
            type="button"
            title="{{ __('basic.actions.save', ['name' => $this->itemName]) }}">
            <i class="fa fa-save"></i>
        </button>
        @endif

        @can("backend.{$this->authKey}.delete")
        <button
            wire:click="deleteRelation"
            class="mr-0 btn btn-sm btn-icon btn-danger"
            type="button"
            title="{{ __('basic.actions.trash', ['name' => $this->itemName]) }}">
            <i class="fa fa-trash"></i>
        </button>
        @endif
    </div>
@endif
</div>

@push('js')
<script>
    $(document).ready(function () {
        const selector = $('#relate-business-{{ $user->getKey() }}');
        selector.select2();
        selector.on('change', function (e) {
            @this.set('selectedRole', e.target.value);
        });
    });
</script>
@endpush
