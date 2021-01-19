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
                            Add Company
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                Add Company
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
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> ERROR!</h5>
                                        @foreach($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif

                                <form action="{{ url('company/add') }}" method="POST" id="submitForm">
                                    @method('POST')
                                    @csrf

                                    <div class="form-group">
                                        <label>Company Name:</label>
                                        <input type="text" class="form-control" name="company_name"
                                               value="{{ old('company_name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Website URL:</label>
                                        <input type="text" class="form-control" name="internet_address"
                                               value="{{ old('internet_address') }}"
                                               placeholder="Start with http:// or https://">
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
    <script type="text/javascript" src="{{ url('js/html2canvas.js') }}"></script>

    <script>
        $(function () {
            checkThumbnail();

            $('#submitForm').validate({
                rules: {
                    company_name: {
                        required: true,
                    },
                    internet_address: {
                        required: true,
                        minlength: 11
                    },
                },
                messages: {
                    company_name: {
                        required: "Please enter company name"
                    },
                    internet_address: {
                        required: "Please enter website URL",
                        minlength: "Please enter correct website URL"
                    }
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

            function checkThumbnail() {
                setTimeout(function () {
                    $.ajax({
                        method: "GET",
                        url: "{{ url('company/check-thumbnail')}}"
                    })
                        .done(function (data) {
                            if (data.id) {
                                createThumb(data.website_html, data.id);
                            }
                        });

                    checkThumbnail();
                }, 30000);
            }

            function escapeHtml(text) {
                return text
                    .replace(/&amp;/g, "&")
                    .replace(/&lt;/g, "<")
                    .replace(/&gt;/g, ">")
                    .replace(/&quot;/g, '"')
                    .replace(/&#039;/g, "'");
            }

            function createThumb(html_string, id) {
                html_string = html_string.replace(/\\/g, '');
                html_string = escapeHtml(html_string);

                let iframe=document.createElement('iframe');
                document.body.appendChild(iframe);
                $('iframe').attr("style", "width:1920px; height:0;");

                let iframeDoc=iframe.contentDocument||iframe.contentWindow.document;
                iframeDoc.body.innerHTML=html_string;

                $("iframe").ready(function (){
                    html2canvas(iframeDoc.body, {
                        onrendered: function (canvas) {
                            let img = canvas.toDataURL("image/png");

                            let imgData = img.replace(/^data:image\/(png|jpg);base64,/, "");
console.log(imgData);
                            $.ajax({
                                url: '{{ url('company/save-thumbnail') }}',
                                data: {
                                    image: imgData,
                                    id: id
                                },
                                type: 'post',
                                success: function (response) {

                                }
                            });

                            document.body.removeChild(iframe);
                        }
                    });
                });

            }
        });
    </script>
@endsection
