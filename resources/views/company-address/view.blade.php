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
                            Company Address Detail
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('company-address/list') }}">Company Address
                                    List</a></li>
                            <li class="breadcrumb-item active">
                                Company Address Detail
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
                    <div class="col-lg-4">

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
                                    <label>Province:</label>
                                    {{ $detail->province }}
                                </div>

                                <div class="form-group">
                                    <label>District:</label>
                                    {{ $detail->district }}
                                </div>

                                <div class="form-group">
                                    <label>Neighborhood:</label>
                                    {{ $detail->neighborhood }}
                                </div>

                                <div class="form-group">
                                    <label>Street:</label>
                                    {{ $detail->street }}
                                </div>

                                <div class="form-group">
                                    <label>Building Number:</label>
                                    {{ $detail->building_number }}
                                </div>

                                <div class="form-group">
                                    <label>Door Number:</label>
                                    {{ $detail->door_number }}
                                </div>

                                <div class="form-group">
                                    <label>Latitude:</label>
                                    {{ $detail->latitude }}
                                </div>

                                <div class="form-group">
                                    <label>Longitude:</label>
                                    {{ $detail->longitude }}
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

                    <div class="col-lg-8">
                        <div id="harita" style="width:100%; height:620px">
                            <iframe id="mapFrame" width="100%" height="100%" src="http://sehirharitasi.ibb.gov.tr/">
                                <p>Tarayıcınız iframe özelliklerini desteklemiyor !</p>
                            </iframe>
                        </div>
                    </div>
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
    <script src="http://sehirharitasi.ibb.gov.tr/api/map2.js"></script>

    <script>
        let ibbMAP = new SehirHaritasiAPI({
            mapFrame: "mapFrame",
            apiKey: "{{ env('IBB_API_KEY') }}"
        }, function () {
            ibbMAP.Nearby.Open({
                lat: {{ $detail->latitude }},
                lon: {{ $detail->longitude }},
                distance: 500
            });
            ibbMAP.Marker.Add({
                    lat: {{ $detail->latitude }},
                    lon: {{ $detail->longitude }},
                    effect: true,
                    iconUrl: ibbMAP.icons.Info,
                    zoom: 18,
                    gotoPosition: true,
                    draggable: true,
                    showPopover: true,
                    anchorX: ibbMAP.anchors.Left,
                    anchorY: ibbMAP.anchors.Top,
                    opacity:0.4
                });
        });
    </script>
@endsection
