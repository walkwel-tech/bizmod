@extends('layouts.app', ['navbar' => true, 'footer' => true])

@section('content')
<style>
    * {
        box-sizing: border-box;
    }

    .tab {
        display: none;
        width: 100%;
        height: 50%;
        margin: 0px auto;
    }

    .current {
        display: block;
    }

    body {
        background-color: #f1f1f1;
    }

    form {
        background-color: #ffffff;
        margin: 50px auto;
        font-family: Raleway;
        padding: 30px;
        width: 60%;
        min-width: 300px;
    }

    h1 {
        text-align: center;
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    .previous {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 30px;
        width: 30px;
        cursor: pointer;
        margin: 0 2px;
        color: #fff;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.8;
        padding: 5px
    }

    .step.active {
        opacity: 1;
        background-color: #69c769;
    }

    .step.finish {
        background-color: #4CAF50;
    }

    .error {
        color: #f00;
    }

</style>
<section class="container_brand">
    <h1>
        {{ $service->title }}
    </h1>
    <div class="page_heading_inner d-flex justify-content-between">
        <h3>{{ $service->description }}</h3>
    </div>

    <div class="form_card p-0">
        @foreach ($service->steps as $step)
            <div class="step.step-{{$step->name}}">
                @foreach ($step->fields as $field)
                    <pre class="field">
                        {{!!$field->toJSON()!!}}
                    </pre>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('js')
@endpush
