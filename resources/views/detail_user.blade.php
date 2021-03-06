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
            <td><b>NIK (Nomor Induk Kependudukan)</b></td>
            <td>{{$data->nik}}</td>
          </tr>
           <tr>
            <td><b>NIP (Nomor Induk Pegawai)</b></td>
            <td>{{$data->nip}}</td>
          </tr>
           <tr>
            <td><b>Nama</b></td>
            <td>{{$data->nama}}</td>
          </tr>
          <tr>
            <td><b>Foto</b></td>
            <td>
            <a class="example-image-link" href="{{asset($data->foto)}}"
              data-lightbox="exampler1"><img style="max-width:150px" class="img-in-tabel"
                  src="{{asset($data->foto)}}"></a>
            </td>
          </tr>
          <tr>
            <td><b>Penempatan Client</b></td>
            <td>{{$client->nama}}</td>
          </tr>
          <tr>
            <td><b>Jenis Kelamin</b></td>
            <td>{{$data->gender}}</td>
          </tr>
          <tr>
            <td><b>Alamat</b></td>
            <td>{{$data->alamat}}</td>
          </tr>
          <tr>
            <td><b>Provinsi</b></td>
            <td>{{$prov->nama}}</td>
          </tr>
          <tr>
            <td><b>Kota/Kabupaten</b></td>
            <td>{{$kota->nama}}</td>
          </tr>
          <tr>
            <td><b>Kecamatan</b></td>
            <td>{{$kec->nama}}</td>
          </tr>
          
        </tbody>
      </table>
    </div>
    </div>
  </div>
@endsection