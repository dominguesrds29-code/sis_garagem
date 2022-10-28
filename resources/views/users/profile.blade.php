@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-spacing layout-top-spacing">
            <div class="col-lg-12">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Meus Dados</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <form name="cadUsuario" method='post' action="{{ route('user.updateProfile', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input type="hidden" name="integration_id" value="{{ $user->integration_id }}">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-6">
                                <label>Senha</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" placeholder="Senha de Usuário" autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Confirmar Senha</label>
                                <input type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation" placeholder="Confirmar Senha de Usuário">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-3">
                                <label>PST/ESPD</label>
                                <input type="text" class="form-control @error('pst_specialty') is-invalid @enderror" name="pst_specialty" placeholder="PST/ESPD" value="{{ old('pst_specialty') ?? $user->pst_specialty }}">

                                @error('pst_specialty')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-9">
                                <label>Nome do Usuário</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nome do Usuário" value="{{ old('name') ?? $user->name }}">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">
                                <label>E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" placeholder="E-mail" value="{{ old('email') ?? $user->email }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        @can('role-set')
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
                                                        {{ in_array($role, $userRoles) ? ' checked' : (old('roles') && in_array($role, old('roles')) ? ' checked' : '') }}>
                                                    <span class="slider round mt-2"></span>
                                                </label>
                                                <p style="color: #000; display: inline-block;"> {{ $role }} </p></label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        @endcan
                        @can('permission-set')
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
                                                        {{ in_array($permission, $userPermissions) ? ' checked' : (old('permissions') && in_array($permission, old('permissions')) ? ' checked' : '') }}>
                                                    <span class="slider round mt-2"></span>
                                                </label>
                                                <p style="color: #000; display: inline-block;"> {{ $permission }} </p>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        @endcan
                        <div class="form-group col-md-4 offset-md-8">
                            <button class="btn btn-primary mr-2" name="only-save" value="true">
                                <i data-feather="check"></i> Atualizar
                            </button>
                            <button class="btn btn-success mr-2">
                                <i data-feather="check"></i> Atualizar e Sair
                            </button>
                            <a class="btn btn-danger" href="{{ route('home') }}">Sair</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        @if(session()->exists('pos'))
        $(document).ready(function () {
            showNotification('{{ session()->get('text') }}',
                '{{ session()->get('backgroundColor') }}',
                '{{ session()->get('pos') }}',
                '{{ session()->get('actionText') }}',
                '{{ session()->get('actionTextColor') }}',
                '{{ session()->get('duration') }}'
            );
        });
        @endif
    </script>
@endsection
