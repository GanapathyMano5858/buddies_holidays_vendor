<?php
class TripAdvanceReportModel{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo=$pdo;
	}
	public function TripadvanceReport($GetDatas){
		    $permission=$this->tabAccess;
    $url=self::$currentIndex.'&token='.$this->token;
    $where=1;
    $fromStr=$toStr  = '';
     $useragent=$_SERVER['HTTP_USER_AGENT'];
     if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
    $mobile='true';
  }
  else{
    $mobile='false';
  }
      
    //print_r($_POST['type']);die;
       $fromStr =str_replace("/","-",$_POST['from']);
       $toStr =str_replace("/","-",$_POST['to']);
        $privilege=Db::getInstance()->executeS('select a.*,b.*,city.id_city as all_cities from ps_employee as a left join ps_privilege as b on (a.pri_id=b.pri_id and b.status=0) left join ps_city as city on (FIND_IN_SET(city.id_state,a.all_city_in_state)) where a.active=1 and a.id_employee='.$this->context->employee->id.'');
  
      $city_list=explode(',', $privilege[0]['city']);
      foreach ($privilege as $keyssss => $valuess) {
        $all_city_list[]=$valuess['all_cities'];
        
      }
      foreach($all_city_list as $key_cityy=>$value_cityy){
      if(!in_array($value_cityy, $city_list)){
      $city_list[]=$value_cityy;
      }
      }
      $privilege_city=implode(',', $city_list);
       if($privilege[0]['vendor']==1){
        $vendor='ve.va_transporter_id='.$privilege[0]['trans_vendor_id'].'';
       }
       else{
        $vendor='(FIND_IN_SET(b.client_arrival ,"'.$privilege_city.'") || FIND_IN_SET(b.client_departure,"'.$privilege_city.'"))';
   

       }
       $oderby='';
      if(isset($_POST['from'])&&$_POST['from']!=""&&isset($_POST['to'])&&$_POST['to']!=""&&isset($_POST['type'])&&$_POST['type']==1)
        {

        $where='tr.payment_date BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and tr.ta_va_id!="" and tr.approval_status=2 ';
        $oderby='b.start_from asc ,ve.va_id asc';
        }
        else if(isset($_POST['from'])&&$_POST['from']!=""&&isset($_POST['to'])&&$_POST['to']!=""&&isset($_POST['type'])&&$_POST['type']==2)
        {
        $where='tr.paid_status=1 and tr.approval_status=2';
        $oderby='b.start_from asc ,ve.va_id asc';

        }
         else if(isset($_POST['type'])&&$_POST['type']==2)
        {
        $where='tr.paid_status=1 and tr.approval_status=2';
        $oderby='b.start_from asc ,ve.va_id asc';

        }
        else if(isset($_POST['from'])&&$_POST['from']!=""&&isset($_POST['to'])&&$_POST['to']!=""&&isset($_POST['type'])&&$_POST['type']==3)
        {
        $where='tr.payment_date BETWEEN  "'.date('Y-m-d',strtotime($fromStr)).'" AND "'.date('Y-m-d',strtotime($toStr)).'" and (tr.paid_status=2 or (tr.paid_status=1 and tr.individual_paid_status=1))';
        $oderby='tr.payment_date asc,ve.va_id asc';
        }

        else{
        $where='tr.approval_status=2 and (tr.paid_status=2 or (tr.paid_status=1 and tr.individual_paid_status=1)) and tr.payment_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND tr.payment_date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY';
        $oderby='tr.payment_date asc,ve.va_id asc';
        }


      $ClientList=Db::getInstance()->executeS('select ve.va_transporter_id, ve.va_id,b.details,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.*, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve left join ps_client as b on (ve.client_table_id=b.id_client) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id) left join ps_transporter as e on (e.t_id=ve.va_transporter_id )  where '.$where.' and b.status=0  and b.transporter_id!="" and '.$vendor.'   order by '. $oderby.'');


    

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
    foreach($listArra as $key2=>$value2)
     {

       foreach($value2 as $key3=>$value3)
       {
        $count=count($value3);
         $listArraaa[$key2][$key3.'_'.$count] = group_list($value3,'request_added_date');
       }

     }
   
