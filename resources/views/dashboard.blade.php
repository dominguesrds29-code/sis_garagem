@extends('layouts.app')

@section('content')

    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            @foreach ($viaturas as $viatura)
            <div class="col-lg-3">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">{{ $viatura->modelo }}</h5>
                        <p class="mb-0">Hodômetro Atual: {{ $viatura->kilometragem }}</p>
                        @if($viatura->isOut())
                        <a href="{{ route('saidaviatura.return', ['id' => $viatura->saidas()->active()->first()->id ]) }}" class="btn btn-danger mt-3">Retornar</a>
                        @else
                        <a href="{{ route('saidaviatura.utilizar', ['id' => $viatura->id ]) }}" class="btn btn-info mt-3">Utilizar</a>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
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
        @if(session()->exists('title'))
        showMessage('{{ session()->get('title') }}',
            '{!!  session()->get('text') !!}',
            '{{ session()->get('type') }}'
        );
        @endif
    </script>
@endsection
