<?php
class OutstandingReportModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function BilldetailsReport($GetDatas){
		$privilege_query=Db::getInstance()->executeS('select a.*,b.*,city.id_city as all_cities from ps_employee as a left join ps_privilege as b on (a.pri_id=b.pri_id and b.status=0) left join ps_city as city on (FIND_IN_SET(city.id_state,a.all_city_in_state)) where a.active=1 and a.id_employee='.$this->context->employee->id.'');

      $city_list=explode(',', $privilege_query[0]['city']);
      foreach ($privilege_query as $keyssss => $valuess) {
        $all_city_list[]=$valuess['all_cities'];
        
      }
      foreach($all_city_list as $key_cityy=>$value_cityy){
      if(!in_array($value_cityy, $city_list)){
      $city_list[]=$value_cityy;
      }
      }
      $privilege_city=implode(',', $city_list);
		
		$permission=$this->tabAccess;
		$url=self::$currentIndex.'&token='.$this->token;
		$emp_id= $this->context->employee->id;
		$where =$autocomplete='';
		if(isset($_POST['from'])&&$_POST['from']!=""&&isset($_POST['to'])&&$_POST['to']!=""){
			$where = 'AND c.start_from>= "'.date("Y-m-d", strtotime($_POST['from'])).'" AND c.start_from <= "'.date("Y-m-d", strtotime($_POST['to'])).'"';
		}
		if(isset($_POST['goingto'])&&$_POST['goingto']!=""){
			$autocomplete = 'AND t.t_id = "'.($_POST['goingto']).'"  and (c.client_arrival IN ('.$privilege_city.') or c.client_departure IN ('.$privilege_city.'))';
		}
		if($privilege_query[0]['vendor']==1){
			$autocomplete = 'AND t.t_id = "'.$privilege_query[0]['trans_vendor_id'].'"';
		}

		if(isset($_POST['type'])&&$_POST['type']==2){
		$outstandinglist=Db::getInstance()->executeS('select v.trip_went_not, cd_h.va_start_date as his_start_date,c.arrivedornot,c.cancel_status,c.client_name,c.start_from,c.end_to,c.ref_no,v.va_start_date,v.va_end_date, v.adjust_amount_allotment,v.purchase_rate_shared,v.outstanding_adjustfrom,dr.driver_received,tr.tripadvanceAmt,t.panno,t.transporter_name  from ps_client c left join ps_vehicle_allotment v on(v.client_table_id=c.id_client) left join ps_transporter t on (t.t_id=v.va_transporter_id) left join (select va_id,sum(received_amount) as driver_received from  ps_driver_receivedamt ) dr  on (v.va_id= dr.va_id)  LEFT JOIN (SELECT ta_va_id, sum(tripadvance_paid) as tripadvanceAmt FROM ps_trip_advance  where paid_status=2 OR individual_paid_status=1 GROUP BY ta_va_id ) tr on (v.va_id= tr.ta_va_id)  left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=v.va_transporter_id and va_h.id_history=v.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 )) where c.status=0 and v.outstanding_adjustfrom!=""  '.$where.' '.$autocomplete.'  ORDER BY t.t_id');

		}
		elseif(isset($_POST['type'])&&$_POST['type']==3){
		$outstandinglist=Db::getInstance()->executeS('select ve.trip_went_not,cd_h.va_start_date as his_start_date,ve.va_start_date,ve.va_end_date, ve.va_id,c.cancel_status,c.arrivedornot,c.id_client, c.ref_no,c.client_name,c.start_from,c.end_to,tr.tripadvance_paid,tr.paid_amount_adjusted,tr.outstanding_adjustfrom,tr.tripadvance_request,tr.request_added_date,t.transporter_name from ps_vehicle_allotment as ve left join ps_client as c on (ve.client_table_id=c.id_client) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id) left join ps_transporter as t on (t.t_id=ve.va_transporter_id ) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  where c.status=0  and tr.outstanding_adjustfrom!=""  '.$autocomplete.'  '.$where.'   order by t.t_id');

	}
	else{
		 $outstandinglist=Db::getInstance()->executeS('SELECT pvc.trip_went_not, cd_h.va_start_date as his_start_date,c.arrivedornot,c.cancel_status,dr.driver_received,pvc.adjust_amount_allotment, pvc.purchase_rate_shared, pvc.va_start_date, pvc.va_end_date, c.start_from, c.end_to, c.ref_no, c.client_name, t.transporter_name,  SUM(pta.tripadvance_paid) As tripadvanceAmt, t.panno FROM ps_client c LEFT JOIN ps_vehicle_allotment pvc ON c.id_client=pvc.client_table_id left join (select va_id,sum(received_amount) as driver_received from  ps_driver_receivedamt ) dr  on (pvc.va_id= dr.va_id) left join ps_transporter t on t.t_id=pvc.va_transporter_id LEFT JOIN ps_trip_advance pta ON pvc.va_id=pta.ta_va_id AND (pta.paid_status=2 OR pta.individual_paid_status=1) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=c.id_client and va_h.va_transporter_id=pvc.va_transporter_id and va_h.id_history=pvc.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  WHERE pvc.adjust_amount_allotment < 0 AND pvc.paid_status_bill_allotment=1 and pvc.outstanding_status=0 and c.status=0  '.$where.' '.$autocomplete.'  GROUP BY pta.ta_va_id  ORDER BY t.t_id');	
	}

$inc=0;$TDS=0;$s='';
		
if(isset($_POST['type'])&&$_POST['type']==3){
	function group_list($array,$key){
      $return =array();
      foreach ($array as $v) {
      $return[$v[$key]][]=$v;
      }
      return $return;

    }
  
    $listArr = group_list($outstandinglist,'ref_no');
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

    $s=''; 
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
            $s.="<tr class='cancel'>";

          }
          else if($valuesa[0]['arrivedornot']==1){
            $s.="<tr class='arrived'>";

          }

