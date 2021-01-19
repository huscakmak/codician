@extends('layouts.general')

@section('cssAssets')
    @parent

@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            Delete Company Customer
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                Delete Company Customer
                            </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-ban"></i> ERROR!</h5>
                                        @foreach($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif

                                <form action="{{ url('company-customer/delete/' . $detail->id) }}" method="POST" id="submitForm">
                                    @method('DELETE')
                                    @csrf

                                    <div class="form-group">
                                        <label>Company Name:</label>
                                        {{ $detail->company->company_name }}
                                    </div>

                                    <div class="form-group">
                                        <label>No:</label>
                                        {{ $detail->id }}
                                    </div>

                                    <div class="form-group">
                                        <label>Name:</label>
                                        {{ $detail->title }} {{ $detail->first_name }} {{ $detail->last_name }}
                                    </div>

                                    <div class="form-group mt-5">
                                        Do you want to delete this customer?
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn check-control btn-block btn-danger">Delete
                                        </button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('jsAssets')
    @parent

    <script>
        $(function () {

        });
    </script>
@endsection
