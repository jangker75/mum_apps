@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
  <a href="{{CRUDBooster::mainpath($slug=NULL)}}"><i class="fa fa-chevron-circle-left">&nbsp;  Back To List Visit</i></a>
  <div class='panel panel-default'>
    <div class='panel-heading'><b>{{$page_title}}</b></div>
    <div class='panel-body'> 

    <?php 
    $kab=DB::table('provinsi')->where('id',$tenant->provinsi_id)->first();
    $prov=DB::table('kota')->where('id',$tenant->kota_id)->first();
    $product=DB::table('kecamatan')->where('id',$tenant->kecamatan_id)->first();

     ?>  

    <div class="table-responsive">
      <table id="table-detail" class="table table-striped">
        <tbody>
           <tr>
            <td><b>NIK</b></td>
            <td>{{$user->nik}}</td>
          </tr>
           <tr>
            <td><b>Nama</b></td>
            <td>{{$user->nama}}</td>
          </tr>
          <tr>
            <td><b>Timescan</b></td>
            <td>{{$data->created_at}}</td>
          </tr>
          <tr>
            <td><b>Nama Lokasi</b></td>
            <td>{{$tenant->nama}}</td>
          </tr>
          <tr>
            <td><b>Area</b></td>
            @if($data->latitude!=null && $data->longitude!=null)
              <td>
                <a href="https://www.google.com/maps/search/?api=1&query={{$tenant->latitude}},{{$tenant->longitude}}" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;{{$tenant->alamat}}</a></td>
              @else
              <td><a href="javascript:void(0)" onclick="alert('Data Lokasi Tidak Ada')" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;not Found</a></td>
              @endif
          </tr>
         
          <tr>
            <td><b>Status Visit</b></td>
            @if ($data->status_radius_visit == "In Range")
              
            <td><span class="label label-success">{{$data->status_radius_visit}}</span></td>
            @else
            <td><span class="label label-danger">{{$data->status_radius_visit}}</span></td>
            @endif
            
          </tr>
           <tr>
            <td><b>Realtime scan location</b></td>
               @if($data->latitude!=null && $data->longitude!=null)
              <td>
                <a href="https://www.google.com/maps/search/?api=1&query={{$data->latitude}},{{$data->longitude}}" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Click to see maps</a></td>
              @else
              <td><a href="javascript:void(0)" onclick="alert('Data Lokasi Tidak Ada')" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;not Found</a></td>
              @endif
          </tr>
          <tr>
            <td><b>Notes/Keterangan</b></td>
            <td>{{$data->notes}}</td>
          </tr>
          <tr>
            <td><b>Foto Bukti Visit</b></td>
            <td>
            <a class="example-image-link" href="{{asset($data->foto1)}}"
              data-lightbox="exampler1"><img style="max-width:150px" class="img-in-tabel"
                  src="{{asset($data->foto1)}}"></a>
            </td>
          </tr>
          {{-- <tr>
            <td><b>MAPS</b></td>
            <td><div id="googleMap" style="width:300px;height:250px;"></div></td>
          </tr> --}}
        </tbody>
      </table>
    </div>
    </div>
  </div>

  <script>
    function myMap() {
    var mapProp= {
      center:new google.maps.LatLng({{$tenant->latitude}},{{$tenant->longitude}}),
      zoom:15,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key={{CRUDBooster::getSetting('google_api_key')}}&callback=myMap"></script>
@endsection