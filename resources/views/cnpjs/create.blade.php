@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-5">
                <h2>Novo CNPJ</h2>
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

    <form action="{{ route('cnpjs.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>CNPJ:</strong>
                    <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Token:</strong>
                    <input type="text" name="token" class="form-control" placeholder="Token">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">            
                <a class="btn btn-warning" href="{{ route('cnpjs.index') }}"> Voltar</a>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#cnpj').mask('00.000.000/0000-00');
    });
</script>
@endpush