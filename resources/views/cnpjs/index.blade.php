@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="d-flex justify-content-between">
                <h2>CNPJs</h2>
                {{-- <a class="btn btn-success d-flex align-items-center justify-content-center" href="{{ route('cnpjs.create') }}">
                    Novo
                </a> --}}
            </div>
        </div>
    </div>

    <table class="table table-bordered" id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>CNPJ</th>
                <th>Token</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cnpjs as $cnpj)
            <tr>
                <td>{{ $cnpj->id }}</td>
                <td class="cnpj-field">{{ $cnpj->cnpj }}</td>
                <td>{{ $cnpj->token }}</td>
                <td class="text-center">
                    <form action="{{ route('cnpjs.destroy', $cnpj->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('cnpjs.edit', $cnpj->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        @csrf
                        @method('DELETE')
                        {{-- <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este registro?')">
                            <i class="fas fa-trash-alt"></i>
                        </button> --}}
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
            }
        });
        $('.cnpj-field').each(function() {
            var cnpj = $(this).text();
            var formattedCnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
            $(this).text(formattedCnpj);
        });
    });
</script>
@endpush
@endsection