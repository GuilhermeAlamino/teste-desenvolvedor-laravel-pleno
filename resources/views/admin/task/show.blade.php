@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tarefas</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tarefa</h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="col-12">
                        <label htmlFor="title" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $tasks->title }}"
                            autoComplete='off' readonly />
                    </div>
                    <div class="col-12">
                        <label htmlFor="description" class="form-label">Descrição</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3" readonly>{{ $tasks->description }}</textarea>
                    </div>
                    <div class="col-12">
                        <label htmlFor="due_date" class="form-label">Prazo</label>
                        <input type="datetime-local" class="form-control" id="due_date" name="due_date"
                            value="{{ $tasks->due_date }}" autoComplete='off' readonly />
                    </div>
                    <div class="col-12">
                        <label htmlFor="assignee_id" class="form-label">Funcionario</label>
                        @if (isset($tasks->employee->email))
                            <input type="text" class="form-control" id="assignee_id" name="assignee_id"
                                value="{{ $tasks->employee->email }}" readonly>
                        @else
                            <input type="text" class="form-control" id="assignee_id" name="assignee_id" value=""
                                readonly>
                        @endif
                        </select>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
