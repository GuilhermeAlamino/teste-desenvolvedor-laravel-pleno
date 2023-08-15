@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gerenciar Departamentos</h1>
        @if (session('success'))
            <div class=" mt-3 alert alert-danger">
                {{ session('success') }}
            </div>
        @endif
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Departamentos</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ $department['id'] }}</td>
                                    <td>{{ $department['name'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="/dashboard/department/{{ $department->id }}"
                                                class="btn btn-primary btn-sm btn-act-table">
                                                <i class="fas fa-eye"></i> Visualizar
                                            </a>
                                            <a href="/dashboard/department/edit/{{ $department->id }}"
                                                class="btn btn-success btn-sm btn-act-table mx-1">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="/dashboard/department/delete/{{ $department->id }}"
                                                method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm btn-act-table">
                                                    <i class="fas fa-trash"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
