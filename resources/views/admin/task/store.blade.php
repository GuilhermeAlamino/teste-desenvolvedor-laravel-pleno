@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Criar Tarefas</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tarefas</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="/dashboard/task/">
                    @csrf
                    <div class="col-12">
                        <label htmlFor="title" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                            placeholder='Digite titulo' autoComplete='off' />
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="description" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="description" name="description"
                            value="{{ old('description') }}" placeholder='Digite descrição' autoComplete='off' />
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="due_date" class="form-label">Prazo</label>
                        <input type="datetime-local" class="form-control" id="due_date" name="due_date"
                            value="{{ old('due_date') }}" autoComplete='off' />
                        @error('due_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="assignee_id" class="form-label">Funcionario</label>
                        <select class="form-control" name="assignee_id" id="assignee_id"
                            aria-label="Default select example">
                            <option value="" disabled selected>Escolha um funcionário</option>
                            @foreach ($employees as $employee)
                                @if (isset($employee))
                                    <option value="{{ $employee['id'] }}">{{ $employee['email'] }}
                                    </option>
                                @endif
                            @endforeach
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
                        <button type="submit" class="form-control btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
