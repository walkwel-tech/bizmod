<div class="form-group">
    <label class="">Country</label>

    <select name="country[{{ $prefix }}]" class="form-control @error('country') is-invalid @enderror" @if ($readonlyCountry ?? false) disabled @endif >
        @foreach($countries as $country)
        <option value="{{ $country->id }}" @if($model->relatesToCountry($country) || collect(old('country'))->contains($country->id)) selected @endif >{{ \Str::title($country->name) }}</option>
        @endforeach
    </select>

    @error('country')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group">
    <label class="">State</label>

    <select name="state[{{ $prefix }}]" class="form-control @error('state') is-invalid @enderror">
        @foreach($states as $state)
        <option value="{{ $state->id }}" @if($model->relatesToState($state) || collect(old('state'))->contains($state->id)) selected @endif >{{ \Str::title($state->name) }}</option>
        @endforeach
    </select>

    @error('state')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="form-group">
    <label class="">City</label>

    <select name="city[{{ $prefix }}]" class="form-control @error('city') is-invalid @enderror">
        @foreach($cities as $city)
        <option value="{{ $city->id }}" @if($model->relatesToCity($city) || collect(old('city'))->contains($city->id)) selected @endif >{{ \Str::title($city->name) }}</option>
        @endforeach
    </select>

    @error('city')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>


@push('js')
<script>
    $(function () {
        $('[name="country[{{ $prefix }}]"]').select2();
        $('[name="state[{{ $prefix }}]"]').select2();
        $('[name="city[{{ $prefix }}]"]').select2();
    });

    $('[name="country[{{ $prefix }}]"]').change(function (event) {
        let country = $(event.target);
        $('[name="state[{{ $prefix }}]"]').empty();
        $('[name="city[{{ $prefix }}]"]').empty();

        $.get(fetchStatesURL, {
            country_id: country.val()
        }).done(function (response) {
            response.forEach(item => {
                $('[name="state[{{ $prefix }}]"]').append(new Option(item.name, item.id, false, false));
            });

            if (statesSelected["{{ $prefix }}"]) {
                $('[name="state[{{ $prefix }}]"]').val(statesSelected["{{ $prefix }}"]);
            }

            $('[name="state[{{ $prefix }}]"]').trigger('change');
        }).fail(function (e) {
            console.error(e);
        });
    });


    $('[name="state[{{ $prefix }}]"]').change(function (event) {
        let state = $(event.target).val();
        if (!state) {
            return;
        }

        $('[name="city[{{ $prefix }}]"]').empty();

        $.get(fetchCitiesURL, {
            state_id: state
        }).done(function (response) {
            response.forEach(item => {
                $('[name="city[{{ $prefix }}]"]').append(new Option(item.name, item.id, false, false));
            });

            if (citiesSelected["{{ $prefix }}"]) {
                $('[name="city[{{ $prefix }}]"]').val(citiesSelected["{{ $prefix }}"]);
            }

            $('[name="city[{{ $prefix }}]"]').trigger('change');
        }).fail(function (e) {
            console.error(e);
        });
    });
</script>

<script>
    $(function () {
        $('[name="country[{{ $prefix }}]"]').trigger('change');
    });
</script>
@endpush
