@extends('layouts.app', ['navbar' => true, 'footer' => true])

@section('content')
<section class="container_brand">
    <div class="page_heading_inner d-flex justify-content-between">
        <h6>Please Verify Your Identity</h6>
    </div>
    <div class="form_card">
        <section class="form_tab">
            <div class="form_tab_header">
                <h2>OTP Required</h2>
            </div>
            <div class="form_tab_wrapper">
                <form method="POST" id="otp-verification-form" action="{{ route('otp.store') }}">
                    @csrf
                    <!-- Input -->
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">One Time Password:</label>

                        <!-- Error handling -->
                        <div class="col-md-6">
                            <input
                                    id="password"
                                    type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password"
                                    required autofocus
                            >

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Verify
                            </button>
                            <a class="btn btn-link" href="{{ route('otp.resend') }}">
                                Request New
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div><!-- Row -->
</section><!-- Container -->
@endsection
