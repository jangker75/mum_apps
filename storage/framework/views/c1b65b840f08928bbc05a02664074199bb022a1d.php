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
                    <img src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=<?php echo e($data->qr_id); ?>' 
                            style='width:900px;height:900px;'>
              
            </td>
            <td width=70%>
                
                    <h4 style="font-size:72px"><?php echo e($data->nama); ?></h4>
                        
                    
                    
                    
                    <h4 style="font-size:36px">Alamat: <br><?php echo e($data->alamat); ?>

                    <br>
                    <br>Kota: <br><?php echo e($kota->nama); ?></h4>
                
            </td>
        </tbody>
    </table>
        
        
    </div>
    
</body>
</html>