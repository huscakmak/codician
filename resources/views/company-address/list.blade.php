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
                            List Company Address
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                List Company Address
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
                                        <th>Address</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th style="width: 40px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($list as $address)
                                        <tr>
                                            <td>{{ $address->id }}</td>
                                            <td>
                                                {{ $address->company->company_name }}
                                            </td>
                                            <td>
                                                {{ $address->neigborhood }} {{ $address->street }}
                                                {{ $address->building_number }}/{{ $address->door_number }}
                                                {{ $address->district }}/{{ $address->province }}
                                            </td>
                                            <td>{{ $address->latitude }}</td>
                                            <td>{{ $address->longitude }}</td>
                                            <td style="width:260px;">
                                                <button class="btn btn-primary" onclick="showMap({{ $address->latitude }}, {{ $address->longitude }})" title="View Map">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                </button>
                                                <a href="{{ url('company-address/edit/'. $address->id)}}" class="btn btn-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('company-address/view/'. $address->id)}}" class="btn btn-info" title="View Details">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="{{ url('company-address/delete/'. $address->id)}}" class="btn btn-danger" title="Delete">
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

    <div class="modal fade" id="showMap">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Address Map</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="harita" style="width:100%; height:500px">

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('jsAssets')
    @parent
    <script src="http://sehirharitasi.ibb.gov.tr/api/map2.js"></script>

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

        function showMap(lat, lon){
            $('#showMap').modal('toggle');

            $('#harita').html('<iframe id="mapFrame" width="100%" height="100%" src="http://sehirharitasi.ibb.gov.tr/"><p>Tarayıcınız iframe özelliklerini desteklemiyor !</p> </iframe>');
            let ibbMAP = new SehirHaritasiAPI({mapFrame:"mapFrame",apiKey:"{{ env('IBB_API_KEY') }}"}, function(){
                ibbMAP.Nearby.Open({
                    lat: lat,
                    lon: lon,
                    distance: 500
                });
                ibbMAP.Marker.Add({
                    lat: lat,
                    lon: lon,
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
        }
    </script>
@endsection
