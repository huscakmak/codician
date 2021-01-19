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
                            Add Company Address
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                Add Company Address
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

                                <form action="{{ url('company-address/add') }}" method="POST" id="submitForm">
                                    @method('POST')
                                    @csrf

                                    <input type="hidden" name="company_id" value="{{ $company->id }}">

                                    <div class="form-group">
                                        <label>Company Name:</label>
                                        {{ $company->company_name }}
                                    </div>

                                    <div class="form-group">
                                        <label>Province:</label>
                                        <input type="text" class="form-control" name="province"
                                               value="{{ old('province') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>District:</label>
                                        <input type="text" class="form-control" name="district"
                                               value="{{ old('district') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Neighborhood:</label>
                                        <input type="text" class="form-control" name="neighborhood"
                                               value="{{ old('neighborhood') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Street:</label>
                                        <input type="text" class="form-control" name="street"
                                               value="{{ old('street') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Building Number:</label>
                                        <input type="text" class="form-control" name="building_number"
                                               value="{{ old('building_number') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Door Number:</label>
                                        <input type="text" class="form-control" name="door_number"
                                               value="{{ old('door_number') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Latitude:</label>
                                        <input type="text" class="form-control" name="latitude"
                                               value="{{ old('latitude') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Longitude:</label>
                                        <input type="text" class="form-control" name="longitude"
                                               value="{{ old('longitude') }}">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn check-control btn-block btn-secondary">Save
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
    <!-- jquery-validation -->
    <script src="{{ url('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $(function () {
            $('#submitForm').validate({
                rules: {
                    company_id: {
                        required: true,
                    },
                    province: {
                        required: true,
                    },
                    district: {
                        required: true,
                    },
                    neighborhood: {
                        required: true,
                    },
                    street: {
                        required: true,
                    },
                    building_number: {
                        required: true,
                    },
                    door_number: {
                        required: true,
                    },
                    latitude: {
                        required: true,
                    },
                    longitude: {
                        required: true,
                    },
                },
                messages: {
                    company_id: {
                        required: "Please enter company"
                    },
                    province: {
                        required: "Please enter province"
                    },
                    district: {
                        required: "Please enter district"
                    },
                    neighborhood: {
                        required: "Please enter neighborhood"
                    },
                    street: {
                        required: "Please enter street"
                    },
                    building_number: {
                        required: "Please enter building number"
                    },
                    door_number: {
                        required: "Please enter door number"
                    },
                    latitude: {
                        required: "Please enter latitude"
                    },
                    longitude: {
                        required: "Please enter longitude"
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $('button[type=submit]').attr('disabled', false);
                },
                submitHandler: function (form) {
                    $('button[type=submit]').attr('disabled', true);
                    form.submit();
                }
            });

            @if ($errors->any())
            $('button[type=submit]').attr('disabled', false);
            @endif

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
