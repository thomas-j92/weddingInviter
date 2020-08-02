@extends('layouts.login')

@section('content')
<div class="container-fluid no-padding h-100">
    <div class="row h-100">
        <div class="col-sm-5 left-section pull-right">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 pt-3">
                   
                    <img src="{{ URL::asset('images/web/login/mill-barn-pink.png')}}" class="logo" />
                    <h2>Save The Date</h2>

                    <p class="py-3">Confirm you've seen our save the date - this way we won't need to constantly harass you for the next few months! </p>

                    @if (Session::has('success'))
        				<b-alert variant="success" show>{!! session('success') !!}</b-alert>
   					@endif

   					@if (Session::has('error'))
        				<b-alert variant="danger" show>{!! session('error') !!}</b-alert>
   					@endif

                    <form method="POST" action="{{ route('std.verify', $code) }}">
                        @csrf

                        <div class="form-group row pb-5">
                            <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-7 right-section d-none d-sm-block">
            <div class="cover"></div>
        </div>
    </div>
</div>
@endsection