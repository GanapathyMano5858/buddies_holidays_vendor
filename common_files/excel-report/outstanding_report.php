<?php

include(dirname(dirname(dirname(__FILE__)))).'/config.php';
$con = mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_,_DB_NAME_) or die("Error " . mysqli_error($con));
  $i = 2; $k=$si=0;
		 $result_array=[];
		 $fromStr =str_replace("/","-",$_GET['from']);
	     $toStr =str_replace("/","-",$_GET['to']);
		 $type=$_GET['type'];
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPExcel/PhpXlsxGenerator.php';
		$fileName = 'Outstanding Report';
	
   $excelData[] = array('<center><b><style font-size="25">'.$fileName.'</style></b></center>');
    	if($type==3){
       $excelData[] = array('<b><style bgcolor="#E97451" color="#000000">S No</style></b>',
        '<b><style bgcolor="#E97451" color="#000000">BH Ref ID</style></b>',
         '<b><style bgcolor="#E97451" color="#000000">Client Name</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Travel Start Date</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Travel End Date</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Trip Start Date</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Trip End Date</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Trip Advance Request</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Payable Amount</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Paid Amount</style></b>',
          '<b><style bgcolor="#E97451" color="#000000">Adjuste From</style></b>'
        );
       $Var='K';
    	}else{
    		
					if($type==2){
						$excelData[] = array('<b><style bgcolor="#E97451" color="#000000">S No</style></b>', 
							'<b><style bgcolor="#E97451" color="#000000">BH Ref ID</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Client Name</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Travel Start Date</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Travel End Date</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Trip Start Date</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Trip End Date</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Purchase Amount</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Trip Advance</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Driver Received </style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Amount</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">TDS</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Payable Amount</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Paid Amount</style></b>',
							 '<b><style bgcolor="#E97451" color="#000000">Adjusted From</style></b>'
							);
						 $Var='N';
					}
					else{
						$excelData[] = array('<b><style bgcolor="#E97451" color="#000000">S No</style></b>',
						 '<b><style bgcolor="#E97451" color="#000000">BH Ref ID</style></b>',
						  '<b><style bgcolor="#E97451" color="#000000">Client Name</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Travel Start Date</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Travel End Date</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Trip Start Date</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Trip End Date</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Purchase Amount</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Trip Advance</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Driver Received Amount</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">TDS</style></b>',
						   '<b><style bgcolor="#E97451" color="#000000">Outstanding Amount</style></b>'
						 );
						 $Var='L';
					}
						
    	}

   
	$where =$autocomplete='';
		if(isset($_GET['from'])&&$_GET['from']!=""&&isset($_GET['to'])&&$_GET['to']!=""){
			$where = 'AND c.start_from>= "'.date("Y-m-d", strtotime($_GET['from'])).'" AND c.start_from <= "'.date("Y-m-d", strtotime($_GET['to'])).'"';
		}
	
			$autocomplete = 'AND t.t_id = "'.$_SESSION['trans_vendor_id'].'"';
	

		if(isset($_GET['type'])&&$_GET['type']==2){
		$outstandinglist='select v.trip_went_not, cd_h.va_start_date as his_start_date,c.arrivedornot,c.cancel_status ,c.client_name,c.start_from,c.end_to,c.ref_no,v.va_start_date,v.va_end_date, v.adjust_amount_allotment,v.purchase_rate_shared,v.outstanding_adjustfrom,dr.driver_received,tr.tripadvanceAmt,t.panno,t.transporter_name  from ps_client c left join ps_vehicle_allotment v on(v.client_table_id=c.id_client) left join ps_transporter t on (t.t_id=v.va_transporter_id) left join (select va_id,sum(received_amount) as driver_received from  ps_driver_receivedamt ) dr  on (v.va_id= dr.va_id)  LEFT JOIN (SELECT ta_va_id, sum(tripadvance_paid) as tripadvanceAmt FROM ps_trip_advance  where paid_status=2 OR individual_paid_status=1 GROUP BY ta_va_id ) tr on (v.va_id= tr.ta_va_id) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=v.va_transporter_id and va_h.id_history=v.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  where c.status=0 and v.outstanding_adjustfrom!=""  '.$where.' '.$autocomplete.'  ORDER BY t.t_id';

	}
		elseif(isset($_GET['type'])&&$_GET['type']==3){
		$outstandinglist='select ve.trip_went_not, cd_h.va_start_date as his_start_date,ve.va_start_date,ve.va_end_date, ve.va_id,c.cancel_status,c.arrivedornot,c.id_client, c.ref_no,c.client_name,c.start_from,c.end_to,tr.tripadvance_paid,tr.paid_amount_adjusted,tr.outstanding_adjustfrom,tr.tripadvance_request,tr.request_added_date,t.transporter_name from ps_vehicle_allotment as ve left join ps_client as c on (ve.client_table_id=c.id_client) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id) left join ps_transporter as t on (t.t_id=ve.va_transporter_id ) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  where c.status=0  and tr.outstanding_adjustfrom!=""  '.$autocomplete.'  '.$where.'  order by t.t_id';
	}
	else{
		 $outstandinglist='SELECT pvc.trip_went_not, cd_h.va_start_date as his_start_date,c.arrivedornot,c.cancel_status,dr.driver_received,pvc.adjust_amount_allotment, pvc.purchase_rate_shared, pvc.va_start_date, pvc.va_end_date, c.start_from, c.end_to, c.ref_no, c.client_name, t.transporter_name,  SUM(pta.tripadvance_paid) As tripadvanceAmt, t.panno FROM ps_client c LEFT JOIN ps_vehicle_allotment pvc ON c.id_client=pvc.client_table_id left join (select va_id,sum(received_amount) as driver_received from  ps_driver_receivedamt ) dr  on (pvc.va_id= dr.va_id) left join ps_transporter t on t.t_id=pvc.va_transporter_id LEFT JOIN ps_trip_advance pta ON pvc.va_id=pta.ta_va_id AND (pta.paid_status=2 OR pta.individual_paid_status=1) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=pvc.va_transporter_id and va_h.id_history=pvc.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 )) WHERE pvc.adjust_amount_allotment < 0 AND pvc.paid_status_bill_allotment=1 and pvc.outstanding_status=0 and c.status=0  '.$where.' '.$autocomplete.'  GROUP BY pta.ta_va_id  ORDER BY t.t_id';	
	}

        
       	$select= mysqli_query($con,$outstandinglist);
	    while($row=mysqli_fetch_assoc($select))
	    {
	    $result_array[]=$row;
	    }

	    $inc=0;$TDS=0;
		
