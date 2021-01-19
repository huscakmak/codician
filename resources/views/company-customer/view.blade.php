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
                            Company Customer Detail
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('company-customer/list') }}">Company Customer List</a></li>
                            <li class="breadcrumb-item active">
                                Company Customer Detail
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

                                    <div class="form-group">
                                        <label>Company Name:</label>
                                        {{ $detail->company->company_name }}
                                    </div>

                                    <div class="form-group">
                                        <label>No:</label>
                                        {{ $detail->id }}
                                    </div>

                                    <div class="form-group">
                                        <label>First Name:</label>
                                        {{ $detail->first_name }}
                                    </div>

                                    <div class="form-group">
                                        <label>Last Name:</label>
                                        {{ $detail->last_name }}
                                    </div>

                                    <div class="form-group">
                                        <label>Title:</label>
                                        {{ $detail->title }}
                                    </div>

                                    <div class="form-group">
                                        <label>E-mail Address:</label>
                                        {{ $detail->email_address }}
                                    </div>

                                    <div class="form-group">
                                        <label>Phone Number:</label>
                                        {{ $detail->phone_number }}
                                    </div>

                                    <div class="form-group">
                                        <label>Created At:</label>
                                        {{ $detail->created_at }}
                                    </div>

                                    <div class="form-group">
                                        <label>Updated At:</label>
                                        {{ $detail->updated_at }}
                                    </div>

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
