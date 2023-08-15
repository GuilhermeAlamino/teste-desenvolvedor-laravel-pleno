@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Atualizar Departamentos</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-4">

                        <h6 class="m-0 font-weight-bold text-primary">Departamento</h6>
                    </div>
                    <div class="col-lg-8 d-flex justify-content-end">
                        <a href="/department/delete/{{ $departments->id }}" class="btn btn-danger btn-sm btn-act-table">
                            <i class="fas fa-trash"></i> Deletar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/dashboard/department/{{ $departments->id }}">
                    @method('PUT')
                    @csrf
                    <div class="col-12">
                        <label htmlFor="firstName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $departments->name }}" placeholder='Digite nome' autoComplete='off' />
                        @error('name')
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
