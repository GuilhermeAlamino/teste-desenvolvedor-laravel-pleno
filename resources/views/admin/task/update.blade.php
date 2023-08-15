@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Atualizar Tarefas</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-4">

                        <h6 class="m-0 font-weight-bold text-primary">Tarefas</h6>
                    </div>
                    <div class="col-lg-8 d-flex justify-content-end">
                        <a href="/dashboard/task/delete/{{ $tasks->id }}" class="btn btn-danger btn-sm btn-act-table">
                            <i class="fas fa-trash"></i> Deletar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/dashboard/task/{{ $tasks->id }}">
                    @method('PUT')
                    @csrf
                    <div class="col-12">
                        <label htmlFor="title" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $tasks->title }}"
                            autoComplete='off' />
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="description" class="form-label">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{ $tasks->description }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="due_date" class="form-label">Prazo</label>
                        <input type="datetime-local" class="form-control" id="due_date" name="due_date"
                            value="{{ $tasks->due_date }}" autoComplete='off' />
                        @error('due_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="assignee_id" class="form-label">Funcionario</label>
                        <select class="form-control" name="assignee_id" id="assignee_id"
                            aria-label="Default select example">
                            @if (empty($tasks->employee->email))
                                <option value="" selected>Escolha um funcionário</option>

                                @foreach ($employees as $employee)
                                    <option value="{{ $employee['id'] }}">{{ $employee['email'] }}</option>
                                @endforeach
                            @else
                                <option value="{{ $tasks->employee->id }}" selected>
                                    {{ $tasks->employee->email }}
                                </option>

                                @foreach ($employees as $employee)
                                    <option value="{{ $employee['id'] }}">{{ $employee['email'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('assignee_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if (session('success'))
                            <div class=" mt-3 alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="col-12 pt-3">
                        <button type="submit" class="form-control btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
