<div class="form-group">
    <label class="form-control-label" for="role-selector">
        {{ __('basic.inputs.role') }}
    </label>

    <select {{ $attributes->merge(['class'=>"form-control"]) }} name="roles[]" multiple id="role-selector">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" @if ($model->hasRole($role)) selected @endif >{{ $role->name }}</option>
            @endforeach
    </select>
</div>

@push('js')
<script>
    $("#role-selector").select2();
</script>
@endpush
