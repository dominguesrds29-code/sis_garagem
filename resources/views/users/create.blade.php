@extends('layouts.app')

@section('content')
        <div class="layout-px-spacing">
            <div class="row layout-spacing layout-top-spacing">
                <div class="col-lg-12">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Cadastro de Usuários</h4>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form name="cadUsuario" method='post' action="{{ route('user.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label>Vínculo com Usuário</label>
                                    <select class="placeholder form-control users @error('user_war_name') is-invalid @enderror" name="user_war_name">
                                        @forelse($users as $user)
                                            <option value="{{ $user->id }}#{{ $user->grade }}#{{ $user->specialty }}#{{ $user->war_name }}"
                                                {{ old('user_war_name') == ($user->id . '#' . $user->grade .'#' . $user->specialty . '#' . $user->war_name) ? ' selected' : '' }}>
                                                {{ $user->grade }} {{ $user->specialty }} {{ $user->war_name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>

                                    @error('user_war_name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="E-mail" value="{{ old('email') }}">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label>Papéis</label>

                                    @error('roles')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <div class="row">
                                        @foreach($roles as $role)
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                                <label>
                                                    <label class="switch s-outline s-outline-success">
                                                        <input type="checkbox" id="{{ $role }}" name="roles[]"
                                                               value="{{ $role }}"
                                                            {{ (old('roles') && in_array($role, old('roles'))) ? ' checked' : '' }}>
                                                        <span class="slider round mt-2"></span>
                                                    </label> <p style="color: #000; display: inline-block;"> {{ $role }} </p></label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                            <div class="form-row mb-2">
                                <div class="form-group col-md-12">
                                    <label>Permissões Diretas</label>

                                    @error('permissions')
                                    <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror

                                    <div class="row">
                                        @foreach($permissions as $permission)
                                            @if($permission == 'admin-acl-show' && !auth()->user()->hasRole('super-admin'))
                                                @continue
                                            @endif
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                                <label>
                                                    <label class="switch s-outline s-outline-success">
                                                        <input type="checkbox" id="{{ $permission }}" name="permissions[]"
                                                               value="{{ $permission }}"
                                                            {{ old('permissions') && in_array($permission, old('permissions')) ? ' checked' : '' }}>
                                                        <span class="slider round mt-2"></span>
                                                    </label> <p style="color: #000; display: inline-block;"> {{ $permission }} </p></label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-md-4 offset-md-8">
                                <button class="btn btn-primary mr-2" name="only-save" value="true">
                                    <i data-feather="check"></i> Cadastrar
                                </button>
                                <button class="btn btn-success mr-2">
                                    <i data-feather="check"></i> Cadastrar e Criar Novo
                                </button>
                                <a class="btn btn-danger" href="{{ route('user.index') }}">Sair</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('js')
    <script>
        $(".users").select2({
            placeholder: "Selecione uma opção...",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Nada Encontrado!";
                }
            }
        });
        @if(session()->exists('pos'))
        $(document).ready(function () {
            showNotification('{{ session()->get('caption') }}',
                '{{ session()->get('text') }}',
                '{{ session()->get('type') }}',
                '{{ session()->get('pos') }}',
                '{{ session()->get('duration') }}'
            );
        });
        @endif
    </script>
@endsection
