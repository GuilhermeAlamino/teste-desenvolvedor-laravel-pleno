@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gerenciar Usúarios</h1>
        @if (session('success'))
            <div class=" mt-3 alert alert-danger">
                {{ session('success') }}
            </div>
        @endif

        @if (session('success_verify'))
            <div class=" mt-3 alert alert-success">
                {{ session('success_verify') }}
            </div>
        @endif

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>E-mail Confirmado</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user['id'] }}</td>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td class="text-center">
                                        @if ($user['email_verified_at'])
                                            <span class="text-success btn-sm btn-act-table font-weight-bold">
                                                Verificado
                                            </span>
                                        @else
                                            <form action="/dashboard/user/verify/{{ $user->id }}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-sm btn-act-table" type="submit"
                                                    class="btn btn-link p-0">
                                                    Verificar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="/dashboard/user/{{ $user->id }}"
                                                class="btn btn-primary btn-sm btn-act-table">
                                                <i class="fas fa-eye"></i> Visualizar
                                            </a>
                                            <a href="/dashboard/user/edit/{{ $user->id }}"
                                                class="btn btn-success btn-sm btn-act-table mx-1">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="/dashboard/user/delete/{{ $user->id }}" method="post">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
