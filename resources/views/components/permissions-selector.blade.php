@foreach ($permissionGroups as $group => $permissions)
    <div class="row my-2 py-1">
        <div class="row col-12"><h4>{{ $group }}</h4></div>
        <div class="row col-12">
            @foreach ($permissions as $permission)
            <div class="col-xs-12 col-md-3">
                <x-form.checkbox :name="$permission->key" :value="$model->hasPermissionTo($permission)"
                    :title="__($permission->name)" />
            </div>
            @endforeach
        </div>
    </div>
@endforeach
