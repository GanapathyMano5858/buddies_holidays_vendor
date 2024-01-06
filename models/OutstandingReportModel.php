<?php
class OutstandingReportModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function OutstandingReport($GetDatas){
  $useragent=$_SERVER['HTTP_USER_AGENT'];

  if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
    $mobile='true';
  }
  else{
    $mobile='false';
  }
		$where =$autocomplete='';
		if(isset($GetDatas['min-date'])&&$GetDatas['min-date']!=""&&isset($GetDatas['max-date'])&&$GetDatas['max-date']!=""){
			$where = 'AND c.start_from>= "'.date("Y-m-d", strtotime($GetDatas['min-date'])).'" AND c.start_from <= "'.date("Y-m-d", strtotime($GetDatas['max-date'])).'"';
		}
		
	
			$autocomplete = 'AND t.t_id = "'.$_SESSION['trans_vendor_id'].'"';
	

		if(isset($GetDatas['type'])&&$GetDatas['type']==2){
		$outstandinglist=$this->pdo->prepare('select v.trip_went_not, cd_h.va_start_date as his_start_date,c.arrivedornot,c.cancel_status,c.client_name,c.start_from,c.end_to,c.ref_no,v.va_start_date,v.va_end_date, v.adjust_amount_allotment,v.purchase_rate_shared,v.outstanding_adjustfrom,dr.driver_received,tr.tripadvanceAmt,t.panno,t.transporter_name  from ps_client c left join ps_vehicle_allotment v on(v.client_table_id=c.id_client) left join ps_transporter t on (t.t_id=v.va_transporter_id) left join (select va_id,sum(received_amount) as driver_received from  ps_driver_receivedamt ) dr  on (v.va_id= dr.va_id)  LEFT JOIN (SELECT ta_va_id, sum(tripadvance_paid) as tripadvanceAmt FROM ps_trip_advance  where paid_status=2 OR individual_paid_status=1 GROUP BY ta_va_id ) tr on (v.va_id= tr.ta_va_id)  left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=v.va_transporter_id and va_h.id_history=v.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 )) where c.status=0 and v.outstanding_adjustfrom!=""  '.$where.' '.$autocomplete.'  ORDER BY t.t_id');
		$outstandinglist->execute();
    $outstandinglist=$outstandinglist->fetchAll(PDO::FETCH_ASSOC);

		}
		elseif(isset($GetDatas['type'])&&$GetDatas['type']==3){
		$outstandinglist=$this->pdo->prepare('select ve.trip_went_not,cd_h.va_start_date as his_start_date,ve.va_start_date,ve.va_end_date, ve.va_id,c.cancel_status,c.arrivedornot,c.id_client, c.ref_no,c.client_name,c.start_from,c.end_to,tr.tripadvance_paid,tr.paid_amount_adjusted,tr.outstanding_adjustfrom,tr.tripadvance_request,tr.request_added_date,t.transporter_name from ps_vehicle_allotment as ve left join ps_client as c on (ve.client_table_id=c.id_client) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id) left join ps_transporter as t on (t.t_id=ve.va_transporter_id ) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  where c.status=0  and tr.outstanding_adjustfrom!=""  '.$autocomplete.'  '.$where.'   order by t.t_id');
		$outstandinglist->execute();
    $outstandinglist=$outstandinglist->fetchAll(PDO::FETCH_ASSOC);

	}
	else{
		  $outstandinglist=$this->pdo->prepare('SELECT pvc.trip_went_not, cd_h.va_start_date as his_start_date,c.arrivedornot,c.cancel_status,dr.driver_received,pvc.adjust_amount_allotment, pvc.purchase_rate_shared, pvc.va_start_date, pvc.va_end_date, c.start_from, c.end_to, c.ref_no, c.client_name, t.transporter_name,  SUM(pta.tripadvance_paid) As tripadvanceAmt, t.panno FROM ps_client c LEFT JOIN ps_vehicle_allotment pvc ON c.id_client=pvc.client_table_id left join (select va_id,sum(received_amount) as driver_received from  ps_driver_receivedamt ) dr  on (pvc.va_id= dr.va_id) left join ps_transporter t on t.t_id=pvc.va_transporter_id LEFT JOIN ps_trip_advance pta ON pvc.va_id=pta.ta_va_id AND (pta.paid_status=2 OR pta.individual_paid_status=1) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=pvc.va_transporter_id and va_h.id_history=pvc.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  WHERE pvc.adjust_amount_allotment < 0 AND pvc.paid_status_bill_allotment=1 and pvc.outstanding_status=0 and c.status=0  '.$where.' '.$autocomplete.'  GROUP BY pta.ta_va_id  ORDER BY t.t_id');	
		 $outstandinglist->execute();
     $outstandinglist=$outstandinglist->fetchAll(PDO::FETCH_ASSOC);
	}

