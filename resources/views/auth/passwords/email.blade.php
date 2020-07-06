@extends('layouts.login')

@section('content')
<div class="container-fluid no-padding h-100" id="reset-password">
    <div class="row h-100">
        <div class="col-sm-5 left-section">
            <div class="row">
                <div class="col-sm-8 offset-sm-2">
                    <img src="{{ URL::asset('images/web/login/mill-barn-pink.png')}}" class="logo" />
                    <h2>Reset Password</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-7 right-section">
            <div class="cover"></div>
        </div>
    </div>
</div>
@endsection