if(isset($_GET['type'])&&$_GET['type']==3){
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
      $si++;
      $sdfr=0;
      $transportercount=0;
        $toclosewhile=count($list);
     
       
      
      foreach($list as $keyddda=>$valuesaaaa)
      {
        $toclosevaidloop=explode('_',$keyddda)[1];
         $transportercount++;

    //print_r($toclosevaidloop.'countloop');
        $j=0;
      
      foreach($valuesaaaa as $keya=>$valuesa)
      {  


        if($sdfr==0)
        { 
        	if($valuesa[0]['trip_went_not']!=2){
        		$hiss_dateee_end=date('d/m/Y',strtotime($valuesa[0]['va_end_date']));

				if($valuesa[0]['his_start_date']!=""&&$valuesa[0]['his_start_date']!="0000-00-00"){
					$hiss_dateee_staert=date('d/m/Y',strtotime($valuesa[0]['his_start_date']));

				}
				else{
					$hiss_dateee_staert=date('d/m/Y',strtotime($valuesa[0]['va_start_date']));

				}

        	}
        	else{
             $hiss_dateee_end=$hiss_dateee_staert='Trip Not Went';
        	}

					$incc=$si;
					$valuesa[0]['ref_no']=$valuesa[0]['ref_no'];
					$valuesa[0]['client_name']=$valuesa[0]['client_name'];
					$startDate=date('d/m/Y',strtotime($valuesa[0]['start_from']));
					$endDate=date('d/m/Y',strtotime($valuesa[0]['end_to']));
					$hiss_dateee_s=$hiss_dateee_s;
					$hiss_dateee_end=$hiss_dateee_end;			
        
      }
      else{

					$incc='';
					$valuesa[0]['ref_no']="";
					$valuesa[0]['client_name']="";
					$startDate="";
					$endDate="";
					$hiss_dateee_s="";
					$hiss_dateee_end="";
      }
      $sdfr++;
       //main loop key>Vehicle Allotemnt id
        
         
          $lll=0;
        foreach($valuesa as $keyb=>$valuesb)
        {  
           if($lll==0){
           	$tripAdvance_req=(isset($valuesb['tripadvance_request'] )? $valuesb['tripadvance_request'] :'-');
            
           }
           else{
							$tripAdvance_req="";
           }
           	$adjustedFrom=json_decode($valuesb['outstanding_adjustfrom'],true);
						$cont=$comma='';
						$q=0;
						foreach ($adjustedFrom as $key => $value) {
							$q++;
							if($q<count($adjustedFrom)){
								$comma=',';
							}
							else{
								$comma='';
							}

							$cont.=$value['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value['id_client']).')'.$comma;
							
						}
						 $ColorCode="";
					if($valuesa[0]['cancel_status']==1){
								$ColorCode="#99FF99";
						}
						else if($valuesa[0]['arrivedornot']==1){
								$ColorCode="#B9C7F1";
						}
				$lineData = array('<style bgcolor="'.$ColorCode.'" >'.$incc.'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['ref_no'].'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$valuesa[0]['client_name'].'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$startDate.'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$endDate.'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$hiss_dateee_s.'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$hiss_dateee_end.'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.$tripAdvance_req.'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.(isset($valuesb['tripadvance_paid'] )? $valuesb['tripadvance_paid'] :'-').'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.(isset($valuesb['paid_amount_adjusted'] )? $valuesb['paid_amount_adjusted'] :'-').'</style>',
					'<style bgcolor="'.$ColorCode.'" >'.(($cont!="") ? $cont : '-').'</style>'
				);
				$excelData[] = $lineData;
	
		          $j++;
		          $lll++;
		          $i++;
		   
		 
        }

      	 		
				
       
      }

    
    }
    
  }

}
		else{
				foreach($result_array as $list){
					$inc++;
					$pan_4th_char=substr($list['panno'], 3, 1);
					
					if($pan_4th_char=='p'||$pan_4th_char=='P'){
				  	$TDS=$list['purchase_rate_shared'] * 0.01;
				    }
					else{
					$TDS=$list['purchase_rate_shared'] * 0.02;
			      	}
					if($list['trip_went_not']!=2){
						$hiss_dateee_end=date('d/m/Y',strtotime($list['va_end_date']));

					if($list['his_start_date']!=""&&$list['his_start_date']!="0000-00-00"){
						$hiss_dateee_staert=date('d/m/Y',strtotime($list['his_start_date']));

					}
					else{
						$hiss_dateee_staert=date('d/m/Y',strtotime($list['va_start_date']));

					}

					}
					else{
						$hiss_dateee_end=$hiss_dateee_staert='Trip Not Went';
					}
			     

					if(isset($_GET['type'])&&$_GET['type']==2){
							$adjustedFrom=json_decode($list['outstanding_adjustfrom'],true);
						$cont=$comma='';
						$q=0;
						foreach ($adjustedFrom as $key => $value) {
							$q++;
							if($q<count($adjustedFrom)){
								$comma=',';
							}
							else{
								$comma='';
							}

							$cont.=$value['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value['id_client']).')'.$comma;
							
						}
							 $ColorCode="";
					if($list['cancel_status']==1){
								$ColorCode="#99FF99";
						}
						else if($list['arrivedornot']==1){
								$ColorCode="#B9C7F1";
						}
			$lineData =array('<style bgcolor="'.$ColorCode.'" >'.$inc.'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.$list['ref_no'].'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.$list['client_name'].'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.date('d/m/Y',strtotime($list['start_from'])).'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.date('d/m/Y',strtotime($list['end_to'])).'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.$hiss_dateee_staert.'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.$hiss_dateee_end.'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.(($list['purchase_rate_shared']!="") ? $list['purchase_rate_shared'] : '-').'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.(($list['tripadvanceAmt']!="") ? $list['tripadvanceAmt'] : '-').'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.(($list['driver_received']!="") ? $list['driver_received'] : '-').'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.round($TDS).'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.($list['purchase_rate_shared']-(round($TDS)+$list['tripadvanceAmt']+$list['driver_received'])).'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.(($list['adjust_amount_allotment']!="") ? abs($list['adjust_amount_allotment']) : '-').'</style>',
				'<style bgcolor="'.$ColorCode.'" >'.(($cont!="") ? $cont : '-').'</style>'
			);
								}
					else{
						$lineData =array(
							'<style bgcolor="'.$ColorCode.'" >'.$inc.'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.$list['ref_no'].'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.$list['client_name'].'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.date('d/m/Y',strtotime($list['start_from'])).'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.date('d/m/Y',strtotime($list['end_to'])).'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.$hiss_dateee_staert.'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.$hiss_dateee_end.'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.(($list['purchase_rate_shared']!="") ? $list['purchase_rate_shared'] : '-').'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.(($list['tripadvanceAmt']!="") ? $list['tripadvanceAmt'] : '-').'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.(($list['driver_received']!="") ? $list['driver_received'] : '-').'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.round($TDS).'</style>',
							'<style bgcolor="'.$ColorCode.'" >'.(($list['adjust_amount_allotment']!="") ? abs($list['adjust_amount_allotment']) : '-').'</style>'
						);
						
					}
					 $excelData[] = $lineData;

				
			$i++;	
				
		}
		

	}
	
	$objPHPExcel = PHPExcelGenerate\PhpXlsxGenerator::fromArray($excelData);
	$objPHPExcel->mergeCells('A1:'.$Var.'1');
	$objPHPExcel->downloadAs($fileName.".xlsx"); 
	exit;
?>