$inc=0;$TDS=0;$s='';
		$content="";
if(isset($GetDatas['type'])&&$GetDatas['type']==3){
	function group_list($array,$key){
      $return =array();
      foreach ($array as $v) {
      $return[$v[$key]][]=$v;
      }
      return $return;

    }
  
    $listArr = group_list($outstandinglist,'ref_no');
    $listArra=array();
    $listArraaa=[];

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

     $s ='';
	   $si=''; 
     $mobileCont='';
     $toclosewhile = "";
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
          if($valuesa[0]['cancel_status']==1){
            $mobileCont.= $s.="<tr class='cancel text-center align-items-center align-middle'>";

          }
          else if($valuesa[0]['arrivedornot']==1){
            $mobileCont.= $s.="<tr class='arrived text-center align-items-center align-middle'>";

          }

          else{
          $mobileCont.= $s.="<tr class='text-center align-items-center align-middle'>";

          }
          $mobileCont.='<td>';
   				
     
          $s.='<td>'.$si.'</td>';
        

          if($valuesa[0]['trip_went_not']!=2){
        		$hiss_dateee_end=date('d/m/Y',strtotime($valuesa[0]['va_end_date']));

				if($valuesa[0]['his_start_date']!=""&&$valuesa[0]['his_start_date']!="0000-00-00"){
					$hiss_dateee_staert=date('d/m/Y',strtotime($valuesa[0]['his_start_date']));

				}
				else{
					$hiss_dateee_staert=date('d/m/Y',strtotime($valuesa[0]['va_start_date']));

				}
				$contenta='A:'.$hiss_dateee_staert.'<br>D:'.$hiss_dateee_end.'';

        	}
        	else{
                    $contenta='Trip Not Went';
        	}
          
          $s.='<td>'.$valuesa[0]['ref_no'].'</td>';

          $mobileCont.='<span class="asr">BH Ref No</span> <span class="cllr">'.$valuesa[0]['ref_no'].'</span><br>';

          $s.='<td class="text-nowrap">'.$valuesa[0]['client_name'].'</td>';

          $mobileCont.=' <span class="asr d-flex">Client Name</span> <span class="cllr">'.$valuesa[0]['client_name'].'</span><br>';

          $s.='<td>A:'.date('d/m/Y',strtotime($valuesa[0]['start_from'])).'<br>D:'.date('d/m/Y',strtotime($valuesa[0]['end_to'])).'</td>';

          $mobileCont.=' <span class="asr">Travel Date</span> <span class="cllr">A:'.date('d/m/Y',strtotime($valuesa[0]['start_from'])).'<br>D:'.date('d/m/Y',strtotime($valuesa[0]['end_to'])).'</span><br>';

          $s.='<td>'.$contenta.'</td>';
            $mobileCont.=' <span class="asr">Trip Date</span> <span class="cllr">'.$contenta.'</span><br>';
        
          $s.='<td><table  class="table" style="margin-bottom:0 !important;">';
        
      }
      $sdfr++;
       //main loop key>Vehicle Allotemnt id
        
        if($j==0)
        {
         
          $s.='<tr>';
      
          $s.='<td><table  class="table" style="width:100%;margin-bottom:0 !important;">';
        }  
          $lll=0;
        foreach($valuesa as $keyb=>$valuesb)
        {  
           
          $s.='<tr >';
           if($lll==0){
            
          $s.='<td>'.(isset($valuesb['tripadvance_request'] )? $valuesb['tripadvance_request'] :'-').'</td>';
          $mobileCont.='<span class="asr">Trip Advance Request</span> <span class="cllr">'.(isset($valuesb['tripadvance_request'] )? $valuesb['tripadvance_request'] :"-").'</span><br>';
 
           }
           else{
             $s.='<td></td>';
           }
          
            $s.='<td>'.(isset($valuesb['tripadvance_paid'] )? $valuesb['tripadvance_paid'] :'-').'</td>';
            $mobileCont.=' <span class="asr">Payable Amount</span> <span class="cllr">'.(isset($valuesb['tripadvance_paid'] )? $valuesb['tripadvance_paid'] :'-').'</span><br>';
            $s.='<td>'.(isset($valuesb['paid_amount_adjusted'] )? $valuesb['paid_amount_adjusted'] :'-').'</td>';
            $mobileCont.=' <span class="asr">Paid Amount</span> <span class="cllr">'.(isset($valuesb['paid_amount_adjusted'] )? $valuesb['paid_amount_adjusted'] :'-').'</span><br>';
           	$adjustedFrom=json_decode($valuesb['outstanding_adjustfrom'],true);
						$cont=$comma='';
						$i=0;
						foreach ($adjustedFrom as $key => $value) {
							$i++;
							if($i<count($adjustedFrom)){
								$comma=',';
							}
							else{
								$comma='';
							}

							$cont.=$value['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value['id_client']).')'.$comma;
							
						}
						$s.='<td>'.(($cont!="") ? $cont : '-').'</td>';
						$mobileCont.=' <span class="asr">Adjusted From</span> <span class="cllr">'.(($cont!="") ? $cont : '-').'</span><br>';
		          $j++;
		          $lll++;
		          $s.='</tr>';   
        }
     
		     if($toclosevaidloop==$j)
		       {
		        $s.='</table>';
		        $s.='</td></tr>';
		      }
		      

		      if(($toclosewhile==$transportercount)&&($toclosevaidloop==$j))
		      {
		      
		        $s.='</table>';
		        $s.='</td>'; 
		        $s.='</tr>';
		      
		      }
    $mobileCont.='</td>';
      $mobileCont.=$s.='</tr>';
       
      }

    
    }
    
  }
	$content= $s;
	
}
		else{
			$mobileCont='';
				foreach($outstandinglist as $list){
					$inc++;
					$pan_4th_char=substr($list['panno'], 3, 1);
					
					if($pan_4th_char=='p'||$pan_4th_char=='P'){
				  	$TDS=$list['purchase_rate_shared'] * 0.01;
				    }
					else{
					$TDS=$list['purchase_rate_shared'] * 0.02;
			      	}
					if($list['cancel_status']==1){
					$mobileCont.=	$s.="<tr class='cancel text-center align-items-center align-middle'>";

					}
					else if($list['arrivedornot']==1){
					$mobileCont.=	$s.="<tr class='arrived text-center align-items-center align-middle' style='padding:15px 20px;'>";

					}

					else{
						$mobileCont.= $s.='<tr class="text-center align-items-center align-middle">';

					}	
					$mobileCont.='<td>';

				    $s.='<td>'.$inc.'</td>';
			
				      if($list['trip_went_not']!=2){
        		$hiss_dateee_end=date('d/m/Y',strtotime($list['va_end_date']));

				if($list['his_start_date']!=""&&$list['his_start_date']!="0000-00-00"){
					$hiss_dateee_staert=date('d/m/Y',strtotime($list['his_start_date']));

				}
				else{
					$hiss_dateee_staert=date('d/m/Y',strtotime($list['va_start_date']));

				}
				$contenta='A:'.$hiss_dateee_staert.'<br>D:'.$hiss_dateee_end.'';

        	}
        	else{
                $contenta='Trip Not Went';
        	}
					$s.='<td>'.(($list['ref_no']!="") ? $list['ref_no'] : '-').'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 0 5px 0;"> <span class="asr">BH Ref No</span> <span class="cllr"><b>'.(($list['ref_no']!="") ? $list['ref_no'] : '-').'</b></span></div>';
					$s.='<td class="text-nowrap">'.(($list['client_name']!="") ? $list['client_name'] : '-').'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 0 5px 0;"> <span class="asr">Client Name</span> <span class="cllr"><b>'.(($list['client_name']!="") ? $list['client_name'] : '-').'</b></span></div>';
					$s.='<td>A:'.(($list['start_from']!="") ?date('d/m/Y',strtotime($list['start_from'])) : '-').'<br>D:'.(($list['end_to']!="") ?date('d/m/Y',strtotime($list['end_to'])) : '-').'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 0 5px 0;">  <span class="asr">Travel Date</span> <span class="cllr">A:'.(($list['start_from']!="") ?date('d/m/Y',strtotime($list['start_from'])) : '-').'<br>D:'.(($list['end_to']!="") ?date('d/m/Y',strtotime($list['end_to'])) : '-').'</span></div>';
					 $s.='<td>'.$contenta.'</td>';
					 $mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">Trip Date</span> <span class="cllr">'.(($contenta!="") ? $contenta : '-').'</span></div>';
					$s.='<td>'.(($list['purchase_rate_shared']!="") ? $list['purchase_rate_shared'] : '-').'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">Purchase Amount</span> <span class="cllr">'.(($list['purchase_rate_shared']!="") ? $list['purchase_rate_shared'] : '-').'</span></div>';
					$s.='<td>'.(($list['tripadvanceAmt']!="") ? $list['tripadvanceAmt'] : '-').'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">Trip Advance</span> <span class="cllr">'.(($list['tripadvanceAmt']!="") ? $list['tripadvanceAmt'] : '-').'</span></div>';	
					$s.='<td>'.(($list['driver_received']!="") ? $list['driver_received'] : '-').'</td>';	
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">Driver Received Amount</span> <span class="cllr">'.(($list['driver_received']!="") ? $list['driver_received'] : '-').'</span></div>';				
					$s.='<td>'.round($TDS).'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">TDS</span> <span class="cllr">'.((round($TDS)!="") ? round($TDS) : '-').'</span></div>';
					if(isset($GetDatas['type'])&&$GetDatas['type']==2){
					$s.='<td>'.($list['purchase_rate_shared']-(round($TDS)+$list['tripadvanceAmt']+$list['driver_received'])).'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">Payable Amount</span> <span class="cllr">'.($list['purchase_rate_shared']-(round($TDS)+$list['tripadvanceAmt']+$list['driver_received'])).'</span></div>';
					}
					$s.='<td>'.(($list['adjust_amount_allotment']!="") ? abs($list['adjust_amount_allotment']) : '-').'</td>';
					$mobileCont.='<div style="display: flex; justify-content: space-between; align-items:center; margin: 0 0 5px 0;">  <span class="asr">Paid Amount</span> <span class="cllr">'.(($list['adjust_amount_allotment']!="") ? abs($list['adjust_amount_allotment']) : '-').'</span></div>';
					if(isset($GetDatas['type'])&&$GetDatas['type']==2){
						$adjustedFrom=json_decode($list['outstanding_adjustfrom'],true);
						$cont=$comma='';
						$i=0;
						foreach ($adjustedFrom as $key => $value) {
							$i++;
							if($i<count($adjustedFrom)){
								$comma=',';
							}
							else{
								$comma='';
							}

							$cont.=$value['adjust_amount_allotment'].' ('."BHCI". sprintf('%06s',$value['id_client']).')'.$comma;
							
						}
						$s.='<td>'.(($cont!="") ? $cont : '-').'</td>';
						$mobileCont.=' <span class="asr">Adjusted From</span> <span class="cllr">'.(($cont!="") ? $cont : '-').'</span><br>';
					}

				    
					$mobileCont.='</td></tr>';
					$s.='</tr>';
				
		}
		$content= $s;
		

	}
	 return [
	 	        "no_of_records"=>$toclosewhile,
            "mobile" => $mobile,
            "content" =>($mobile=='true'? $mobileCont : $content),
            "searchFrom" => isset($GetDatas["min-date"])
                ? $GetDatas["min-date"]
                : "",
            "searchTo" => isset($GetDatas["max-date"])
                ? $GetDatas["max-date"]
                : "",
            "searchType" => isset($GetDatas["type"]) ? $GetDatas["type"] : "",
        ];
}


}