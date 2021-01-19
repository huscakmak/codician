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
                            List Company Customer
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                List Company Customer
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
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Company</th>
                                        <th>Name</th>
                                        <th>E-mail Address</th>
                                        <th>Phone Number</th>
                                        <th style="width: 40px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($list as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                {{ $customer->company->company_name }}
                                            </td>
                                            <td>
                                                {{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}
                                            </td>
                                            <td>{{ $customer->email_address }}</td>
                                            <td>{{ $customer->phone_number }}</td>
                                            <td style="width:260px;">
                                                <a href="{{ url('company-customer/edit/'. $customer->id)}}" class="btn btn-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('company-customer/view/'. $customer->id)}}" class="btn btn-info" title="View Details">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ url('company-customer/delete/'. $customer->id)}}" class="btn btn-danger" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer clearfix">
                                {{ $list->links() }}
                            </div>
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
            @if(!empty(Session::get('success')))
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'SUCCESS',
                autohide: true,
                delay: 7500,
                body: '{{ Session::get('success') }}'
            });

            $('button[type=submit]').attr('disabled', false);
            @endif
        });
    </script>
@endsection
