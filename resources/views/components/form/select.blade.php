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
    <select {{ $attributes->merge(['class'=>"form-control"]) }} name="{{ $name }}" id="{{ $id }}">
            @foreach ($options as $option)
                <option data-description='@json($option->description)' value="{{ $option->getKey() }}" @if ($selected === $option->getKey()) selected @endif >{{ $option->getSEOTitle() }}</option>
            @endforeach
    </select>

    @error($name)
        <span class="invalid-feedback" role="alert">
            {{ $error }}
        </span>
    @endif

</div>

@push('js')
<script>
    $("#{{ $id }}").select2();
</script>
@endpush
