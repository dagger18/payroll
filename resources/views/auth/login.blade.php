@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <img class="login-logo" src="/img/logo.png" />
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <i class="icon icon-danger"></i>
                                @foreach ($errors->all() as $error)
                                    {{ $error }} <br>
                                @endforeach
                            </div>
                        @endif
                        <div class="has-float-label">
                            <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('E-Mail Address') }}</label>
                        </div>
                        <div class="has-float-label">
                            <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('Password') }}</label>
                        </div>
                        <div class="text-center">
                            <button style="width:100%;" type="submit" class="btn btn-primary style-btn" >
                                    {{ __('Login') }}
                            </button>
                            
                            @if (Route::has('password.request'))
                                <a style="margin-top: 20px;display: block;" class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
