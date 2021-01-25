<div class="row">
    <div wire:ignore class="col-12 col-md-4 form-group">
        <select name="user" wire:model="selectedUser" id="relate-project-new-user-{{ $project->getKey() }}">
            @foreach ($this->availableUsers as $user)
            <option value="{{ $user['id'] }}" @if($selectedUser === $user['id']) selected @endif>{{ $user['name'] }}</option>
            @endforeach
        </select>
    </div>

    <div wire:ignore class="col-12 col-md-4 form-group">
        <select name="role" wire:model="selectedRole" id="relate-project-new-role-{{ $project->getKey() }}">
            @foreach ($this->roles as $role => $roleTitle)
            <option value="{{ $role }}" @if($selectedRole === $role) selected @endif>{{ $roleTitle }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        @can("backend.{$this->authKey}.update")
        <button {{ ($saved) ? 'disabled' : '' }}
            wire:click="save"
            class="mr-0 btn btn-sm btn-icon{{ ($saved) ? ' d-none' : ' btn-info' }}"
            type="button"
            title="{{ __('basic.actions.save', ['name' => $this->itemName]) }}">
            <i class="fa fa-save"></i>
        </button>
        @endif
    </div>
</div>


@push('js')
<script>
    $(document).ready(function () {
        const selector = $('#relate-project-new-role-{{ $project->getKey() }}');
        selector.select2();
        selector.on('change', function (e) {
            @this.set('selectedRole', e.target.value);
        });
    });

    $(document).ready(function () {
        const selector = $('#relate-project-new-user-{{ $project->getKey() }}');
        selector.select2();
        selector.on('change', function (e) {
            @this.set('selectedUser', e.target.value);
        });
    });
</script>
@endpush
