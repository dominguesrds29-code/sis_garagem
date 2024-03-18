@extends('auth.layout.main')

@section('content')
<div class="form-content">
    <h1 class="">Recuperar senha</h1>
    <p class="signup-link">Entre com seu e-mail e enviaremos as instruções para você!</p>
    <form class="text-left" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form">

            <div id="email-field" class="field-wrapper input">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value="">{{ __('auth.send') }}</button>
                    <a href="{{ route('login') }}" class="btn btn-info" value="">Voltar</a>
                </div>
            </div>

        </div>
    </form>
    <p class="terms-conditions">© {{ date('Y') }} Todos os direitos reservados. <a href="index.html">CORK</a> is a product of Designreset.</p>
</div>
@endsection
