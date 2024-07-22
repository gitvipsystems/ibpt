@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="d-flex justify-content-between">
                <h2>NCM</h2>
                <a class="btn btn-success d-flex align-items-center justify-content-center" href="{{ route('ncms.create') }}">
                    Novo
                </a>
            </div>
        </div>
    </div>
    <table class="table table-bordered" id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NCM</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ncms as $ncm)
            <tr>
                <td>{{ $ncm->id }}</td>
                <td class="ncm-field">{{ $ncm->ncm }}</td>
                <td>{{ $ncm->created_at->format('d/m/Y') }}</td>
                <td>{{ $ncm->updated_at->format('d/m/Y') }}</td>
                <td class="text-center">
                    <form action="{{ route('ncms.destroy',$ncm->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('ncms.edit',$ncm->id) }}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este registro?')" title="Excluir">
                            <i class="fas fa-trash-alt"></i>
                        </button>
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
        $('.ncm-field').each(function() {
            var ncm = $(this).text();
            var formattedNcm = ncm.replace(/(\d{4})(\d{2})(\d{2})/, '$1.$2.$3');
            $(this).text(formattedNcm);
        });
    });
</script>
@endpush
@endsection