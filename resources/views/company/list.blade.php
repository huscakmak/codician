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
                            List Company
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                List Company
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
                                        <th>Thumbnail</th>
                                        <th>Company Name</th>
                                        <th>Website URL</th>
                                        <th style="width: 40px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($list as $company)
                                        <tr>
                                            <td>{{ $company->id }}</td>
                                            <td id="thumb-{{ $company->id }}">
                                                @if($company->photo_url)
                                                    <img src="/storage/{{ $company->photo_url }}" alt="" width="150">
                                                @else
                                                    Thumb is prepairing...
                                                @endif
                                            </td>
                                            <td>{{ $company->company_name }}</td>
                                            <td>{{ $company->internet_address }}</td>
                                            <td style="width:260px;">
                                                <a href="{{ url('company/edit/'. $company->id)}}" class="btn btn-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('company-address/add/'. $company->id)}}" class="btn btn-primary" title="Add Address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </a>
                                                <a href="{{ url('company-customer/add/'. $company->id)}}" class="btn btn-default" title="Add Customer">
                                                    <i class="fas fa-user-plus"></i>
                                                </a>
                                                <a href="{{ url('company/view/'. $company->id)}}" class="btn btn-info" title="View Details">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ url('company/delete/'. $company->id)}}" class="btn btn-danger" title="Delete">
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
    <!-- jquery-validation -->
    <script src="{{ url('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/html2canvas.js') }}"></script>

    <script>
        $(function () {
            @foreach ($list as $company)
            @if(!$company->photo_url && $company->website_html)
            createThumb('{{ $company->website_html }}', {{ $company->id }});
            @endif
            @endforeach

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

                                $.ajax({
                                    url: '{{ url('company/save-thumbnail') }}',
                                    data: {
                                        image: imgData,
                                        id: id
                                    },
                                    type: 'post',
                                    success: function (response) {
                                        $('#thumb-' + id).html('<img src="/storage/'+ response +'" alt="" width="150">');
                                    }
                                });

                                document.body.removeChild(iframe);
                            }
                        });
                    });

            }

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
