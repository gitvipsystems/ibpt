@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Criar Novo NCM</h2>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Houve alguns problemas com sua entrada.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ncms.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>NCM:</strong>
                    <input type="text" name="ncm" id="ncm" class="form-control" placeholder="NCM" title="Informe um NCM com 8 números">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">            
                <a class="btn btn-warning" href="{{ route('ncms.index') }}"> Voltar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </form>
</div>
@endsection
<script>
    $(document).ready(function(){
        $('#ncm').mask('0000.00.00');
    });
</script>
@endpush