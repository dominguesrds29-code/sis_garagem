@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-spacing layout-top-spacing">
            <div class="col-lg-12">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Atualização de Perfil</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <form name="cadRole" method='post' action="{{ route('role.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $role->id }}">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">
                                <label>Nome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       placeholder="Nome do Perfil" value="{{ old('name') ?? $role->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">
                                <label>Permissões</label>

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
                                                        {{ in_array($permission, $rolePermissions) ? ' checked' : (old('permissions') && in_array($permission, old('permissions')) ? ' checked' : '') }}>
                                                    <span class="slider round mt-2"></span>
                                                </label> <p style="color: #000; display: inline-block;"> {{ $permission }} </p></label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <div class="form-group col-md-4 offset-md-8">
                            <button class="btn btn-success mr-2" name="only-save" value="true">
                                <i data-feather="check"></i> Atualizar
                            </button>
                            <button class="btn btn-primary mr-2">
                                <i data-feather="check"></i> Atualizar e Sair
                            </button>
                            <a class="btn btn-danger" href="{{ route('role.index') }}">Sair</a>
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
