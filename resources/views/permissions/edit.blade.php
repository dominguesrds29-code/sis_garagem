@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-spacing layout-top-spacing">
            <div class="col-lg-12">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Editar Permissão</h4>
                </div>
                <div class="widget-content widget-content-area">
                    <form name="cadPermission" method='post' action="{{ route('permission.update', $permission->id) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $permission->id }}">
                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">
                                <label>Nome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nome da Permissão"
                                       value="{{ old('name') ?? $permission->name }}" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group col-md-4 offset-md-8">
                            <button class="btn btn-primary mr-2" name="only-save" value="true">
                                <i data-feather="check"></i> Atualizar
                            </button>
                            <button class="btn btn-success mr-2">
                                <i data-feather="check"></i> Atualizar e Sair
                            </button>
                            <a class="btn btn-danger" href="{{ route('permission.index') }}">Sair</a>
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