// 
//  print_r($listArraaa); echo '<pre>';
// die;
    
    
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
          $arr_trans= $arr_trans_remarks=  $combine_value=[];  
          $arr_trans= explode(",",$valuesa[0]['rejected_vendors']);
          $arr_trans_remarks= explode(",",$valuesa[0]['remarks']);
          $combine_value=array_combine($arr_trans, $arr_trans_remarks);
        
          if($valuesa[0]['cancel_status']==1){
            $s.="<tr class='cancel'>";

          }
          else if($valuesa[0]['arrivedornot']==1){
            $s.="<tr class='arrived'>";

          }

          else{
          $s.="<tr>";

          }
            if($privilege[0]['vendor']==1&&$mobile=='true'){
          $s.='<td style="width: 3% !important" class="sortid">'.$si.'</td>';
          $s.='<td style="width: 7% !important"><span class="asr">BH Ref No</span> <span class="cllr">'.$valuesa[0]['ref_no'].'</span><br>';
           foreach($valuesa as $keydsfb=>$valuesbb)
               {  
                 
                 $s.='<span class="asr">Pyament Date</span> <span class="cllr">'.((($valuesbb['paid_status']==1&&$valuesbb['individual_paid_status']==1)||$valuesbb['paid_status']==2) ? date('d/m/Y',strtotime($valuesbb['payment_date'])): '-').'</span>';
                  $s.='<br><span class="asr">Amount</span> <span class="cllr">'.(isset($valuesbb['tripadvance_paid'] )? $valuesbb['tripadvance_paid'] :'-').'</span><br>';
                }
               $s.="<br><span class='asr'>View</span>
               <span class='cllr'><a class='customedit' href='javascript:void(0)' title='View' onclick='javascript:return showClientDetails(".$valuesa[0]['id_client'].",".$privilege[0]['trans_vendor_id'].");'>
                <i class='icon-eye'></i>
              </a></span><br>";

          }
          else{
          $s.='<td>'.$si.'</td>';
          $s.='<td>'.$valuesa[0]['ref_no'].'</td>';
          $s.='<td>'.$valuesa[0]['client_name'].'</td>';
          $s.='<td>A:'.date('d/m/Y',strtotime($valuesa[0]['start_from'])).'<br>D:'.date('d/m/Y',strtotime($valuesa[0]['end_to'])).'</td>';
          $s.='<td>'.$valuesa[0]['client_arrival_name'].'</td>';
          $s.='<td>'.$valuesa[0]['client_departure_name'].'</td>';
            if((($valuesa[0]['details'])&&$valuesa[0]['details']!=""&&$privilege[0]['vendor']==1&&$valuesa[0]['start_from']<=date("Y-m-d", strtotime("+1 days")))||($valuesa[0]['details']!=""&&$privilege[0]['vendor']==0)){
             $s.="<td><button  type='button' class='dialogs' data-toggle='modal' onclick='Itinerary_modal(".$valuesa[0]['id_client'].",1);' ><img src='../img/details.png' height='20' width='20' ></button></td>";
         }
         else{
          $s.= "<td>-</td>";

         }
          $s.='<td><table style="width:100%">';
        }
      }
      $sdfr++;
       //main loop key>Vehicle Allotemnt id
        if(($privilege[0]['vendor']==1&&$mobile=='false')||$privilege[0]['vendor']==0){
        if($j==0)
        {
         
          $s.='<tr>';
           if($privilege[0]['vendor']==0){
           $countStr=14;
           $inc='';
           $transss_name=ucfirst(strtolower($valuesa[0]['transporter_name']));
            $trans_length=strlen($valuesa[0]['transporter_name']);
            if($trans_length>$countStr){
                  $wrap_trans=$c=0;    
              do{
                $wrap_trans+=$countStr;
                $firstCharacter = substr($transss_name, $c, $wrap_trans);
                
                  $c+=$countStr;
                  
                  $inc.=$firstCharacter.'<br>';
              }while(strlen($firstCharacter)>0);
              
            }
            else{

              $inc=$transss_name;
              for($i=$countStr-$trans_length;$i>0;$i--){

                $inc.='&nbsp';
              }
            }
          $s.='<td class="wordwrapCol">'.$inc.'</td>';
          if($valuesa[0]['trans_vendors']==1)
          {
            $s.='<td>Vendor&nbsp;&nbsp;&nbsp;</td>';
          }else {
            $s.='<td>Transporter</td>';
          }
          }
          $s.='<td><table style="width:100%">';
        }
     
           
          $lll=0;
         
         //$toclosewhile=count($valuesa);
         
    // print_r($toclosewhile.'count');

        foreach($valuesa as $keyb=>$valuesb)
        {  
           
          $s.='<tr>';
           if($lll==0){
            
          $s.='<td style="width:13% !important;text-align:center;">'.(isset($valuesb['tripadvance_request'] )? $valuesb['tripadvance_request'] :'-').'</td>';
 
           }
           else{
             $s.='<td></td>';
           }
          
           $s.='<td style="width:13% !important;text-align:center;">'.(isset($valuesb['tripadvance_paid'] )? $valuesb['tripadvance_paid'] :'-').'</td>';
           //$s.="<td style='text-align:center';><div class='show_query' >".(isset($valuesb['paid_amount'] )? $valuesb['paid_amount'] :'-')."<div class='show_me'>".(isset($valuesb['payment_details'] )? $valuesb['payment_details'] :'-')."</div></div></td>";

         // approval status
                if($lll==0){
             if(($valuesb['approval_status'])==1){
                  $s.="<td style='width:13% !important;text-align:center;' class='pends'>PENDING</td>";
                  }
                  else if(($valuesb['approval_status'])==2){
                  $s.="<td style='width:13% !important;text-align:center;' class='paids'>APPROVED</td>";

                  }
                  else if(($valuesb['approval_status'])==3)
                  {
                  $s.="<td style='width:13% !important;text-align:center;' class='pends'>CANCELLED</td>";

                  }
                  else{
                  $s.="<td style='width:13% !important;text-align:center;'>-</td>";

                  }
                }
                else{
                    $s.='<td></td>';
                }
            // paid status
               if(($valuesb['paid_status'])==1&&$valuesb['individual_paid_status']==1){
               $s.="<td style='width:13% !important;text-align:center;'><div class='show_query' ><p class='pends'>Partially Paid<div class='show_me'>UTR No:".$valuesb['utr']."</p><p>Payment Date:".date('d/m/Y',strtotime($valuesb['payment_date']))."</p></div></div> </td>";



                }

                elseif(($valuesb['paid_status'])==1){
                $s.="<td style='width:13% !important;text-align:center;' class='pends'>PENDING</td>";


                }
                else if(($valuesb['paid_status'])==2){
                $s.="<td style='width:13% !important;text-align:center;'><div class='show_query' ><p class='paids'>PAID<div class='show_me'>UTR No:".$valuesb['utr']."</p><p>Payment Date:".date('d/m/Y',strtotime($valuesb['payment_date']))."</p></div></div> </td>";

                }
                else if(($valuesb['paid_status'])==3)
                {
                $s.="<td style='width:13% !important;text-align:center;' class='unpaids'>UNPAID</td>";

                }
                else{
                $s.="<td style='width:13% !important;text-align:center;'>-</td>";

                }
                 $s.="<td style='width:13% !important;text-align:center;'>".((isset($valuesb['payment_date'])&&$valuesb['payment_date']!='0000-00-00')? date('d/m/Y',strtotime($valuesb['payment_date'])): '-')."</td>";
          $s.="<td style='width:13% !important;text-align:center;'>".(($valuesb['remark']) ? $valuesb['remark'] : '-')."</td>";
          //Vehicle Remark
          //isset($arr_trans_remarks[$keya])&&
          if($j==0){
              if(isset($combine_value[$valuesb['transporter_table_id']])&&$valuesb['transporter_table_id']!=""){
              $s.="<td style='width:13% !important;'><div class='show_query'><p>Remark<div class='show_me'>".$combine_value[$valuesb['transporter_table_id']]."</div></p></div></td>";

              }
            
              else{
              $s.="<td style='width:13% !important;text-align:center;'>-</td>";

              } 
            }
            else{
               $s.="<td style='width:13% !important; text-align:center;'></td>";
            }
            
      

          $j++;
          $lll++;
       $s.='</tr>';
          
        }
       // $s.=$toclosewhile.'===='.$transportercount.'lll'.$toclosevaidloop.'===='.$j;
     if($toclosevaidloop==$j)
       {
        $s.='</table>';
        $s.='</td></tr>';
      }
      // print_r($toclosevaidloop.'llllllll');
      // print_r($sdfr.'fgfg'); 
      // print_r($lll.'ssjhkhj'); 
        
        //if($toclosewhile==$lll)

      if(($toclosewhile==$transportercount)&&($toclosevaidloop==$j))
      {
      
        $s.='</table>';
        $s.='</td>';
      
        $s.='</tr>';
      
      }
    
      $s.='</tr>';
       
      
      }//close else condition
}
    
    }
    
  }
