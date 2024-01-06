<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include(dirname(dirname(dirname(__FILE__)))).'/config.php';
$con = mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_) or die("Error " . mysqli_error($con));
date_default_timezone_set('Asia/Kolkata');
require_once 'PHPExcel/PhpXlsxGenerator.php';

      if($_GET['type']==2){
         $file_string1='Unpaid Bill Details Report';
         $file_string='Unpaid Bill Details Report ('.date('d-m-Y H:i:a').')';

      }
      elseif($_GET['type']==3){
        $file_string='Paid Bill Details Report ('.str_replace("/","-",$_GET['from']).' To '.str_replace("/","-",$_GET['to'].')');
        $file_string1='Paid Bill Details Report';


      }
      else{
      
        $file_string='Bill Details Report ('.str_replace("/","-",$_GET['from']).' To '.str_replace("/","-",$_GET['to'].')');
        $file_string1='Bill Details Report';

      }
      $fileName = $file_string; //your file name
      // Define column names 
      if($_GET['type']==3){
          $paid_label='Paid';
          $received_label='Received';

         }
         elseif($_GET['type']==2){
           $paid_label='Payable';
           $received_label='Receivable';

         }
 
 $i = 3; $pay=$purchase=$tds=$trip=$driverAmt=0; $k=$si=0;
     $result_array=[];
       $fromStr =str_replace("/","-",$_GET['from']);
       $toStr =str_replace("/","-",$_GET['to']);
     $type=$_GET['type'];
      
        $vendor='ve.va_transporter_id='.$_SESSION['trans_vendor_id'];
     
    
          if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""&&isset($_GET['type'])&&$_GET['type']==1)
      { 
        //and ve.approval_status_adjust=1
       $where='b.end_to BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" ';
       $orderby='order by b.end_to asc';
 
      }
  
    else if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""&&isset($_GET['type'])&&$_GET['type']==3)
        {
       $where='ve.adjust_paid_date_allotment BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and ve.paid_status_bill_allotment=1';
        $orderby='order by ve.adjust_paid_date_allotment desc';
      }
      else if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""&&isset($_GET['type'])&&$_GET['type']==2)
        {
       $where='b.end_to BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%" or(ve.purchase_rate_approval_status=0 and ve.purchaserate_added_date!="0000-00-00 00:00:00") or (ve.purchase_rate_approval_status=1 and ve.approval_status_adjust=0) or (ve.approval_status_adjust=1 and ve.paid_status_bill_allotment=0))';
        $orderby='order by b.end_to desc';
      }
  
    else if(isset($_GET['type'])&&$_GET['type']==2)
        {
           //$where='ve.approval_status_adjust=1 and ve.paid_status_bill_allotment=0';
        $where='b.cancel_status=0 and b.arrivedornot=0 and b.end_to<CURDATE() and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%" or(ve.purchase_rate_approval_status=0 and ve.purchaserate_added_date!="0000-00-00 00:00:00") or (ve.purchase_rate_approval_status=1 and ve.approval_status_adjust=0) or (ve.approval_status_adjust=1 and ve.paid_status_bill_allotment=0))';
        $orderby='order by b.end_to asc';
        }
  
      else{
             $where='ve.adjust_paid_date_allotment BETWEEN  "'.date('Y-m-d',strtotime("-1 week")).'" AND "'.date('Y-m-d').'" and ve.paid_status_bill_allotment=1';
             $orderby='order by ve.adjust_paid_date_allotment desc';
      
          }
       
  $ClientList ='select ve.outstanding_adjustto,ve.outstanding_adjustfrom,cd_h.va_start_date as his_start_date,Amt.received_amount,ve.remark_adjust_allotment,ve.adjust_amount_allotment,ve.utr_bill_allotment,ve.adjust_paid_date_allotment,ve.paid_status_bill_allotment,e.panno ,a.company_name,date(ve.purchase_rate_approval_date) as purchase_approved_date,ve.approval_status_adjust,ve.va_start_date,ve.trip_went_not,ve.va_end_date,ve.purchase_rate_approval_status,ve.add_purchse_rate_remark,ve.add_purchase_rate_cal, ve.purchaserate_added_date,ve.va_transporter_id,ve.purchase_rate_shared,ve.va_id,b.reason_cancel,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.tripadvance_paid,tr.payment_date, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve left join ps_client as b on (ve.client_table_id=b.id_client) left join ps_driver_receivedamt as Amt on (Amt.va_id=ve.va_id) left join ps_agent as a on(a.id_agent=b.agent_id) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id and (tr.paid_status=2 ||tr.individual_paid_status=1)) left join ps_transporter as e on (e.t_id=ve.va_transporter_id ) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=b.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  where '.$where.' and '.$vendor.'  and b.status=0  and b.transporter_id!="" and ve.va_driver_id!=0 and ve.va_vehicle_id!=0 and  ve.va_transporter_id!=64 and ve.purchaserate_added_date!="0000-00-00 00:00:00" '.$orderby.'';

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
    

    $listArr = group_list($result_array,'ref_no');
    $listArra=array();

   foreach($listArr as $key1=>$value1)
   {
     $listArra[$key1] = group_list($value1,'va_id');
   }
   $excelData[] = array('<center><b><style font-size="25">'.$file_string1.'</style></b></center>');
   $excelData[] = array('<b><style bgcolor="#E97451" color="#000000">S No</style></b>',
    '<b><style bgcolor="#E97451" color="#000000">BH Ref ID </style></b>', 
    '<b><style bgcolor="#E97451" color="#000000">Client Name </style></b>', 
    '<b><style bgcolor="#E97451" color="#000000">Arrival </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Trip Date </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Bill Amount </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">TDS </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Trip Advance </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Trip Advance Payment Date </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Driver Received Amount </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Remaining Individual '.$paid_label.' amount </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Adjusted From </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Adjusted To </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Trip Remark </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Paid Status </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">Payment Date </style></b>',
    '<b><style bgcolor="#E97451" color="#000000">UTR No </style></b>'
  );
 //main loop key>client reference
    foreach($listArra as $keys => $list){ 
      $purchase_total=0;

      $si++; 
      $sdfr=0;
      $individual_remainingsss=0;
      foreach($list as $keya=>$valuesa)
      { $j=$individual_remaining=$sum_tripadvance=$tds_trip=0;

    $query = "SELECT SUM(tripadvance_paid) AS totalTripAdvance FROM ps_trip_advance WHERE ta_va_id = ".$valuesa[0]['va_id']." AND (paid_status = 2 OR individual_paid_status = 1)";

    $result = mysqli_query($con, $query);

    if ($result) {

      $row = mysqli_fetch_assoc($result);
      $sum_tripadvance = $row['totalTripAdvance'];
  }


       //main loop key>Vehicle Allotemnt id
        if($j==0)
        { $i=0;
           foreach($valuesa as $keyb=>$valuesb)
        {

            if($sdfr==0)
            {
              $inc=$si;
              $valuesa[0]['ref_no']=$valuesa[0]['ref_no'];
              $valuesa[0]['client_name']=$valuesa[0]['client_name'];
              $valuesa[0]['client_arrival_name']=$valuesa[0]['client_arrival_name'];

            }
            else{
                $inc="";
                $valuesa[0]['ref_no']="";
                $valuesa[0]['client_name']="";
                $valuesa[0]['client_arrival_name']="";
              }
              //$sum_tripadvance=$sum_tripadvance+$valuesb['tripadvance_paid'];
                //  $pan_4th_char=substr($valuesa[0]['panno'], 3, 1);
                //   if($pan_4th_char=='p'||$pan_4th_char=='P')
                //   {
                  $tds_trip=$valuesa[0]['purchase_rate_shared']*0.01;

                //   }
                //   else {

                //   $tds_trip=$valuesa[0]['purchase_rate_shared']*0.02;
                //   }
                   if($j==0&&$i==0){
                  $individual_remaining=$valuesa[0]['purchase_rate_shared']-($sum_tripadvance+round($tds_trip)+$valuesa[0]['received_amount']);
                   if(($valuesa[0]['approval_status_adjust']==1&&$valuesa[0]['outstanding_adjustfrom']!="")||$valuesa[0]['paid_status_bill_allotment']==1){   
                          
                               $individual_remaining=$valuesa[0]['adjust_amount_allotment'];
                      }
                      //if($individual_remaining>0){
          $individual_remainingsss=+$individual_remaining;
         //} 
       }
          $purchase_total=$purchase_total+$valuesa[0]['purchase_rate_shared'];    
          
                
             if($valuesa[0]['paid_status_bill_allotment']==1){
            $STATUS='PAID';
          }
               else if($valuesa[0]['paid_status_bill_allotment']==0){
               
            if($valuesa[0]['purchaserate_added_date']=="0000-00-00 00:00:00")
              {
             
             $STATUS="Not Added";
              }
         elseif($valuesa[0]['purchase_rate_approval_status']==0 and $valuesa[0]['purchaserate_added_date']!="0000-00-00 00:00:00"){
              $STATUS="Awaiting for approval";
         }
         elseif($valuesa[0]['purchase_rate_approval_status']==1 and $valuesa[0]['approval_status_adjust']==0){
             $STATUS="Awaiting for payment";
         }
         elseif($valuesa[0]['approval_status_adjust']==1 and $valuesa[0]['paid_status_bill_allotment']==0){
              $STATUS="Awaiting for payment";
         }
            
        }
         
           if($valuesa[0]['purchase_rate_approval_status']==1){
            $STATUSAPP='APPROVED';

          }
          else if($valuesa[0]['purchase_rate_approval_status']==0 and $valuesa[0]['purchaserate_added_date']!="0000-00-00 00:00:00"){
            $STATUSAPP='PENDING';

          }
          
        else {
          $STATUSAPP='-';

        }
              
         $total=0;
        $y=$i;
        $payment_date=(($valuesa[0]['adjust_paid_date_allotment']!='0000-00-00'&& isset($valuesa[0]['adjust_paid_date_allotment'])&& $valuesa[0]['paid_status_bill_allotment']==1) ? date('d/m/Y',strtotime($valuesa[0]['adjust_paid_date_allotment'])) : '');
        $arr_trans= $arr_trans_remarks=  $combine_value=[];  
          $arr_trans= explode(",",$valuesa[0]['rejected_vendors']);
          $arr_trans_remarks= explode(",",$valuesa[0]['remarks']);
          $combine_value=array_combine($arr_trans, $arr_trans_remarks);
          if(isset($combine_value[$valuesa[0]['va_transporter_id']])){
            $REMARK=$combine_value[$valuesa[0]['va_transporter_id']];
          }
       else{
        $REMARK='';

       }
         $adjustedFrom=json_decode($valuesa[0]['outstanding_adjustfrom'],true);
            $cont=$comma='';
            $y=0;
            if($adjustedFrom!=""){
              foreach($adjustedFrom as $key => $value) {
              $y++;
              if($y<count($adjustedFrom)){
                $comma=',';
              }
              else{
                $comma='';
              }

              $cont.=$value['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value['id_client']).')'.$comma;
              
            }
          
            }
 
            $adjustedTo=json_decode($valuesa[0]['outstanding_adjustto'],true);
           
            $cont1=$comma1='';
            $u=0;
             if($adjustedTo!=""){
            foreach($adjustedTo as $key1 => $value1) {

              $u++;
              if($u<count($adjustedTo)){
                $comma1=',';
              }
              else{
                $comma1='';
              }

              $cont1.=$value1['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value1['id_client']).')'.$comma1;
              
            }
        }
          
           if($valuesa[0]['trip_went_not']==2){
            $tripDate='Trip Not Went';
        }
        else{
          if($valuesa[0]['his_start_date']!=""&&$valuesa[0]['his_start_date']!="0000-00-00"){
                  $hiss_dateee_staert=$valuesa[0]['his_start_date'];
            }
            else{
                  $hiss_dateee_staert=$valuesa[0]['va_start_date'];

            }
           $tripDate='S:'.date('d/m/Y',strtotime($hiss_dateee_staert)).', E:'.date('d/m/Y',strtotime($valuesa[0]['va_end_date']));

        }
        if($j==0&&$i==0){
          $tripDate=$tripDate;
          $valuesa[0]['purchase_rate_shared']=$valuesa[0]['purchase_rate_shared'];
          $tds_trip=round($tds_trip);
          $valuesa[0]['received_amount']=$valuesa[0]['received_amount'];
          $individual_remaining_label=$individual_remaining;
          $cont=$cont;
          $cont1=$cont1;
          $REMARK=$REMARK;
          $STATUS=$STATUS;
          $payment_date=$payment_date;
          $valuesa[0]['utr_bill_allotment']=preg_replace('/[^A-Za-z0-9\-\(\) ]/', '',$valuesa[0]['utr_bill_allotment']);
        }
        else{
          $tripDate="";
          $valuesa[0]['purchase_rate_shared']="";
          $tds_trip=" ";
          $valuesa[0]['received_amount']="";
          $individual_remaining_label="";
          $cont="";
          $cont1="";
          $REMARK="";
          $STATUS="";
          $payment_date="";
          $valuesa[0]['utr_bill_allotment']="";
        }

        $paymentDate = ($valuesb['payment_date'] !== null && $valuesb['payment_date'] !== '') ? date('d/m/Y', strtotime($valuesb['payment_date'])) : '';
          $ColorCode="";
         if($valuesa[0]['cancel_status']==1){
          $ColorCode="#99FF99";
         }
         else if($valuesa[0]['arrivedornot']==1){
          $ColorCode="#B9C7F1";
         }
          $lineData = array('<style bgcolor="'.$ColorCode.'" >'.$inc.'</style>', 
            '<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['ref_no'].'</style>',
             '<style bgcolor="'.$ColorCode.'"  >'.$valuesa[0]['client_name'].'</style>',
             '<style bgcolor="'.$ColorCode.'"  >'.$valuesa[0]['client_arrival_name'].'</style>',
             '<style bgcolor="'.$ColorCode.'" >'.$tripDate.'</style>',
              '<style bgcolor="'.$ColorCode.'">'.$valuesa[0]['purchase_rate_shared'].'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$tds_trip.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$valuesb['tripadvance_paid'].'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$paymentDate.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$valuesa[0]['received_amount'].'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$individual_remaining_label.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$cont.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$cont1.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$REMARK.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$STATUS.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$payment_date.'</style>',
             '<style bgcolor="'.$ColorCode.'">'.$valuesa[0]['utr_bill_allotment'].'</style>'
           );  
          $excelData[] = $lineData;
          if(is_numeric($tds_trip)){
            $tds = $tds + round($tds_trip);
          }
      
          if(is_numeric($valuesa[0]['received_amount'])){
            $driverAmt=$driverAmt+$valuesa[0]['received_amount']; 

          } 
          if(is_numeric($valuesa[0]['purchase_rate_shared'])){
            $purchase=$purchase+$valuesa[0]['purchase_rate_shared']; 
          }
          $sdfr++;
          $i++;
        }
        
           $j++;
      } 
      
        
          
          
          $trip=$trip+$sum_tripadvance;
          $pay=$pay+$individual_remainingsss;   
   }//list for

}//client(for)
            $excelData[] =array();
            $excelData[] =array();
            $excelData[] =array();
            $excelData[] = array("","","",'Total Bill Amount',$purchase);
            $excelData[] = array("","","",'TDS',$tds);
            $excelData[] = array("","","",'Trip Advance',$trip);
            $excelData[] = array("","","",'Driver Received Amount',$driverAmt);
            $excelData[] = array("","","",$received_label.' Amount',$pay);
           


        $objPHPExcel = PHPExcelGenerate\PhpXlsxGenerator::fromArray($excelData); 
        $objPHPExcel->mergeCells('A1:Q1');
        $objPHPExcel->downloadAs($fileName.".xlsx"); 
  
exit;
?>
