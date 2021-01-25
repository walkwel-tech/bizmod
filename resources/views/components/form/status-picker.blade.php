<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if (!$hideLabel)
    <label class="form-control-label pb-2" for="input-{{ $name }}">
        {{ $title }}
        @if($slot)
        {{ $slot }}
        @endif
    </label>
    @else
    @if($slot)
    {{ $slot }}
    @endif
    @endif
    <select {{ $attributes->merge(['class'=> "form-control is-invalid" ]) }} name="{{ $name }}" id="selector-{{ $name }}">
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @if ($selected === $key) selected @endif >{{ $option }}</option>
        @endforeach
    </select>

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>

@push('js')
<script>
    $("#selector-{{ $name }}").select2();
</script>
@endpush
