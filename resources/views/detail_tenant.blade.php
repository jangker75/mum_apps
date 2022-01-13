@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->
  <a href="{{CRUDBooster::mainpath($slug=NULL)}}"><i class="fa fa-chevron-circle-left">&nbsp;  Back To List User</i></a>
  <div class='panel panel-default'>
    <div class='panel-heading'><b>{{$page_title}}</b></div>
    <div class='panel-body'> 

    <?php 
    $prov=DB::table('provinsi')->where('id',$data->provinsi_id)->first();
    $kota=DB::table('kota')->where('id',$data->kota_id)->first();
    $kec=DB::table('kecamatan')->where('id',$data->kecamatan_id)->first();

     ?>  

    <div class="table-responsive">
      <table id="table-detail" class="table table-striped">
        <tbody>
           <tr>
            <td><b>ID Tenant</b></td>
            <td>{{$data->qr_id}}</td>
          </tr>
           <tr>
            <td><b>Nama Tenant</b></td>
            <td>{{$data->nama}}</td>
          </tr>
          <tr>
            <td><b>Nama Client</b></td>
            <td>{{$client->nama}}</td>
        </tr>
        <tr>
          <td><b>Area</b></td>
          <td>{{$data->alamat}}</td>
        </tr>
          <tr>
            <td><b>Provinsi</b></td>
            <td>{{$prov->nama}}</td>
          </tr>
          <tr>
            <td><b>Kota</b></td>
            <td>{{$kota->nama}}</td>
          </tr>
          <tr>
            <td><b>Kecamatan</b></td>
            <td>{{$kec->nama}}</td>
          </tr>
          <tr>
            <td><b>Location</b></td>
               @if($data->latitude!=null && $data->longitude!=null)
              <td>
                <a href="https://www.google.com/maps/search/?api=1&query={{$data->latitude}},{{$data->longitude}}" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Click to see maps</a></td>
              @else
              <td><a href="javascript:void(0)" onclick="alert('Data Lokasi Tidak Ada')" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Koordinat belum ada</a></td>
              @endif
          </tr>
        </tbody>
      </table>
    </div>
    </div>
  </div>
@endsection