          else{
          $s.="<tr>";

          }
   
     
          $s.='<td>'.$si.'</td>';
          if($privilege_query[0]['vendor']==0){
          	$s.='<td>'.$valuesa[0]['transporter_name'].'</td>';
          }
          if($valuesa[0]['trip_went_not']!=2){
        		$hiss_dateee_end=date('d/m/Y',strtotime($valuesa[0]['va_end_date']));

				if($valuesa[0]['his_start_date']!=""&&$valuesa[0]['his_start_date']!="0000-00-00"){
					$hiss_dateee_staert=date('d/m/Y',strtotime($valuesa[0]['his_start_date']));

				}
				else{
					$hiss_dateee_staert=date('d/m/Y',strtotime($valuesa[0]['va_start_date']));

				}
				$content='A:'.$hiss_dateee_staert.'<br>D:'.$hiss_dateee_end.'';

        	}
        	else{
                    $content='Trip Not Went';
        	}
          
          $s.='<td>'.$valuesa[0]['ref_no'].'</td>';
          $s.='<td>'.$valuesa[0]['client_name'].'</td>';
          $s.='<td>A:'.date('d/m/Y',strtotime($valuesa[0]['start_from'])).'<br>D:'.date('d/m/Y',strtotime($valuesa[0]['end_to'])).'</td>';
          $s.='<td>'.$content.'</td>';
        
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
           
          $s.='<tr>';
           if($lll==0){
            
          $s.='<td style="width:25%";>'.(isset($valuesb['tripadvance_request'] )? $valuesb['tripadvance_request'] :'-').'</td>';
 
           }
           else{
             $s.='<td style="width:25%";></td>';
           }
          
            $s.='<td style="width:25%";>'.(isset($valuesb['tripadvance_paid'] )? $valuesb['tripadvance_paid'] :'-').'</td>';
            $s.='<td style="width:25%";>'.(isset($valuesb['paid_amount_adjusted'] )? $valuesb['paid_amount_adjusted'] :'-').'</td>';
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
						$s.='<td style="width:25%";>'.(($cont!="") ? $cont : '-').'</td>';
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
    
      $s.='</tr>';
       
      }

    
    }
    
  }
 echo $s;
die;
}
		else{
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
						$s.="<tr class='cancel'>";

					}
					else if($list['arrivedornot']==1){
						$s.="<tr class='arrived'>";

					}

					else{
						$s.="<tr>";

					}	
				    $s.='<td>'.$inc.'</td>';
				    if($privilege_query[0]['vendor']==0){
					$s.='<td>'.(($list['transporter_name'] !="") ? $list['transporter_name']  : '-').'</td>';
				    }
				      if($list['trip_went_not']!=2){
        		$hiss_dateee_end=date('d/m/Y',strtotime($list['va_end_date']));

				if($list['his_start_date']!=""&&$list['his_start_date']!="0000-00-00"){
					$hiss_dateee_staert=date('d/m/Y',strtotime($list['his_start_date']));

				}
				else{
					$hiss_dateee_staert=date('d/m/Y',strtotime($list['va_start_date']));

				}
				$content='A:'.$hiss_dateee_staert.'<br>D:'.$hiss_dateee_end.'';

        	}
        	else{
                    $content='Trip Not Went';
        	}
					$s.='<td>'.(($list['ref_no']!="") ? $list['ref_no'] : '-').'</td>';
					$s.='<td>'.(($list['client_name']!="") ? $list['client_name'] : '-').'</td>';
					$s.='<td>A:'.(($list['start_from']!="") ?date('d/m/Y',strtotime($list['start_from'])) : '-').'<br>D:'.(($list['end_to']!="") ?date('d/m/Y',strtotime($list['end_to'])) : '-').'</td>';
					 $s.='<td>'.$content.'</td>';
					$s.='<td>'.(($list['purchase_rate_shared']!="") ? $list['purchase_rate_shared'] : '-').'</td>';
					$s.='<td>'.(($list['tripadvanceAmt']!="") ? $list['tripadvanceAmt'] : '-').'</td>';	
					$s.='<td>'.(($list['driver_received']!="") ? $list['driver_received'] : '-').'</td>';					
					$s.='<td>'.round($TDS).'</td>';
					if(isset($_POST['type'])&&$_POST['type']==2){
					$s.='<td>'.($list['purchase_rate_shared']-(round($TDS)+$list['tripadvanceAmt']+$list['driver_received'])).'</td>';
					}
					$s.='<td>'.(($list['adjust_amount_allotment']!="") ? abs($list['adjust_amount_allotment']) : '-').'</td>';
					if(isset($_POST['type'])&&$_POST['type']==2){
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
					}
				    
										
					$s.='</tr>';
				
		}
		echo $s;
		exit;

	}
}


}