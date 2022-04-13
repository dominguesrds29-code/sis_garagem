@extends('auth.layout.main')

@section('content')
<div class="form-content">
    <h1 class="">Recuperação de Senha</h1>
    <p class="signup-link"></p>
    <form method="POST" action="{{ route('password.update') }}" class="text-left">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form">

            <div id="username-field" class="field-wrapper input">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input id="email" name="email" type="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Seu E-mail" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div id="password-field" class="field-wrapper input mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nova Senha..." required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div id="password-confirm-field" class="field-wrapper input mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme a senha..." required autocomplete="new-password">
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper toggle-pass">
                    <p class="d-inline-block">Mostrar Senha</p>
                    <label class="switch s-primary">
                        <input type="checkbox" id="toggle-password" class="d-none">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value=""> {{ __('auth.send') }}</button>
                </div>
            </div>
        </div>
    </form>
    <p class="terms-conditions">© {{ date('Y') }} Todos os direitos reservados.</p>
</div>
@endsection
