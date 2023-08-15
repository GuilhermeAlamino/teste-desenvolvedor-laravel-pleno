@extends('admin.main-layout')

@section('content-header')
    <!-- Topbar -->
    @include('admin.components.top-bar')
    <!-- End of Topbar -->
@endsection

@section('body')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Criar Usuários</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Usúario</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="/dashboard/user">
                    @csrf
                    <div class="col-12">
                        <label htmlFor="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            autoComplete='off' />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            autoComplete='off' />
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label htmlFor="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" value=""
                            autoComplete='off' />
                        @error('password')
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
