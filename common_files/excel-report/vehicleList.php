<?php
include(dirname(dirname(dirname(__FILE__)))).'/config.php';
$con = mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_) or die("Error " . mysqli_error($con));
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPExcel/PhpXlsxGenerator.php';
		
        $string_file=$fileName = 'Vehicle List';
      
        $excelData[] = array('<center><b><style font-size="25">'.$string_file.'</style></b></center>');

      $excelData[]=array('<b><style bgcolor="#E97451" color="#000000">S No.</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Vehicle Category</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Vehicle  Name</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Vehicle No</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Vehicle MFG Year</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Active Status</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Status</style></b>'
        
      );

      $driverList= mysqli_query($con,'SELECT ps_vehicles.*,ps_vehicletypes.vehicle_category,ps_vehicletypes.vehicle_type_name,ps_vehicles.status as vehicle_status,ps_vehicletypes.vehicle_type_name as vehicle_name,ps_vehicles.blocked as vehicle_blocked FROM ps_vehicles  LEFT JOIN ps_transporter ON ps_transporter.t_id=ps_vehicles.transporter_id left join ps_vehicletypes on ps_vehicletypes.vt_id=ps_vehicles.vehicle_type where ps_transporter.t_id='.$_SESSION['trans_vendor_id'].'
       and ps_vehicles.status !=1  ORDER BY ps_vehicles.v_id DESC');
      while($rows=mysqli_fetch_assoc($driverList))
      {
      $result_array[]=$rows;
      }
   
      $i=1;
       foreach($result_array as $values) {
        $acive_status=($values['vehicle_status'] == 3 ? 'Request Send' : ($values['vehicle_status'] == 6 ? 'Request Canceled' : ''));
           if ($values['vehicle_year'] <2014 || $values['vehicle_type_name']=="") {
                  $status= 'Incomplete';
                } else {
                  $status='Completed';
                }

           $lineData=array($i,$values['vehicle_category'],$values['vehicle_type_name'],$values['vehicle_no'],$values['vehicle_year'],$acive_status,$status);
           $excelData[] = $lineData;
           $i++;

       } 

		$objPHPExcel = PHPExcelGenerate\PhpXlsxGenerator::fromArray($excelData); 
		  $objPHPExcel->mergeCells('A1:G1'); 
		$objPHPExcel->downloadAs($fileName.".xlsx"); 
		exit;
?>
