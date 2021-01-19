@extends('layouts.general')

@section('cssAssets')
    @parent

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('plugins/select2/css/select2.min.css') }}">
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
                            Add Company Customer
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                Add Company Customer
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

                                <form action="{{ url('company-customer/add') }}" method="POST" id="submitForm">
                                    @method('POST')
                                    @csrf

                                    <input type="hidden" name="company_id" value="{{ $company->id }}">

                                    <div class="form-group">
                                        <label>Company Name:</label>
                                        {{ $company->company_name }}
                                    </div>

                                    <div class="form-group">
                                        <label>First Name:</label>
                                        <input type="text" class="form-control" name="first_name"
                                               value="{{ old('first_name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Last Name:</label>
                                        <input type="text" class="form-control" name="last_name"
                                               value="{{ old('last_name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Title:</label>
                                        <div class="form-group">
                                            <select class="form-control select2" name="title" style="width: 100%;">
                                                <option value="">Please Select</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Mrs.">Mrs.</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Ms.">Ms.</option>
                                                <option value="Mx.">Mx.</option>
                                                <option value="Dr">Dr</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>E-mail Address:</label>
                                        <input type="text" class="form-control" name="email_address"
                                               value="{{ old('email_address') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Phone Number:</label>
                                        <input type="text" class="form-control" name="phone_number_mask"
                                               value="{{ old('phone_number') }}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                        <!-- for not use mask -->
                                        <input type="hidden" class="form-control" name="phone_number">
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
    <!-- Select2 -->
    <script src="{{ url('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ url('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            @if(old('title'))
            $("select[name='title']").val("{{ old('title') }}").trigger('change');
            @endif

            $('[data-mask]').inputmask();

            $('#submitForm').validate({
                rules: {
                    company_id: {
                        required: true,
                    },
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    email_address: {
                        required: true,
                    },
                    phone_number_mask: {
                        required: true,
                    },
                },
                messages: {
                    company_id: {
                        required: "Please enter company"
                    },
                    first_name: {
                        required: "Please enter first name"
                    },
                    last_name: {
                        required: "Please enter last name"
                    },
                    title: {
                        required: "Please select title"
                    },
                    email_address: {
                        required: "Please enter e-mail address"
                    },
                    phone_number_mask: {
                        required: "Please enter phone number"
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

                    let number = $("input[name='phone_number_mask']").val();
                    number = number.replace(' ', '').replace('(', '').replace(')', '').replace('-', '').replace('_', '');
                    $("input[name='phone_number']").val(number).trigger('change');

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
