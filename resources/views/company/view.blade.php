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
                            Company Detail
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('company/list') }}">Company List</a></li>
                            <li class="breadcrumb-item active">
                                Company Detail
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
                    <div class="col-md-4">

                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    @if($detail->photo_url)
                                        <img class="profile-user-img img-fluid"
                                             src="/storage/{{ $detail->photo_url }}"
                                             alt="">
                                    @endif
                                </div>

                                <h3 class="profile-username text-center">{{ $detail->company_name }}</h3>

                                <p class="text-muted text-center">{{ $detail->internet_address }}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>No</b> <a class="float-right">{{ $detail->id }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Created At</b> <a class="float-right">{{ $detail->created_at }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Updated At</b> <a class="float-right">{{ $detail->updated_at }}</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-lg-4">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Addresses</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                @foreach($detail->address as $address)
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $address->latitude }},{{ $address->longitude }}
                                    </strong>
                                    <p class="text-muted">
                                        {{ $address->neigborhood }} {{ $address->street }}
                                        {{ $address->building_number }}/{{ $address->door_number }}
                                        {{ $address->district }}/{{ $address->province }}
                                    </p>

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

                                    <hr>
                                @endforeach

                                @if(count($detail->address) > 0)
                                    <a href="{{ url('company-address/list/'. $detail->id)}}" class="btn btn-secondary">
                                        See All
                                    </a>
                                @else
                                    There is no result.
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Customers</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                @foreach($detail->customer as $customer)
                                    <strong><i class="fas fa-user-alt mr-1"></i>
                                        {{ $customer->title }} {{ $customer->first_name }} {{ $customer->last_name }}
                                    </strong>
                                    <p class="text-muted">
                                        {{ $customer->email_address }} | {{ $customer->phone_number }}
                                    </p>

                                    <a href="{{ url('company-customer/edit/'. $customer->id)}}" class="btn btn-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ url('company-customer/view/'. $customer->id)}}" class="btn btn-info" title="View Details">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ url('company-customer/delete/'. $customer->id)}}" class="btn btn-danger" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                    <hr>
                                @endforeach

                                @if(count($detail->customer) > 0)
                                    <a href="{{ url('company-customer/list/'. $detail->id)}}" class="btn btn-secondary">
                                        See All
                                    </a>
                                @else
                                    There is no result.
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
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
