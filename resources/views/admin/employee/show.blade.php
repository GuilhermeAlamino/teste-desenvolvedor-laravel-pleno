@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Funcionarios</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Funcionario</h6>
            </div>
            <div class="card-body">
                <form>
                    @csrf
                    <div class="col-12">
                        <label htmlFor="firstName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="firstName" name="firstName"
                            value="{{ $employees->firstName }}" placeholder='Digite nome' autoComplete='off' readonly />
                    </div>
                    <div class="col-12">
                        <label htmlFor="lastName" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" id="lastName" name="lastName"
                            value="{{ $employees->lastName }}" placeholder='Digite sobrenome' autoComplete='off' readonly />
                    </div>
                    <div class="col-12">
                        <label htmlFor="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $employees->email }}" placeholder='Digite email' readonly />
                    </div>
                    <div class="col-12">
                        <label htmlFor="phone" class="form-label">Phone</label>
                        <input type="phone" class="form-control" id="phone" name="phone"
                            value="{{ $employees->phone }}" placeholder="Digite telefone" autoComplete='off' readonly />
                    </div>
                    <div class="col-12">
                        <label htmlFor="department_id" class="form-label">Departamento</label>
                        <input type="phone" class="form-control" id="phone" name="phone"
                            value="{{ $employees->department->name ?? '' }}" autoComplete='off' readonly />
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
