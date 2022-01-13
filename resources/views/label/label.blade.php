<!DOCTYPE html>
<html>
    
         <style>
             /* table {
  border-collapse: collapse;
}
          /* table, th, td {
  border: 1px solid black;
} */ */
         
        </style>
        
<body>
    <div >
    <table width=1300>
        <tbody>
            <td width=30%>
                    <img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={{$data->qr_id}}' 
                            style='width:900px;height:900px;'>
              
            </td>
            <td width=70%>
                {{-- <div style="margin-right:0px">
                    <img src="http://ptmitradatasarana.com/arsip/public/uploads/2020-10/d5801db7ccbb889d955f39a73fa7ed44.png"
                    style='width:40px;height:40px;'>
                </div> --}}
                    <h4 style="font-size:72px">{{$data->nama}}</h4>
                        {{-- <br> --}}
                    {{-- <br>Nomor Rak : {{$data->nomor_rak}} --}}
                    
                    {{-- <br> --}}
                    <h4 style="font-size:36px">Alamat: <br>{{$data->alamat}}
                    <br>
                    <br>Kota: <br>{{$kota->nama}}</h4>
                
            </td>
        </tbody>
    </table>
        
        
    </div>
    
</body>
</html>