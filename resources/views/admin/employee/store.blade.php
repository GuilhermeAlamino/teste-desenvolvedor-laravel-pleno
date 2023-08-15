@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Criar Funcionarios</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Funcionario</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="/dashboard/employee">
                    @csrf
                    <div class="col-12">
                        <label htmlFor="firstName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="firstName" name="firstName"
                            value="{{ old('firstName') }}" placeholder='Digite nome' autoComplete='off' />
                        @error('firstName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="lastName" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" id="lastName" name="lastName"
                            value="{{ old('lastName') }}" placeholder='Digite sobrenome' autoComplete='off' />
                        @error('lastName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            placeholder='Digite email' />
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="phone" class="form-label">Phone</label>
                        <input type="phone" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                            placeholder="Digite telefone" autoComplete='off' />
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="department_id" class="form-label">Departamento</label>
                        <select class="form-control" name="department_id" value="" id="department_id"
                            aria-label="Default select example">
                            <option value="" disabled selected>Escolha um departamento</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
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
