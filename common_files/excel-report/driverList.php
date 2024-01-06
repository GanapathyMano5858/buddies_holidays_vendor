<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(dirname(dirname(dirname(__FILE__)))).'/config.php';
$con = mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_) or die("Error " . mysqli_error($con));
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPExcel/PhpXlsxGenerator.php';
		
        $string_file=$fileName = 'Driver List';
      
        $excelData[] = array('<center><b><style font-size="25">'.$string_file.'</style></b></center>');

      $excelData[]=array('<b><style bgcolor="#E97451" color="#000000">S No.</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Driver Name</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Driver Contact No</style></b>',
         '<b><style bgcolor="#E97451" color="#000000">Driver Al Contact No</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Driving License</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Aadhaar No</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Update Status</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Active Status</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Status</style></b>',
        
      );
	 	
		  $driverList= mysqli_query($con,'SELECT ps_driver.*,ps_driver.status,ps_driver.blocked as vehicle_blocked,ps_driver.contact_no as driver_contact,ps_driver.contactalterno as driver_alternate FROM ps_driver  LEFT JOIN ps_transporter ON ps_transporter.t_id=ps_driver.transporter_id  where ps_transporter.t_id='.$_SESSION['trans_vendor_id'].'  and ps_driver.status!=1  ORDER BY ps_driver.id_driver DESC');
      while($rows=mysqli_fetch_assoc($driverList))
      {
      $result_array[]=$rows;
      }
   
      $i=1;
       foreach($result_array as $values) {
        $update_status=($values['status']==4?'Request Send':($values['status']==5?'Request Canceled':''));
        $acive_status=($values['status']==3?'Request Send':($values['status']==6?'Request Canceled':''));
           if ($values['driving_license']=="") {
                  $status= 'Incomplete';
                } else {
                  $status='Completed';
                }

           $lineData=array($i,$values['driver_name'],$values['driver_contact'],$values['driver_alternate'],$values['driving_license'],$values['aadhaar'],$update_status,$acive_status,$status);
           $excelData[] = $lineData;
           $i++;

       } 

    $objPHPExcel = PHPExcelGenerate\PhpXlsxGenerator::fromArray($excelData); 
      $objPHPExcel->mergeCells('A1:I1'); 
    $objPHPExcel->downloadAs($fileName.".xlsx"); 
    exit;
?>
