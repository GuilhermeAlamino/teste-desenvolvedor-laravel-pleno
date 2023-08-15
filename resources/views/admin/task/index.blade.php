@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Gerenciar Tarefas</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Tarefas</h6>
                @if (session('success'))
                    <div class=" mt-3 alert alert-danger">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Descrição</th>
                                <th>Funcionario</th>
                                <th>Prazo</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task['id'] }}</td>
                                    <td>{{ $task['title'] }}</td>
                                    <td>{{ $task['description'] }}</td>
                                    <td>{{ isset($task['employee']->email) ? $task['employee']->email : '' }}
                                    <td>{{ $task['due_date'] }}</td>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="/dashboard/task/{{ $task->id }}"
                                                class="btn btn-primary btn-sm btn-act-table">
                                                <i class="fas fa-eye"></i> Visualizar
                                            </a>
                                            <a href="/dashboard/task/edit/{{ $task->id }}"
                                                class="btn btn-success btn-sm btn-act-table mx-1">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="/dashboard/task/delete/{{ $task->id }}" method="post">
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
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
