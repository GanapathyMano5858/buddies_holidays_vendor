<?php
include(dirname(dirname(dirname(__FILE__)))).'/config.php';
$con = mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_) or die("Error " . mysqli_error($con));
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPExcel/PhpXlsxGenerator.php';
		if($_GET['type']==2){
        $string_file=$fileName = 'Trip Advance Unpaid Report';
      
      }
      else{
          $fileName = 'Trip Advance Payment Report('.str_replace("/","-",$_GET['from']).' To '.str_replace("/","-",$_GET['to'].')');
          $string_file='Trip Advance Payment Report ';

      }
        $excelData[] = array('<center><b><style font-size="25">'.$string_file.'</style></b></center>');

      $excelData[]=array('<b><style bgcolor="#E97451" color="#000000">S No.</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">BH Ref ID</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Client Name</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Arrival Date</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Departure Date</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Arrival</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Departure</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Trip Advance Request</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Trip Advance Payable</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Trip Advance Paid</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Adjusted From</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Paid Status</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Payment Date</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">UTR No</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Remark</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">Vehicle Remark</style></b>'
      );
	 	
		 $i = 2; $k=0;
		 $result_array=[];
		 $fromStr =str_replace("/","-",$_GET['from']);
	   $toStr =str_replace("/","-",$_GET['to']);
  
        $vendor='ve.va_transporter_id='.$_SESSION['trans_vendor_id'];
       
    
      if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""&&isset($_GET['type'])&&$_GET['type']==1)
        {

        $where='tr.payment_date BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and tr.ta_va_id!="" and tr.approval_status=2 ';
         $oderby='b.start_from asc ,ve.va_id asc';
        }
        else if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""&&isset($_GET['type'])&&$_GET['type']==2)
        {
        $where='tr.paid_status=1';
         $oderby='b.start_from asc ,ve.va_id asc';

        }
          else if(isset($_GET['type'])&&$_GET['type']==2)
        {
        $where='tr.paid_status=1 and tr.approval_status=2';
        $oderby='b.start_from asc ,ve.va_id asc';

        }
        else if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""&&isset($_GET['type'])&&$_GET['type']==3)
        {
        $where='tr.payment_date BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and (tr.paid_status=2 or (tr.paid_status=1 and tr.individual_paid_status=1))';
        $oderby='tr.payment_date asc,ve.va_id asc';
        }

        else{
        $where='tr.approval_status=2 and (tr.paid_status=2 or (tr.paid_status=1 and tr.individual_paid_status=1)) and tr.payment_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND tr.payment_date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY';
        $oderby='tr.payment_date asc,ve.va_id asc';
        }

      $ClientList='select ve.va_transporter_id, ve.va_id,b.details,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.*, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve left join ps_client as b on (ve.client_table_id=b.id_client) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id) left join ps_transporter as e on (e.t_id=ve.va_transporter_id )  where '.$where.' and b.status=0  and b.transporter_id!="" and '.$vendor.'   order by '. $oderby.'';
    

		$select= mysqli_query($con,$ClientList);
	    while($row=mysqli_fetch_assoc($select))
	    {
	    $result_array[]=$row;
	    }
        function group_list($array,$key){
	      $return =array();
	      foreach ($array as $v) {
	      $return[$v[$key]][]=$v;
	      }
	      return $return;

       }
    
    $si=0;
    $listArr = group_list($result_array,'ref_no');
    $listArra=array();

   foreach($listArr as $key1=>$value1)
   {
     $listArra[$key1] = group_list($value1,'va_id');
   }
     foreach($listArra as $key2=>$value2)
     {

       foreach($value2 as $key3=>$value3)
       {
        $count=count($value3);
         $listArraaa[$key2][$key3.'_'.$count] = group_list($value3,'request_added_date');
       }

     }

 
  
    //main loop key>client reference
    foreach($listArraaa as $keys => $list){ 
    	$total_remaining_amt=$purchase_total=0;
     
      $si++; 
          
      $sdfr=0;
   foreach($list as $keyddda=>$valuesaaaa)
      {
      foreach($valuesaaaa as $keya=>$valuesa)
      { 
          $arr_trans= $arr_trans_remarks=  $combine_value=[];  
          $arr_trans= explode(",",$valuesa[0]['rejected_vendors']);
          $arr_trans_remarks= explode(",",$valuesa[0]['remarks']);
          $combine_value=array_combine($arr_trans, $arr_trans_remarks);
      	  $j=$individual_remaining=$sum_tripadvance=$tds_trip=0;

        if($sdfr==0)
        { 
    
            $inc=$si;
            $valuesa[0]['ref_no']=$valuesa[0]['ref_no'];
            $valuesa[0]['client_name']=$valuesa[0]['client_name'];
            $startDDate= date('d/m/Y',strtotime($valuesa[0]['start_from']));
            $endDDate=date('d/m/Y',strtotime($valuesa[0]['end_to']));
            $valuesa[0]['client_arrival_name']=$valuesa[0]['client_arrival_name'];
            $valuesa[0]['client_departure_name']=$valuesa[0]['client_departure_name'];
        }
        else{
        	$inc="";
        	$valuesa[0]['ref_no']="";
        	$valuesa[0]['client_name']="";
        	$startDDate="";
        	$endDDate="";
        	$valuesa[0]['client_arrival_name']="";
        	$valuesa[0]['client_departure_name']="";

        }
       $sdfr++;
       //main loop key>Vehicle Allotemnt id
        if($j==0)
        {
        	  
         $total=0;
         
					  $ppp=1;
				
			foreach($valuesa as $keyb=>$valuesb)
                  { 
                  //    if(($valuesb['approval_status'])==1){
                 	// 	$STATUSAPP='PENDING';
                  // }
                  // else if(($valuesb['approval_status'])==2){
                  // 		$STATUSAPP='APPROVED';

                  // }
                  // else if(($valuesb['approval_status'])==3)
                  // {
                 	// 	$STATUSAPP='CANCELLED';

                  // }
                  // else{
                 	//  	$STATUSAPP='-';

                  // }
              if(($valuesb['paid_status'])==1&&$valuesb['individual_paid_status']==1){
               		 $STATUS="PARTIALLY PAID";
                }
                else if($valuesb['paid_status']==1){
                     $STATUS="PENDING";

                }
                else if(($valuesb['paid_status'])==2){
                	$STATUS='PAID';

                }
                else if(($valuesb['paid_status'])==3)
                {
               		$STATUS="UNPAID";

                }
                else{
               		$STATUS="-";

                }
         $ColorCode="";
         if($valuesa[0]['cancel_status']==1){
          $ColorCode="#99FF99";
         }
         else if($valuesa[0]['arrivedornot']==1){
          $ColorCode="#B9C7F1";
         } 
			
				  if($ppp==1){
					$valuesb['tripadvance_request']=$valuesb['tripadvance_request'];
				}
				else{
					$valuesb['tripadvance_request']="";
				}
            $adjustedFrom=json_decode($valuesb['outstanding_adjustfrom'],true);
            $cont=$comma='';
            $lll=0;
            foreach ($adjustedFrom as $key => $value) {
              $lll++;
              if($lll<count($adjustedFrom)){
                $comma=',';
              }
              else{
                $comma='';
              }

              $cont.=$value['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value['id_client']).')'.$comma;
              
            }
              if($valuesb['outstanding_adjustfrom']!=""){
                $paid_amount=$valuesb['paid_amount_adjusted'];

              }else{
                $paid_amount=$valuesb['tripadvance_paid'];

              }
	
						if(isset($combine_value[$valuesb['transporter_table_id']])&&$valuesb['transporter_table_id']!=""){
						$Remark=$combine_value[$valuesb['transporter_table_id']];
						}
						else{
						$Remark='-';
						}  
					 $lineData=array('<style bgcolor="'.$ColorCode.'" >'.$inc.'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['ref_no'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['client_name'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$startDDate.'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$endDDate.'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['client_arrival_name'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['client_departure_name'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesb['tripadvance_request'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesb['tripadvance_paid'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$paid_amount.'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$cont.'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$STATUS.'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.((($valuesb['paid_status']==1&&$valuesb['individual_paid_status']==1)||$valuesb['paid_status']==2) ?date('d/m/Y',strtotime($valuesb['payment_date'])) :'-').'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.preg_replace('/[^A-Za-z0-9\-\(\) ]/', '',$valuesb['utr']).'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$valuesb['remark'].'</style>',
            '<style bgcolor="'.$ColorCode.'" >'.$Remark.'</style>'
          );
					 $excelData[] = $lineData;
                    
					
		$i++;
		$ppp++;
	  }		//valuesb for	
				
      }
   }//list for
}// list for another

}//client(for)
					


		$objPHPExcel = PHPExcelGenerate\PhpXlsxGenerator::fromArray($excelData); 
		  $objPHPExcel->mergeCells('A1:P1'); 
		$objPHPExcel->downloadAs($fileName.".xlsx"); 
		exit;
?>
