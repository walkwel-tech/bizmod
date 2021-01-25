<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label class="form-control-label pb-2" for="input-{{ $elementId }}">
        {{ $title }}
        @if($slot)
        {{ $slot }}
        @endif
    </label>
    <textarea
        {{ $attributes->merge(['rows' => 8]) }}
        type="{{ $type }}"
        name="{{ $name }}"
        id="input-{{ $elementId }}"
        class="form-control form-control-alternative{{ $errors->has($name) ? ' is-invalid' : '' }}"
        placeholder="{{ __($placeholder) }}"
    >{{ old($name, $value) }}</textarea>

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            {!! $errors->first($name) !!}
        </span>
    @endif
</div>

@push('js')
<script>
    $("#input-{{ $elementId }}").summernote({
        height: 300,                 // set editor height
        toolbar: [
            ['style', ['clear', 'bold', 'italic', 'underline']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['forecolor', 'backcolor']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['table', 'hr']],
            ['misc', ['undo', 'redo', 'fullscreen', 'codeview']]
        ]
    });
</script>

@endpush
