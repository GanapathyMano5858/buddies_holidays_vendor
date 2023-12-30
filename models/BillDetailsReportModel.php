<?php
class BillDetailsReportModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function BilldetailsReport($GetDatas){
	   $useragent=$_SERVER['HTTP_USER_AGENT'];

  if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
    $mobile='true';
  }
  else{
    $mobile='false';
  }
  $where=1;
  $fromStr=$toStr = $orderby = '';
if(isset($GetDatas["min-date"])&&$GetDatas["min-date"] != ""&&isset($GetDatas["max-date"])&&$GetDatas["max-date"] != "")  {
      $fromStr =str_replace("/","-",$GetDatas['min-date']);
      $toStr =str_replace("/","-",$GetDatas['max-date']);
  }
       
	$vendor='ve.va_transporter_id='.$_SESSION['trans_vendor_id'].'';
       
    if(isset($GetDatas['min-date'])&&$GetDatas['min-date']!=""&&isset($GetDatas['max-date'])&&$GetDatas['max-date']!=""&&isset($GetDatas['type'])&&$GetDatas['type']==1)
		  { 
		   $where='b.end_to BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" ';
       $orderby='order by b.end_to asc';
			}
	
		else if(isset($GetDatas['min-date'])&&$GetDatas['min-date']!=""&&isset($GetDatas['max-date'])&&$GetDatas['max-date']!=""&&isset($GetDatas['type'])&&$GetDatas['type']==3)
	     	{
			 $where='ve.adjust_paid_date_allotment BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and ve.paid_status_bill_allotment=1';
        $orderby='order by ve.adjust_paid_date_allotment desc';
			}
      else if(isset($GetDatas['min-date'])&&$GetDatas['min-date']!=""&&isset($GetDatas['max-date'])&&$GetDatas['max-date']!=""&&isset($GetDatas['type'])&&$GetDatas['type']==2)
        {
       $where='b.end_to BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%" or(ve.purchase_rate_approval_status=0 and ve.purchaserate_added_date!="0000-00-00 00:00:00") or (ve.purchase_rate_approval_status=1 and ve.approval_status_adjust=0) or (ve.approval_status_adjust=1 and ve.paid_status_bill_allotment=0))';
        $orderby='order by b.end_to desc';
      }
       else if(isset($GetDatas['type'])&&$GetDatas['type']==2)
        {
        $where='b.cancel_status=0 and b.arrivedornot=0 and b.end_to<CURDATE() and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%" or(ve.purchase_rate_approval_status=0 and ve.purchaserate_added_date!="0000-00-00 00:00:00") or (ve.purchase_rate_approval_status=1 and ve.approval_status_adjust=0) or (ve.approval_status_adjust=1 and ve.paid_status_bill_allotment=0))';
        $orderby='order by b.end_to asc';
        }
        // else if((isset($GetDatas['type'])&&$GetDatas['type']==3)||$paiddd==1)
        // {
           
        // $where='ve.adjust_paid_date_allotment BETWEEN  "'.date('Y-m-d',strtotime("-1 week")).'" AND "'.date('Y-m-d').'" and ve.paid_status_bill_allotment=1';
        //      $orderby='order by ve.adjust_paid_date_allotment desc';
        // }
	
			else{
             
	     $where='b.cancel_status=0 and b.arrivedornot=0 and b.end_to<CURDATE() and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%" or(ve.purchase_rate_approval_status=0 and ve.purchaserate_added_date!="0000-00-00 00:00:00") or (ve.purchase_rate_approval_status=1 and ve.approval_status_adjust=0) or (ve.approval_status_adjust=1 and ve.paid_status_bill_allotment=0))';
        $orderby='order by b.end_to asc';
		      }
			
      
	$ClientList = $this->pdo->prepare('select ve.purchaserateVerified, cd_h.va_start_date as his_start_date,Amt.received_amount,ve.remark_adjust_allotment,ve.adjust_amount_allotment,ve.utr_bill_allotment,ve.adjust_paid_date_allotment,ve.paid_status_bill_allotment,e.panno ,a.company_name,date(ve.purchase_rate_approval_date) as purchase_approved_date,ve.approval_status_adjust,ve.va_start_date,ve.trip_went_not,ve.va_end_date,ve.purchase_rate_approval_status,ve.add_purchse_rate_remark,ve.add_purchase_rate_cal, ve.purchaserate_added_date,ve.va_transporter_id,ve.purchase_rate_shared,ve.va_id,b.reason_cancel,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.tripadvance_paid,tr.payment_date, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve left join ps_client as b on (ve.client_table_id=b.id_client) left join ps_driver_receivedamt as Amt on (Amt.va_id=ve.va_id) left join ps_agent as a on(a.id_agent=b.agent_id) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id and (tr.paid_status=2 ||tr.individual_paid_status=1)) left join ps_transporter as e on (e.t_id=ve.va_transporter_id ) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=b.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 ))  where '.$where.' and '.$vendor.'  and b.status=0  and b.transporter_id!="" and ve.va_driver_id!=0 and ve.va_vehicle_id!=0 and  ve.va_transporter_id!=64  and ve.purchaserate_added_date!="0000-00-00 00:00:00" '.$orderby);

    $ClientList->execute();
    $ClientList=$ClientList->fetchAll(PDO::FETCH_ASSOC);

        function group_list($array,$key){
      $return =array();
      foreach ($array as $v) {
      $return[$v[$key]][]=$v;
      }
      return $return;

    }
   

    $listArr = group_list($ClientList,'ref_no');
    $listArra=array();

   foreach($listArr as $key1=>$value1)
   {
     $listArra[$key1] = group_list($value1,'va_id');
   }
    $si=0;
    $s=''; 
    //main loop key>client reference
    foreach($listArra as $keys => $list){ 
      
      $si++;
      $sdfr=$count=$total_remaining_amt=$purchase_total=0;
      $toclosewhile=count($list);
     
     
      foreach($list as $keya=>$valuesa)
      { $j=$individual_remaining=$sum_tripadvance=$tds_trip= 0;
       $toclosevaidloop=count($valuesa);
       
        if($sdfr==0)
        { 

          if($valuesa[0]['cancel_status']==1){
          $s.="<tr class='cancel align-middle'>";

          }
          else if($valuesa[0]['arrivedornot']==1){
          $s.="<tr class='arrived align-middle'>";

          }

          else{
          $s.="<tr class='align-middle'>";

          }
 
          if($mobile=='true'){
          $vv=0;        
        foreach($list as $kwyyy=>$valiee)
         { 
         $vv++; 

            $sum_tripadvance_mobile=0;
            foreach($valiee as $keyb=>$valuesb)
           {
          
            $sum_tripadvance_mobile=$sum_tripadvance_mobile+$valuesb['tripadvance_paid'];
           }
          $individual_remaining_mobile=$tds_trip_mobile=0;
          //$pan_4th_char_mobile=substr($valiee[0]['panno'], 3, 1);
        // if($pan_4th_char_mobile=='p'||$pan_4th_char_mobile=='P')
        // {
        
        $tds_trip_mobile=$valiee[0]['purchase_rate_shared']*0.01;

        //}
        // else{
        // $tds_trip_mobile=$valiee[0]['purchase_rate_shared']*0.02;
        // }
        $individual_remaining_mobile=$valiee[0]['purchase_rate_shared']-($sum_tripadvance_mobile+round($tds_trip_mobile)+$valiee[0]['received_amount']);
 

                 if($valiee[0]['paid_status_bill_allotment']==1){
              $individual_remaining_mobile=$valiee[0]['adjust_amount_allotment'];
           }
           if($individual_remaining_mobile<=0){
            $individual_remaining_mobile=0;
           }
        if($valiee[0]['purchaserate_added_date']=="0000-00-00 00:00:00")
        {

        $status_mobile="Not Submitted";
        }
        elseif($valiee[0]['purchase_rate_approval_status']==0 and $valiee[0]['purchaserate_added_date']!="0000-00-00 00:00:00" and $valiee[0]['purchaserateVerified']==0){
        $status_mobile="Awaiting for verify";
        }
        elseif($valiee[0]['purchase_rate_approval_status']==0 and $valiee[0]['purchaserate_added_date']!="0000-00-00 00:00:00" and $valiee[0]['purchaserateVerified']==1){
        $status_mobile="Awaiting for approval";
        }
        elseif($valiee[0]['purchase_rate_approval_status']==1 and $valiee[0]['approval_status_adjust']==0){
        $status_mobile="Awaiting for payment";
        }
        elseif($valiee[0]['approval_status_adjust']==1 and $valiee[0]['paid_status_bill_allotment']==0){
        $status_mobile="Awaiting for payment";
        }
         elseif($valiee[0]['approval_status_adjust']==1 and $valiee[0]['paid_status_bill_allotment']==1){
        $status_mobile="PAID";
        }
        if($vv==1){
          $s.='<td style="width: 10% !important"><span class="asr">BH Ref No</span> <span class="cllr">'.$valiee[0]['ref_no'].'</span><br>';
             if($GetDatas['type']==1||$GetDatas['type']==2){
               
                  if($valiee[0]['trip_went_not']!=2){
                      if($valiee[0]['his_start_date']!=""&&$valiee[0]['his_start_date']!="0000-00-00"){
                         $hiss_dateee_staert=$valiee[0]['his_start_date'];
                      }
                      else{
                         $hiss_dateee_staert=$valiee[0]['va_start_date'];

                      }

                   $s.='<span class="asr">Travel Date</span><span class="cllr">A:'.date('d/m/Y',strtotime($hiss_dateee_staert)).'</span><br><span class="cllr">D:'.date('d/m/Y',strtotime($valiee[0]['va_end_date'])).'</span><br>';
                  }
                  else{
                       $s.='<span class="asr">Travel Date</span><span class="cllr">Trip not went</span> <br>';
                  }
              
              
              
             }
             else{
                $s.='<span class="asr">Date</span> <span class="cllr">'.(($valiee[0]['paid_status_bill_allotment']==1) ? date('d/m/Y',strtotime($valiee[0]['adjust_paid_date_allotment'])): '-').'</span><br>';
             }
           }
             
                $s.='<span class="asr">Amount</span> <span class="cllr">'.$individual_remaining_mobile.'</span><br>';
               if($GetDatas['type']==1||$GetDatas['type']==2){

                $s.='<span class="asr">Status</span> <span class="cllr">'.$status_mobile.'</span><br>';
              }
              
                $s.='<span class="asr">View</span> <span class="cllr"><a class="customedit" href="javascript:void(0)" title="View" onclick="javascript:return showClientDetails('.$valiee[0]['id_client'].','.$valiee[0]['va_transporter_id'].');">

               <button class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="fa-solid fa-eye"></i></button>
              </a></span><br>';
              

             } //  foreach close
              $s.='</td>';

              

          }

          else{
          $s.='<td style="width: 3% !important">'.$si.'</td>';
          $s.='<td style="width: 7% !important" >'.$valuesa[0]['ref_no'].'</td>';
          $s.='<td class="text-nowrap" style="width: 7% !important">'.$valuesa[0]['client_name'].'</td>';
          $s.="<td style='width: 7% !important'>".$valuesa[0]['client_arrival_name']."</td>";
        
          $s.='<td><table style="margin-bottom:0 !important; width: 100% !important"; >';
        }
      }
       $sdfr++;
       //main loop key>Vehicle Allotemnt id
        if($mobile=='false'){
        if($j==0)
        {
         $total=0;
          $s.='<tr class="align-middle">';
         
           if($valuesa[0]['trip_went_not']==2){
          $s.='<td style="width: 10% !important;">Trip Not Went</td>';
        }
        else{
          if($valuesa[0]['his_start_date']!=""&&$valuesa[0]['his_start_date']!="0000-00-00"){
                  $hiss_dateee_staert=$valuesa[0]['his_start_date'];
            }
            else{
                  $hiss_dateee_staert=$valuesa[0]['va_start_date'];

            }
          $s.='<td style="width: 10% !important;">S:'.date('d/m/Y',strtotime($hiss_dateee_staert)).'<br>E:'.date('d/m/Y',strtotime($valuesa[0]['va_end_date'])).'</td>';
        }
                //   $pan_4th_char=substr($valuesa[0]['panno'], 3, 1);
                //   if($pan_4th_char=='p'||$pan_4th_char=='P')
                //   {
                  $tds_trip=$valuesa[0]['purchase_rate_shared']*0.01;

                 // }
                //   else{
                //   $tds_trip=$valuesa[0]['purchase_rate_shared']*0.02;
                //   }
                   
        $s.="<td style='width: 7% !important' class='purchaserate_shared".$valuesa[0]['id_client'].$valuesa[0]['va_id']."'>".$valuesa[0]['purchase_rate_shared']."</td>";
         $s.="<td style='width: 5% !important'>".round($tds_trip)."</td>";

          $s.='<td style="width: 10% !important" ><table style="margin-bottom:0 !important; width:100% !important">';
           
        }
       

        foreach($valuesa as $keyb=>$valuesb)
        {
          
          $s.='<tr class="align-middle">';
          $s .= "<td class='show_query'>" . ((isset($valuesb['tripadvance_paid']) && $valuesb['tripadvance_paid']) ? $valuesb['tripadvance_paid'] : '-') . (isset($valuesb['tripadvance_paid']) ? "<div class='show_me'>" . date('d/m/Y', strtotime($valuesb['payment_date'])) . "</div>" : "") . "</td>";

          $s.="</td>";
          $s.='</tr>';
          $j++;
          $sum_tripadvance=$sum_tripadvance+$valuesb['tripadvance_paid'];
        }
   $individual_remaining=$valuesa[0]['purchase_rate_shared']-($sum_tripadvance+round($tds_trip)+$valuesa[0]['received_amount']);
       if($toclosevaidloop==$j)
       {

        $s.='</table>';
        $s.='</td>';
                 
                     
                if($valuesa[0]['paid_status_bill_allotment']==1){
           	  $individual_remaining=$valuesa[0]['adjust_amount_allotment'];
           }
          //  if($individual_remaining<0) {
          //  $individual_remaining=0;
          // }   
                      

           $s.="<td style='width:5% !important;text-align: center !important;'>".(isset($valuesa[0]['received_amount'] )? $valuesa[0]['received_amount'] :'-')."</td>";
         $s.="<td style='width: 7% !important' class='individual_remaining".$valuesa[0]['id_client'].$valuesa[0]['va_id']."'>".$individual_remaining."</td>";
          
         if($individual_remaining>0){
          $total_remaining_amt=$total_remaining_amt+$individual_remaining;
          
         }
  
         $purchase_total=$purchase_total+$valuesa[0]['purchase_rate_shared'];


          $arr_trans= $arr_trans_remarks=  $combine_value=[];  
          $arr_trans= explode(",",$valuesa[0]['rejected_vendors']);
          $arr_trans_remarks= explode(",",$valuesa[0]['remarks']);
          if (count($arr_trans) === count($arr_trans_remarks)) {
          $combine_value=array_combine($arr_trans, $arr_trans_remarks);
        }
				if(isset($combine_value[$valuesa[0]['va_transporter_id']])){
				$s.="<td style='width: 6% !important'><div class='show_query'><p> Remark<div class='show_me'>".$combine_value[$valuesa[0]['va_transporter_id']]."</div></p></div></td>";

				}
				else{
				$s.="<td style='width: 6% !important'>-</td>";

				}
        if($valuesa[0]['paid_status_bill_allotment']==1){
               
            $s.="<td style='width: 8% !important' ><div class='show_query'><span class='label label-warning fl' style='color:#108510;font-weight: bold;background:transparent;'>PAID<div class='show_me'>UTR No:".$valuesa[0]['utr_bill_allotment']."</p><p>Payment Date:".date('d/m/Y',strtotime($valuesa[0]['adjust_paid_date_allotment']))."</div></span></div></td>";
           

          }
           
          else if($valuesa[0]['paid_status_bill_allotment']==0){
            if($valuesa[0]['purchaserate_added_date']=="0000-00-00 00:00:00")
              {
             
            $s.="<td style='width: 8% !important'><span class='label color_field' style='color:red;font-weight: bold;'>Not Submitted</span></td>";
              }
                 elseif($valuesa[0]['purchase_rate_approval_status']==0 and $valuesa[0]['purchaserate_added_date']!="0000-00-00 00:00:00" and $valuesa[0]['purchaserateVerified']==0){
            $s.="<td style='width: 8% !important'><span class='label color_field' style='color:red;font-weight: bold;white-space: normal;'>Awaiting for verify</span></td>";
         }
         elseif($valuesa[0]['purchase_rate_approval_status']==0 and $valuesa[0]['purchaserate_added_date']!="0000-00-00 00:00:00" and $valuesa[0]['purchaserateVerified']==1){
            $s.="<td style='width: 8% !important'><span class='label color_field' style='color:red;font-weight: bold;white-space: normal;'>Awaiting for approval</span></td>";
         }
         elseif($valuesa[0]['purchase_rate_approval_status']==1 and $valuesa[0]['approval_status_adjust']==0){
            $s.="<td style='width: 8% !important'><span class='label color_field' style='color:red;font-weight: bold;white-space: normal;'>Awaiting for payment</span></td>";
         }
         elseif($valuesa[0]['approval_status_adjust']==1 and $valuesa[0]['paid_status_bill_allotment']==0){
            $s.="<td style='width: 8% !important'><span class='label color_field' style='color:red;font-weight: bold;'>Awaiting for payment</span></td>";
         }
            
        }
     
         
         $s.='</tr>';
           $s.="<script>$('.adjust_amount_update".$valuesa[0]['id_client']."').html(".$total_remaining_amt.")</script>";
             $s.="<script>$('.purchaserateupdate".$valuesa[0]['id_client']."').html(".$purchase_total.")</script>";
         $count++;
       }
          
      }
        if($toclosewhile==$sdfr)
        {

    if($mobile=='false'){
          $s.='</table>';
          $s.='</td>';
        }
          $s.='</tr>';
        }

      
      }
    
    }
     return [
            "mobile" => $mobile,
            "content" =>$s,
            "searchFrom" => isset($GetDatas["min-date"])
                ? $GetDatas["min-date"]
                : "",
            "searchTo" => isset($GetDatas["max-date"])
                ? $GetDatas["max-date"]
                : "",
            "searchType" => isset($GetDatas["type"]) ? $GetDatas["type"] : "",
        ];
   
	}
	public function ShowClientBill($GetDatas)
   {   
    $id_client=$GetDatas['id_client'];
    $trans_id=$GetDatas['trans_id'];
      if($trans_id!=""&&$trans_id!=0){
      $transporter='and ve.va_transporter_id="'.$trans_id.'"';
      
    }
    else{
      $transporter='';
    
    }

    $clientARR = $this->pdo->prepare('select cd_h.va_start_date as his_start_date, Amt.received_amount,ve.remark_adjust_allotment,ve.adjust_amount_allotment,ve.utr_bill_allotment,ve.adjust_paid_date_allotment,ve.paid_status_bill_allotment,e.panno ,a.company_name,date(ve.purchase_rate_approval_date) as purchase_approved_date,ve.approval_status_adjust,ve.va_start_date,ve.trip_went_not,ve.va_end_date,ve.purchase_rate_approval_status,ve.add_purchse_rate_remark,ve.add_purchase_rate_cal, ve.purchaserate_added_date,ve.va_transporter_id,ve.purchase_rate_shared,ve.va_id,b.reason_cancel,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.tripadvance_paid,tr.payment_date, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve left join ps_client as b on (ve.client_table_id=b.id_client) left join ps_driver_receivedamt as Amt on (Amt.va_id=ve.va_id) left join ps_agent as a on(a.id_agent=b.agent_id) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id and (tr.paid_status=2 ||tr.individual_paid_status=1)) left join ps_transporter as e on (e.t_id=ve.va_transporter_id )  left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=b.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 )) where  b.id_client="'.$id_client.'" and b.status=0 and ve.va_driver_id!=0 and ve.va_vehicle_id!=0 '.$transporter.' ');

      $clientARR->execute();
      $clientARR=$clientARR->fetchAll(PDO::FETCH_ASSOC);


     $tripAdvace_paid='';
     $sum_tripadvance=$k=0;
     $trip_strart_date=$trip_end_date='';
      $vaidd= $clientARR[0]['va_id'];

     foreach ($clientARR as $keys => $values) {
           if($values['tripadvance_paid']!=0){
          $tripAdvace_paid.='Amount : Rs.'.(isset($values['tripadvance_paid'] )? $values['tripadvance_paid'] :'-').', Date : '.date('d/m/Y',strtotime($values['payment_date']));
          $sum_tripadvance=$sum_tripadvance+$values['tripadvance_paid'];
          }
       
     $k++;
      }
       if($values['trip_went_not']!=2){
        if($values['his_start_date']!=""&&$values['his_start_date']!="0000-00-00"){
                  $hiss_dateee_staert=$values['his_start_date'];
            }
            else{
                  $hiss_dateee_staert=$values['va_start_date'];

            }
                  $trip_strart_date.='S:'.date('d/m/Y',strtotime($hiss_dateee_staert)).'<br>';
                  $trip_end_date.='E:'.date('d/m/Y',strtotime($values['va_end_date'])).'<br>';
                  }
                  else{

                  $trip_strart_date.='Trip Not Went<br>';
                  }
       
       $individual_remaining=$tds_trip=0;
    //   $pan_4th_char=substr($clientARR[0]['panno'], 3, 1);
    //     if($pan_4th_char=='p'||$pan_4th_char=='P')
    //     {
        $tds_trip=$clientARR[0]['purchase_rate_shared']*0.01;

        // }
        // else{
        // $tds_trip=$clientARR[0]['purchase_rate_shared']*0.02;
        // }
        $individual_remaining=$clientARR[0]['purchase_rate_shared']-($sum_tripadvance+round($tds_trip)+$clientARR[0]['received_amount']);
 

                 if($clientARR[0]['paid_status_bill_allotment']==1){
              $individual_remaining=$clientARR[0]['adjust_amount_allotment'];
           }
           if($individual_remaining<0) {
           $individual_remaining=0;
          }   
        
            if($clientARR[0]['purchase_rate_approval_status']==1){
             // $clientARR[0]['remark_adjust_allotment']
            $approved_status="APPROVED";

          }
          else if($clientARR[0]['purchase_rate_approval_status']==0 and $clientARR[0]['purchaserate_added_date']!="0000-00-00 00:00:00"){
            $approved_status="PENDING";

          }
          
        else {
           $approved_status="-";

        }
       if($clientARR[0]['paid_status_bill_allotment']==1){
               
            $status="PAID    UTR No:".$clientARR[0]['utr_bill_allotment']."<br>Payment Date:".date('d/m/Y',strtotime($clientARR[0]['adjust_paid_date_allotment']));
           

          }
           
          else if($clientARR[0]['paid_status_bill_allotment']==0){
            if($clientARR[0]['purchaserate_added_date']=="0000-00-00 00:00:00")
              {
             
            $status="Not Submitted";
              }
         elseif($clientARR[0]['purchase_rate_approval_status']==0 and $clientARR[0]['purchaserate_added_date']!="0000-00-00 00:00:00"){
            $status="Awaiting for approval";
         }
         elseif($clientARR[0]['purchase_rate_approval_status']==1 and $clientARR[0]['approval_status_adjust']==0){
            $status="Awaiting for payment";
         }
         elseif($clientARR[0]['approval_status_adjust']==1 and $clientARR[0]['paid_status_bill_allotment']==0){
            $status="Awaiting for payment";
         }
            
        }
          $arr_trans= $arr_trans_remarks=  $combine_value=[];  
          $arr_trans= explode(",",$clientARR[0]['rejected_vendors']);
          $arr_trans_remarks= explode(",",$clientARR[0]['remarks']);
          $combine_value=array_combine($arr_trans, $arr_trans_remarks);
        if(isset($combine_value[$clientARR[0]['va_transporter_id']])){
        $vendorRemark=$combine_value[$clientARR[0]['va_transporter_id']];

        }
        else{
       $vendorRemark="-";

        }
        $clientList=$clientARR[0];
        $tds_trip=round($tds_trip);
        $content=' <div class="container-fluid border p-3 rounded">
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">BH Ref No :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$clientList["ref_no"].'
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Client Name :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$clientList["client_name"].'
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Arrival :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$clientList["client_arrival_name"].'
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Departure :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$clientList["client_departure_name"].'
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Trip Date :</div>
                            <div class="col-md-6 text-secondary text-end">
                            '.$trip_strart_date.'<br />'.$trip_end_date.'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Bill Amount :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$clientList["purchase_rate_shared"].'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">TDS :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$tds_trip.'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Trip Advance :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$tripAdvace_paid.'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Driver Received Amount :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$clientList["received_amount"].'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Remaining Individual Payable Amount :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$individual_remaining.'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Vehicle Remark :</div>
                            <div class="col-md-6 text-secondary text-end">
                              '.$vendorRemark.'
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Status  :</div>
                            <div class="col-md-6 text-danger-emphasis text-end">
                              '.$status.'
                            </div>
                          </div>
                        </div>';
    
       echo $content;
    exit;
  

  }

}