echo $s;
die;
  
		
	}
	public function ShowClientTrip($GetDatas){

      
    
$permission=$this->tabAccess;
    $emp_id= $this->context->employee->id ;
    $id_client=(int)Tools::getValue('id_client');
    $trans_id=(int)Tools::getValue('trans_id');

    $clientARR = Db::getInstance()->executeS('select ve.va_start_date,ve.va_end_date,ve.va_transporter_id, ve.va_id,b.details,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.*, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve left join ps_client as b on (ve.client_table_id=b.id_client) left join  ps_trip_advance as tr on(ve.va_id =tr.ta_va_id) left join ps_transporter as e on (e.t_id=ve.va_transporter_id )  where ve.va_transporter_id='.$trans_id.' and b.id_client="'.$id_client.'" and b.status=0');
    // echo '<pre>';
    // print_r($clientARR);
    // echo '</pre>';
    // die;
     $tripAdvace_paid=[];
     $k=0;
     $trip_strart_date=$trip_end_date='';
      $vaidd= $clientARR[0]['va_id'];

     foreach ($clientARR as $keys => $values) {
           
            $tripAdvace_paid[$keys]['paid']=(isset($values['tripadvance_paid'] )? $values['tripadvance_paid'] :0);
            $tripAdvace_paid[$keys]['request']=(isset($values['tripadvance_request'] )? $values['tripadvance_request'] :0);
            $tripAdvace_paid[$keys]['paid_date']=date('d/m/Y',strtotime($values['payment_date']));
            $tripAdvace_paid[$keys]['utr']=$values['utr'];
            if($values['approval_status']==2){
            // $clientARR[0]['remark_adjust_allotment']
            $approved_status="APPROVED";

            }
            else if($values['approval_status']==1){
            $approved_status="PENDING";

            }
                else if($values['approval_status']==3){
            $approved_status="CANCELLED";

            }

            else {
            $approved_status="-";

            }

              if(($values['paid_status'])==1&&$values['individual_paid_status']==1){
                $paid_status="Partially Paid";


                }

                elseif(($values['paid_status'])==1){
                $paid_status="PENDING";


                }
                else if(($values['paid_status'])==2){
                $paid_status="PAID";

                }
                else if(($values['paid_status'])==3)
                {
                $paid_status="UNPAID";

                }
                else{
                $paid_status="-";

                }
            $tripAdvace_paid[$keys]['id_tripadvance']=$values['id_tripadvance'];
            $tripAdvace_paid[$keys]['approval_status_int']=$values['approval_status'];
            $tripAdvace_paid[$keys]['approval_status']=$approved_status;
            $tripAdvace_paid[$keys]['paid_status']=$paid_status;
            $tripAdvace_paid[$keys]['remark']=$values['remark'];
         
         
           if($values['va_id']==$vaidd&&$k==0){
                  if($values['trip_went_not']!=2){
                  $trip_strart_date.='S:'.date('d/m/Y',strtotime($values['va_start_date'])).'<br>';
                  $trip_end_date.='E:'.date('d/m/Y',strtotime($values['va_end_date'])).'<br>';
                  }
                  else{

                  $trip_strart_date.='Trip Not Went<br>';
                  }
          }
          elseif($values['va_id']!=$vaidd){
                 if($values['trip_went_not']!=2){
                  $trip_strart_date.='S:'.date('d/m/Y',strtotime($values['va_start_date'])).'<br>';
                  $trip_end_date.='E:'.date('d/m/Y',strtotime($values['va_end_date'])).'<br>';
                  }
                  else{

                  $trip_strart_date.='Trip Not Went<br>';
                  }

          }
     $k++;
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
     
    $this->context->smarty->assign(array(
    'clientList'=>  $clientARR[0],
    'tripAdvace_paid'=>$tripAdvace_paid,
    'vendorRemark'=>$vendorRemark,
    'trip_strart_date'=>$trip_strart_date,
    'trip_end_date'=>$trip_end_date,
    'privileges'=>Db::getInstance()->executeS('select * from ps_employee as a left join ps_privilege as b on a.pri_id=b.pri_id where a.active=1 and a.id_employee='.$this->context->employee->id.''),
    'loginId'=>$this->context->employee->id,
    'url_post' => self::$currentIndex.'&token='.$this->token,
    ));

       echo $this->createTemplate('viewclient.tpl')->fetch();
    exit;
	}
}
