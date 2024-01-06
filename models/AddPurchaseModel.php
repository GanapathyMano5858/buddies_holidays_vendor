<?php
class AddPurchaseModel
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }
  public function addPurchaseBill($GetDatas)
  {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
      $mobileViewType = '1';
    } else {
      $mobileViewType = 'false';
    }
    $where = 1;
    $category = '';
    $fromStr = $toStr = $FilterTransporter = '';

    if (isset($GetDatas['min-date']) && $GetDatas['min-date'] != "" && isset($GetDatas['max-date']) && $GetDatas['max-date'] != "") {
      $fromStr = str_replace("/", "-", $GetDatas['min-date']);
      $toStr = str_replace("/", "-", $GetDatas['max-date']);
    }


    $canceled = 'and b.cancel_status!=1';
    $vendorOrTrans = 'e.t_id=' . $_SESSION['trans_vendor_id'];


    if (isset($GetDatas['min-date']) && $GetDatas['min-date'] != "" && isset($GetDatas['max-date']) && $GetDatas['max-date'] != "" && isset($GetDatas['type']) && $GetDatas['type'] == 3) {
      $where = 'b.end_to BETWEEN  "' . date('Y-m-d', strtotime($fromStr)) . '" AND "' . date('Y-m-d', strtotime($toStr)) . '" and ve.purchaserate_added_date!="0000-00-00 00:00:00"';
      $order = 'order by b.start_from asc';
    } elseif (isset($GetDatas['min-date']) && $GetDatas['min-date'] == "" && isset($GetDatas['max-date']) && $GetDatas['max-date'] == "" && isset($GetDatas['type']) && $GetDatas['type'] == 3) {
      $where = 'b.end_to > DATE_SUB(now(), INTERVAL 6 MONTH) and ve.purchaserate_added_date!="0000-00-00 00:00:00"';
      $order = 'order by b.start_from asc';
    } elseif (isset($GetDatas['min-date']) && $GetDatas['min-date'] != "" && isset($GetDatas['max-date']) && $GetDatas['max-date'] != "" && isset($GetDatas['type']) && $GetDatas['type'] == 5) {
      $where = 'b.end_to BETWEEN  "' . date('Y-m-d', strtotime($fromStr)) . '" AND "' . date('Y-m-d', strtotime($toStr)) . '" and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%"||(ve.status=1 and ve.purchaserate_added_date!="0000-00-00 00:00:00"))';
      $order = 'order by b.start_from asc';
    } else {
      $GetDatas['type'] = 5;
      $where = 'b.end_to<CURDATE() and (ve.purchaserate_added_date LIKE "%0000-00-00 00:00:00%"||(ve.status=1 and ve.purchaserate_added_date!="0000-00-00 00:00:00"))';
      $order = 'order by b.start_from asc';
    }

    $ClientList = $this->pdo->prepare('select cd_h.va_start_date as his_start_date,ve.status,ve.rejected_remark,ve.rejected_remark_approval,ve.purchaserateVerified,ve.bill_images,ve.feedback_images,  vtype.vehicle_type_name,ps_vehicles.vehicle_no,a.company_name,ve.remarks as vehicle_remark,ve.va_start_date,ve.trip_went_not,ve.va_end_date,ve.purchase_rate_approval_status,ve.add_purchse_rate_remark,ve.add_purchase_rate_cal, ve.purchaserate_added_date,ve.va_transporter_id,ve.total_km,ve.purchase_rate_shared,ve.va_id,b.special_note,b.cancel_status,b.arrivedornot,b.id_client, b.ref_no,b.client_name,b.start_from,b.end_to,b.client_arrival_name,b.client_departure_name,b.transporter_id as curt_transporter_id,b.confirmedprice, b.rejected_vendors,b.remarks,tr.tripadvance_paid,tr.payment_date, e.t_id,e.reference_no,e.trans_vendors,e.transporter_name,e.dest_name,e.bank_access_id ,e.trans_type  from ps_vehicle_allotment as ve  left join ps_vehicles  on (ve.va_vehicle_id=ps_vehicles.v_id) left join  ps_vehicletypes as vtype on (vtype.vt_id=ps_vehicles.vehicle_type) left join ps_client as b on (ve.client_table_id=b.id_client ' . $FilterTransporter . ') left join ps_agent as a on(a.id_agent=b.agent_id) left join  ps_trip_advance as tr on(b.id_client =tr.client_id and ve.va_id =tr.ta_va_id  and (tr.paid_status=2 ||tr.individual_paid_status=1)) left join ps_vehicle_allotment_history as cd_h on(cd_h.va_id_history=(select va_h.va_id_history from ps_vehicle_allotment_history as va_h where va_h.client_table_id=b.id_client and va_h.va_transporter_id=ve.va_transporter_id and va_h.id_history=ve.va_id and va_h.va_driver_id!=0 and va_h.va_vehicle_id!=0 and va_h.trip_went_not!=2 order by va_h.va_id_history asc limit 1 )) left join ps_transporter as e on (e.t_id=ve.va_transporter_id ' . $category . ')  where ' . $where . ' and ' . $vendorOrTrans . ' and b.status=0  and b.transporter_id!="" and (ve.trip_went_not!=2 || tr.tripadvance_paid!=0) and ve.va_driver_id!=0 and ve.va_vehicle_id!=0 ' . $canceled . ' ' . $order);

    $ClientList->execute();
    $ClientList = $ClientList->fetchAll(PDO::FETCH_ASSOC);

    function group_list($array, $key)
    {
      $return = array();
      foreach ($array as $v) {
        $return[$v[$key]][] = $v;
      }
      return $return;
    }

    $listArr = group_list($ClientList, 'ref_no');
    $listArra = array();

    foreach ($listArr as $key1 => $value1) {

      $listArra[$key1] = group_list($value1, 'va_id');
    }
    $typp = 0;
    $minDate = $maxDate = '';
    if (isset($GetDatas['type']) && $GetDatas['type'] != "") {
      $typp = $GetDatas['type'];
    }
    if (isset($GetDatas['min-date']) && $GetDatas['min-date'] != "") {
      $minDate = $GetDatas['min-date'];
    }
    if (isset($GetDatas['max-date']) && $GetDatas['max-date'] != "") {
      $maxDate = $GetDatas['max-date'];
    }
    if ($mobileViewType == '1') {

      $content = $this->prepareGridApproval($listArra, $typp, $minDate, $maxDate);
    } else {
      $content = $this->prepareTableApproval($listArra, $typp, $minDate, $maxDate);
    }
    return $content;
  }

  public function prepareTableApproval($listArra, $type, $minDate, $maxDate)
  {
    $s = '';

    //main loop key>client reference
    $si = 0;
    foreach ($listArra as $keys => $list) {
      $purchase_total = 0;
      $si++;
      $sdfr = 0;
      $toclosewhile = count($list);

      foreach ($list as $keya => $valuesa) {

        $j = 0;
        $toclosevaidloop = count($valuesa);

        if ($sdfr == 0) {

          $Combined_image_val = [];
          if ($valuesa[0]['bill_images']) {
            $Combined_image_val = array_merge(json_decode($valuesa[0]['bill_images'], true), json_decode($valuesa[0]['feedback_images'], true));
          }

          $arr_trans = $arr_trans_remarks =  $combine_value = [];
          $arr_trans = explode(",", $valuesa[0]['rejected_vendors']);
          $arr_trans_remarks = explode(",", $valuesa[0]['remarks']);
          $combine_value = array_combine($arr_trans, $arr_trans_remarks);
          $date1_ts = strtotime(date('Y-m-d', strtotime($valuesa[0]['purchaserate_added_date'])));
          $date2_ts = strtotime(date('Y-m-d'));
          $diff = $date2_ts - $date1_ts;
          $dateDiff_count = $diff / 86400;

          if ($valuesa[0]['status'] == 1) {
            $classcolour = 'blue';
          } elseif ($valuesa[0]['status'] == 3) {
            $classcolour = 'yellow';
          } else {
            $classcolour = 'zz';
          }


          if ($valuesa[0]['cancel_status'] == 1) {
            $s .= "<tr class='cancel' " . $classcolour . ">";
          } else if ($valuesa[0]['arrivedornot'] == 1) {
            $s .= "<tr class='arrived' " . $classcolour . ">";
          } else {
            $s .= "<tr class='" . $classcolour . "'>";
          }


          $s .= '<td style="display:none;">' . $classcolour . '</td>';
          $s .= '<td class="align-middle">' . $si . '</td>';
          $s .= '<td class="align-middle" >' . $valuesa[0]['ref_no'] . '</td>';
          $s .= '<td class="align-middle text-center">' . $valuesa[0]['client_name'] . '</td>';


          $s .= '<td class="p-0"><table class="p-0" style="margin-bottom:0 !important;width:100% !important" >';
        }
        $sdfr++;
        //main loop key>Vehicle Allotemnt id
        if ($j == 0) {
          $total = 0;
          $s .= '<tr>';
          $s .= "<td class='p-0'>
              <div class='purchaseratebill" . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . "'>
           <table style='width: 100%!important;' class='table-word'>
           <tr style='flex-direction: row;
           display: flex;
           justify-content: space-between;
           align-items: center;'>";

          $purchase_total = $purchase_total + $valuesa[0]['purchase_rate_shared'];

          //<br>N:'.$valuesa[0]['vehicle_no'].'
          if ($valuesa[0]['trip_went_not'] == 2) {
            $s .= '<td><b>Trip Not Went</b></td>';
          } else {
            if ($valuesa[0]['his_start_date'] != "" && $valuesa[0]['his_start_date'] != "0000-00-00") {
              $hiss_dateee_staert = $valuesa[0]['his_start_date'];
            } else {
              $hiss_dateee_staert = $valuesa[0]['va_start_date'];
            }
            $s .= '<td style="display: flex;
            justify-content: center;
            align-items: center;
            width: 85px;"> S:' . date('d/m/Y', strtotime($hiss_dateee_staert)) . '<br>E:' . date('d/m/Y', strtotime($valuesa[0]['va_end_date'])) . '</td>';
          }

          //Vehicle Remark
          //isset($arr_trans_remarks[$keya])&&
          $s .= "<td style='
          width: 85px !important;
          justify-content: center;
          align-items: center;
          display: flex;
        
          height:105px' >";

          if ($valuesa[0]['vehicle_remark'] != "") {
            $s .= "<div  class='show_query'><p> Remark<div class='show_me'>" . $valuesa[0]['vehicle_remark'] . "</div></p></div></td>";
          } else {
            $s .= "-";
          }

          $s .= "</td>";



          $s .= '<td style="width:65px"><table style="display: flex; justify-content: center; margin-bottom:0 !important; width:100% !important">';
        }


        foreach ($valuesa as $keyb => $valuesb) {

          $s .= '<tr style="display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          width: 70px;">';
          if (isset($valuesb['tripadvance_paid'])) {
            $s .= "<td class='show_query'>" . (isset($valuesb['tripadvance_paid']) ? $valuesb['tripadvance_paid'] : '-') . "<div class='show_me'>" . date('d/m/Y', strtotime($valuesb['payment_date'])) . "</div></td>";
            $s .= "</td>";
          } else {
            $s .= "<td style='width:50px';>-</td>";
            $s .= "</td>";
          }

          $s .= '</tr>';
        }


        $s .= '</table>';
        $s .= '</td>';
        $link = $linkf = '';
        $container0 = 'container0';
        $container1 = 'container1';
        $container2 = 'container2';



        if ($valuesa[0]['purchaserate_added_date'] != '0000-00-00 00:00:00' && ($type == 3 || $type == 5)) {
          if ($valuesa[0]['trip_went_not'] == 2) {
            $total_km = $valuesa[0]['total_km'];
            $amount = $valuesa[0]['purchase_rate_shared'];
            $remarks = $valuesa[0]['add_purchse_rate_remark'];
            $cal = 'Nill';
            //$valuesa[0]['add_purchase_rate_cal']
            $readonly = 'readonly';
            $disabled = 'disabled';
            $button_dis = 'disabled';
            $disabled_re = "disabled" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'];
            $label = 'Denied';
            $color = "redc";
            $class = "print-clean";
            $class_up = "noaction";
            $types = 'placeholder';
            $link = "";
            $linkf = "";
          } elseif ($valuesa[0]['purchaserateVerified'] == 0 && $valuesa[0]['status'] == 1) {
            $total_km = $valuesa[0]['total_km'];
            $amount = $valuesa[0]['purchase_rate_shared'];
            $remarks = $valuesa[0]['add_purchse_rate_remark'];
            $cal = $valuesa[0]['add_purchase_rate_cal'];
            $readonly = '';
            $disabled = '';
            $button_dis = '';
            $disabled_re = "";
            $color = "greenc";
            $label = 'Update';
            $class = "";
            $class_up = "";
            $types = 'text';
          } else {
            $total_km = $valuesa[0]['total_km'];
            $amount = (($valuesa[0]['purchase_rate_shared'] != 0) ? $valuesa[0]['purchase_rate_shared'] : '');
            $remarks = $valuesa[0]['add_purchse_rate_remark'];
            $cal = $valuesa[0]['add_purchase_rate_cal'];
            $readonly = 'readonly';
            $disabled = 'disabled';
            $button_dis = 'disabled';
            $disabled_re = "disabled" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'];
            $label = 'Denied';
            $color = "redc";
            $class = "print-clean";
            $class_up = "noaction";
            $types = 'placeholder';
          }


          $imageARRR = $valuesa[0]['bill_images'];
          $imageARRRDecode = json_decode($valuesa[0]['bill_images'], true);
          //<img class='thumbnail' src='../img/uploads/purchaserate_bill/".$img_bill_values ."' title='".$img_bill_values."' style='width:50%;'>
          if (!empty($imageARRRDecode)) {
            $e = 0;
            foreach ($imageARRRDecode as $kkk => $img_bill_values) {

              if (!is_int($kkk)) {
                $img_bill_values = $kkk;
              }
              $link .= "<div class='uploadfilee'><a class='removeFile " . $disabled_re . "  " . $disabled . "' href='javascript:void(0);' data-fileid='" . $e . "' ><button type='button' class='btn-close' aria-label='Close'></button></a><a href='javascript:void(0);' class='view_img" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onclick='dispalyImage(" . $e . ",\"purchaserate_bill\"," . $imageARRR . ");'><p style='display:none;'>" . $img_bill_values . " </p><span class='thumbnail'> " . substr($img_bill_values, 0, 8) . " ...</span></a></div>";
              $e++;
            }
          }


          $imageARRRf = $valuesa[0]['feedback_images'];
          $imageARRRfDecode = json_decode($valuesa[0]['feedback_images'], true);
          //<img class='thumbnail' src='../img/uploads/purchaserate_bill/".$img_feed_values ."' title='".$img_feed_values."' style='width:50%;'>
          if (!empty($imageARRRfDecode)) {
            $r = 0;
            foreach ($imageARRRfDecode as $kk1 => $img_feed_values) {

              if (!is_int($kk1)) {
                $img_feed_values = $kk1;
              }
              $linkf .= "<div class='uploadfilee'><a class='removeFile " . $disabled_re . "  " . $disabled . "' href='javascript:void(0);' data-fileid='" . $r . "'  ><button type='button' class='btn-close' aria-label='Close'></button></a><a href='javascript:void(0);' class='view_img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onclick='dispalyImage(" . $r . ",\"purchaserate_bill\"," . $imageARRRf . ");'><p style='display:none;'>" . $img_feed_values . " </p><span class='thumbnail'>" . substr($img_feed_values, 0, 8) . " ...</span></a></div>";
              $r++;
            }
          }
        }
        if ($valuesa[0]['purchaserate_added_date'] == '0000-00-00 00:00:00' && $type == 5) {
          if ($valuesa[0]['trip_went_not'] == 2) {
            $total_km = '0';
            $amount = '0';
            $remarks = 'Nil';
            $cal = 'Nil';
            $readonly = 'readonly';
            $disabled = 'disabled';
            $button_dis = '';
            $disabled_re = "disabled" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'];
            $label = 'Submit';
            $color = "orangec";
            $class = "print-clean";
            $class_up = "noaction";
            $types = 'placeholder';
            $link = "";
            $linkf = "";
          } else {
            $total_km = '';
            $amount = '';
            $remarks = '';
            $cal = '';
            $readonly = '';
            $disabled = '';
            $button_dis = '';
            $disabled_re = '';
            $label = 'Submit';
            $color = "orangec";
            $class = "";
            $class_up = "";
            $container0 = '';
            $container1 = '';
            $container2 = '';
            $types = 'text';
            $link = "";
            $linkf = "";
          }
        }




        //if($type!=5){

        $s .= "<td>
        <input style='width:80px; border: 1px solid #0d6efd;
        border-radius: 2px;'; type='" . $types . "' class='cvb " . $class . "' name='total_km" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onkeyup='checkalphabetandnumber(this.value, \"#total_km" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "\")' id='total_km" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $readonly . " value='" . $total_km . "'   maxlength='4' >
        
          </td>";
        $s .= "<td>
         
          
           <input style='width:80px; border: 1px solid #0d6efd; border-radius: 2px;'; type='" . $types . "' class='cvb " . $class . "' name='bal_amount" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onkeyup='checkalphabetandnumber(this.value, \"#bal_amount" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "\")'  id='bal_amount" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $readonly . " value='" . $amount . "' >
          
          </td>";
        $s .= "<td class='" . $container0 . "'>
    
        <div class='" . $container1 . "'><textarea style='border: 1px solid #0d6efd; border-radius: 2px; resize:auto;padding:3px 4px; width:100px; height:50px;outline: none;'  class='" . $class . " " . $container2 . "' name='cal" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'  id='cal" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $readonly . " >" . $cal . "
        </textarea>
        </div>
       
          </td>";
        // }
        $s .= "<td style='display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;' " . $container0 . "'>
            <input type='hidden' name='img_feedArr'>
           <input type='hidden' name='img_billArr'>
           <input type='hidden' name='type_button'>
           <input type='hidden' name='id_client_add'>
           <input type='hidden' name='loss_check" . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . "' id='loss_check" . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . "'>
           
           <div style='width:67px; display:flex; justify-content:center; align-item:center;' class='filedrf'><label  style='--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .65rem;' for='img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' class='btn btn-danger'" . $class_up . "  img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'><i class='fa-solid fa-upload pe-2'></i>Upload</label><input type='file'  class='" . $class . "    " . $container2 . "'  name='img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "[]'  id='img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $disabled . "  multiple onclick='removePic(this,\"result\");' onchange='showPreview(this,\"result\");'></div> <output id='result" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' > " . $link . "</output>
           
          </td>";
        $s .= "<td class='   d-flex flex-column  text-center justify-content-center align-items-center " . $container0 . "'>
          
          <div style='display:flex; justify-content: center;
          align-items: center;' class='filedrf'><label  style='--bs-btn-padding-y: .20rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .65rem;' class='btn btn-danger' for='img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' class='" . $class_up . "  img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'><i class='fa-solid fa-upload pe-2'></i>Upload</label><input type='file'  class='" . $class . "  " . $container2 . "' name='img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "[]'  id='img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $disabled . "  multiple onclick='removePic(this,\"result_feed\");' onchange='showPreview(this,\"result_feed\");'></div> <output id='result_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' >" . $linkf . "</output>
         
          </td>";
        // $s.="";  

        // $s.="<td   class='".$container0."'><div class='".$container1."'><textarea style='resize:auto;'  class='".$class." ".$container2."'  id='remarks".$valuesa[0]['id_client']."".$valuesa[0]['va_id']."' ".$readonly." >".$remarks."</textarea></div>
        // </td>";

        //if($type!=5){
        $s .= "<td style='    display: flex;
        justify-content: center;
        align-items: center;
        width: 100px; text-align:center;'>" . (($valuesa[0]['purchaserate_added_date'] != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($valuesa[0]['purchaserate_added_date'])) . "<br> Days  " . $dateDiff_count : '-') . "</td>";



        // if($valuesa[0]['purchase_rate_approval_status']==1){
        //    $s.="<td align='center' style='color:#108510;font-weight: bold;background:transparent; padding-left:20px' class='label color_field'>Approved</td>";

        //  }
        //  else if($valuesa[0]['purchase_rate_approval_status']==0){
        //    $s.="<td style='color:#851010;font-weight: bold;' class='label color_field'>Unapproved</span></td>";

        //  }

        $s .= "<td style='    display: flex;
        justify-content: center;
        align-items: center;
        width: 100px;'>";

        if (($type == 3 || $type == 5) && $valuesa[0]['rejected_remark'] != "") {
          $s .= "<div class='show_query'><p> Remark<div class='show_me'>" . $valuesa[0]['rejected_remark'] . "</div></p></div></td>";
        } elseif ($type == 6 && $valuesa[0]['rejected_remark_approval'] != "") {
          $s .= "<div class='show_query'><p> Remark<div class='show_me'>" . $valuesa[0]['rejected_remark_approval'] . "</div></p></div></td>";
        } else {
          $s .= "-";
        }

        $s .= "</td>";
        $s .= "<td class='text-center'>";

        if (!empty($Combined_image_val)) {
          $s .= '<i class="fa-solid fa-eye  view_bill" data="' . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . '"></i>';
          $s .= "<ul class='viewer_images' style='list-style-type: none;margin: 0 auto;text-align: center;columns: 3;'>";
          $a = 0;
          foreach ($Combined_image_val as $k => $image) {

            $s .= '<li style="padding:5px;display:none"><img class="img' . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . '" width="30px" height="20px" src="https://admin.buddiesholidays.in/img/uploads/purchaserate_bill/' . $image . '" title="Bill Image"/> </li>';
            $a++;
          }
          $s .= " </ul>";
        } else {
          $s .= '-';
        }

        $s .= "</td>";
        //}


        $s .= "<td> ";


        if ($label == 'Update') {

          $s .= "<div class='shohi parentdiv-" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'><span class='text modify' onclick='showhide(" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . ")'>Modify</span><button class='raz " . $color . " '   type='button' class='btn btn-default dialogs' onclick='Add(" . $valuesa[0]['va_id'] . "," . $valuesa[0]['id_client'] . ",\"update\"," . $valuesa[0]['trip_went_not'] . ")' " . $button_dis . " >" . $label . "</button></div>";
        } else {
          // $s.="<a class='customedit' href='".$url."&add_bill&va_id=".$valuesa[0]['va_id']."&id_client=".$valuesa[0]['id_client']."' >
          //    <button class='raz ".$color." modify'   type='button' class='btn btn-default dialogs' ".$disabled." >".$label."</button>
          //   </a>";
          $s .= "<button class='raz " . $color . " modify' type='button' class='btn btn-default dialogs' onclick='Add(" . $valuesa[0]['va_id'] . "," . $valuesa[0]['id_client'] . ",\"add\"," . $valuesa[0]['trip_went_not'] . ")' " . $button_dis . " >" . $label . "</button>";
        }
        $s .= "</td>";
        $s .= '</tr>
              </table>
              </div>
              </td>';
        $s .= '</tr>';



        if ($toclosewhile == $sdfr) {


          $s .= '</table>';
          $s .= '</td>';
          $s .= '</tr>';
        }
      }
    }
    return [
      "mobile" => 0,
      "content" => $s,
      "searchFrom" => isset($minDate)
        ? $minDate
        : "",
      "searchTo" => isset($maxDate)
        ? $maxDate
        : "",
      "searchType" => isset($type) ? $type : "",
    ];
  }
  public function prepareGridApproval($listArra, $type, $minDate, $maxDate)
  {
    $s = '';
    $si = 0;
    $toclosewhile = "";
    //main loop key>client reference
    foreach ($listArra as $keys => $list) {
      $purchase_total = 0;
      $si++;
      $sdfr = 0;
      $toclosewhile = count($list);

      foreach ($list as $keya => $valuesa) {
        $j = 0;
        $date1_ts = strtotime(date('Y-m-d', strtotime($valuesa[0]['purchaserate_added_date'])));
        $date2_ts = strtotime(date('Y-m-d'));
        $diff = $date2_ts - $date1_ts;
        $dateDiff_count = $diff / 86400;
        $toclosevaidloop = count($valuesa);

        if ($sdfr == 0) {

          $Combined_image_val = [];
          if ($valuesa[0]['bill_images']) {
            $Combined_image_val = array_merge(json_decode($valuesa[0]['bill_images'], true), json_decode($valuesa[0]['feedback_images'], true));
          }
          $arr_trans = $arr_trans_remarks =  $combine_value = [];
          $arr_trans = explode(",", $valuesa[0]['rejected_vendors']);
          $arr_trans_remarks = explode(",", $valuesa[0]['remarks']);
          $combine_value = array_combine($arr_trans, $arr_trans_remarks);

          if ($valuesa[0]['status'] == 1) {
            $classcolour = 'blue';
          } elseif ($valuesa[0]['status'] == 3) {
            $classcolour = 'yellow';
          } else {
            $classcolour = 'zz';
          }


          $s .= '<li class="col-xs-12 col-sm-12 col-md-12 col-lg-12 data-item py-2 px-2 ">';
          if ($valuesa[0]['cancel_status'] == 1) {
            $s .= '<div class="py-2 px-3 border rounded rounded-4 panel panel-default cancel ' . $classcolour . '" >';
            $s .= '<div class="panel-heading  cancel ' . $classcolour . '" style="margin-left:0rem;margin-right:0rem;display:flex;align-items:center;margin-bottom:0px;">';
          } else if ($valuesa[0]['arrivedornot'] == 1) {
            $s .= '<div class="py-2 px-3 border rounded rounded-4 panel panel-default arrived ' . $classcolour . '" >';
            $s .= '<div class="panel-heading  arrived ' . $classcolour . '" style="margin-left:0rem;margin-right:0rem;display:flex;align-items:center;margin-bottom:0px;">';
          } else {
            $s .= '<div class="py-2 px-3 border rounded rounded-4 panel panel-default ' . $classcolour . '" >';
            $s .= '<div class="panel-heading' . $classcolour . '" style="padding: 5px 0; font-weight: 900; justify-content: center; margin-left:0rem;margin-right:0rem;display:flex;align-items:center;margin-bottom:0px;">';
          }


          $s .= '<div class="panel-title" >' . $valuesa[0]['ref_no'] . '</div>';

          $s .= '</div>
          <div class="panel-body" style="font-size:13px">
    
          <div class="colmanagecar py-3">
          <p style="display: flex; justify-content: space-between; align-items: center;"><strong>Client Name</strong><span class="cllr"><b> ' . $valuesa[0]['client_name'] . '</b></span></p>';
        }
        $sdfr++;

        //main loop key>Vehicle Allotemnt id
        if ($j == 0) {
          $total = 0;
          $s .= '<div>';

          $purchase_total = $purchase_total + $valuesa[0]['purchase_rate_shared'];


          //<br>N:'.$valuesa[0]['vehicle_no'].'
          if ($valuesa[0]['trip_went_not'] == 2) {
            $s .= '<p style="display: flex; justify-content: space-between; align-items: center;"> <strong>Trip Date</strong> <span class="cllr"><b>Trip Not Went</b></span></p>';
          } else {
            if ($valuesa[0]['his_start_date'] != "" && $valuesa[0]['his_start_date'] != "0000-00-00") {
              $hiss_dateee_staert = $valuesa[0]['his_start_date'];
            } else {
              $hiss_dateee_staert = $valuesa[0]['va_start_date'];
            }


            $s .= '<p style="display: flex; justify-content: space-between; align-items: center;"> <strong>Trip Date:</strong><span class="cllr" style="font-size:14px;">S:' . date('d/m/Y', strtotime($hiss_dateee_staert)) . '<br>E:' . date('d/m/Y', strtotime($valuesa[0]['va_end_date'])) . '</span></p>';
          }

          //Vehicle Remark
          //isset($arr_trans_remarks[$keya])&&
          $s .= "<p style='display: flex; justify-content: space-between; align-items: center;'> <strong>Vehicle Remark</strong>";

          if ($valuesa[0]['vehicle_remark'] != "") {
            $s .= "<div style='display: flex; justify-content: space-between; align-items: center;' class='show_query'><p class='cllr'> Remark<div class='show_me cllr'>" . $valuesa[0]['vehicle_remark'] . "</div></p></div>";
          } else {
            $s .= "<span class='cllr'>-</span>";
          }

          $s .= "</p>";

        }

     foreach ($valuesa as $keyb => $valuesb) {
    $s .= '<p style="display: flex; justify-content: space-between; align-items: center;" >'.(($j==0)? "<strong>Trip Advance</strong>":"<span style='color:white;'>Trip Advance</span>");
    
    if (isset($valuesb['tripadvance_paid'])) {
        $s .= "<span class='show_query cllr'> " . (isset($valuesb['tripadvance_paid']) ? $valuesb['tripadvance_paid'] : '-') . "<div class='show_me cllr'>" . date('d/m/Y', strtotime($valuesb['payment_date'])) . "</div></span>";
    } else {
        $s .= "<span class='cllr'>-</span>";
    }

    $s .= "</p>";
    $j++;
}

        $link = $linkf = '';
        $container0 = 'container0';
        $container1 = 'container1';
        $container2 = 'container2';

        if ($valuesa[0]['purchaserate_added_date'] != '0000-00-00 00:00:00' && ($type == 3 || $type == 5)) {
          if ($valuesa[0]['trip_went_not'] == 2) {
            $total_km = $valuesa[0]['total_km'];
            $amount = $valuesa[0]['purchase_rate_shared'];
            $remarks = $valuesa[0]['add_purchse_rate_remark'];
            $cal = 'Nill';
            //$valuesa[0]['add_purchase_rate_cal']
            $readonly = 'readonly';
            $disabled = 'disabled';
            $button_dis = 'disabled';
            $disabled_re = "disabled" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'];
            $label = 'Denied';
            $color = "redc";
            $class = "print-clean";
            $class_up = "noaction";
            $types = 'placeholder';
            $link = "";
            $linkf = "";
          } elseif ($valuesa[0]['purchaserateVerified'] == 0 && $valuesa[0]['status'] == 1) {
            $total_km = $valuesa[0]['total_km'];
            $amount = $valuesa[0]['purchase_rate_shared'];
            $remarks = $valuesa[0]['add_purchse_rate_remark'];
            $cal = $valuesa[0]['add_purchase_rate_cal'];
            $readonly = '';
            $disabled = '';
            $button_dis = '';
            $disabled_re = "";
            $color = "greenc";
            $label = 'Update';
            $class = "";
            $class_up = "";
            $types = 'text';
          } else {
            $total_km = $valuesa[0]['total_km'];
            $amount = (($valuesa[0]['purchase_rate_shared'] != 0) ? $valuesa[0]['purchase_rate_shared'] : '');
            $remarks = $valuesa[0]['add_purchse_rate_remark'];
            $cal = $valuesa[0]['add_purchase_rate_cal'];
            $readonly = 'readonly';
            $disabled = 'disabled';
            $button_dis = 'disabled';
            $disabled_re = "disabled" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'];
            $label = 'Denied';
            $color = "redc";
            $class = "print-clean";
            $class_up = "noaction";
            $types = 'placeholder';
          }

          $imageARRR = $valuesa[0]['bill_images'];
          $imageARRRDecode = json_decode($valuesa[0]['bill_images'], true);
          //<img class='thumbnail' src='../img/uploads/purchaserate_bill/".$img_bill_values ."' title='".$img_bill_values."' style='width:50%;'>
          if (!empty($imageARRRDecode)) {
            $e = 0;
            foreach ($imageARRRDecode as $kkk => $img_bill_values) {

              if (!is_int($kkk)) {
                $img_bill_values = $kkk;
              }
              $link .= "<div class='uploadfilee cllr'><a class='removeFile cllr " . $disabled_re . "  " . $disabled . "' href='javascript:void(0);' data-fileid='" . $e . "' ><button type='button' class='btn-close' aria-label='Close'></button></a><a href='javascript:void(0);' class='view_img" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onclick='dispalyImage(" . $e . ",\"purchaserate_bill\"," . $imageARRR . ");'><p style='display:none;'>" . $img_bill_values . " </p><span class='thumbnail' style='width:60px'> " . substr($img_bill_values, 0, 8) . " ...</span></a></div>";
              $e++;
            }
          }


          $imageARRRf = $valuesa[0]['feedback_images'];
          $imageARRRfDecode = json_decode($valuesa[0]['feedback_images'], true);
          //<img class='thumbnail' src='../img/uploads/purchaserate_bill/".$img_feed_values ."' title='".$img_feed_values."' style='width:50%;'>
          if (!empty($imageARRRfDecode)) {
            $r = 0;
            foreach ($imageARRRfDecode as $kk1 => $img_feed_values) {

              if (!is_int($kk1)) {
                $img_feed_values = $kk1;
              }
              $linkf .= "<div class='uploadfilee cllr'><a class='removeFile cllr " . $disabled_re . "  " . $disabled . "' href='javascript:void(0);' data-fileid='" . $r . "'  ><button type='button' class='btn-close' aria-label='Close'></button></a><a href='javascript:void(0);' class='view_img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onclick='dispalyImage(" . $r . ",\"purchaserate_bill\"," . $imageARRRf . ");'><p style='display:none;'>" . $img_feed_values . " </p><span class='thumbnail' style='width:60px'>" . substr($img_feed_values, 0, 8) . " ...</span></a></div>";
              $r++;
            }
          }
        }


        // transporter add 
        else {
          if ($valuesa[0]['trip_went_not'] == 2) {
            $total_km = '0';
            $amount = '0';
            $remarks = 'Nil';
            $cal = 'Nil';
            $readonly = 'readonly';
            $disabled = 'disabled';
            $button_dis = '';
            $disabled_re = "disabled" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'];
            $label = 'Submit';
            $color = "orangec";
            $class = "print-clean";
            $class_up = "noaction";
            $types = 'placeholder';
            $link = "";
            $linkf = "";
          } else {
            $total_km = '';
            $amount = '';
            $remarks = '';
            $cal = '';
            $readonly = '';
            $disabled = '';
            $button_dis = '';
            $disabled_re = '';
            $label = 'Submit';
            $color = "orangec";
            $class = "";
            $class_up = "";
            $container0 = '';
            $container1 = '';
            $container2 = '';
            $types = 'text';
            $link = "";
            $linkf = "";
          }
        }

        $s .= "<div class='purchaseratebill" . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . "'>
           <input type='hidden' name='img_feedArr'>
           <input type='hidden' name='img_billArr'>
           <input type='hidden' name='type_button'>
           <input type='hidden' name='id_client_add'>
           <input type='hidden' name='loss_check" . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . "' id='loss_check" . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . "'>";


        $s .= "<p style='display: flex; justify-content: space-between; align-items: center;'><strong>Total Km</strong><input style='border: 1px solid #0d6efd; border-radius: 2px' type='" . $types . "' class='cvb cllr text-end w-50 ".$class . "' name='total_km" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onkeyup='checkalphabetandnumber(this.value, \"#total_km" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "\")'  id='total_km" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $readonly . " value='" . $total_km . "'   maxlength='4' >
          </p>";
        $s .= "<p style='display: flex; justify-content: space-between; align-items: center;'><strong>Bill Amount</strong><input style='border: 1px solid #0d6efd; border-radius: 2px; text-align: end;' type='" . $types . "' class='cvb cllr text-end w-50 " . $class . "' name='bal_amount" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'  id='bal_amount" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' onkeyup='checkalphabetandnumber(this.value, \"#bal_amount" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "\")' " . $readonly . " value='" . $amount . "' >
          </p>";
        $s .= "<p  style='display: flex; justify-content: space-between; align-items: center;' class='" . $container0 . "'><strong>Calculation</strong> <textarea style='border: 1px solid #0d6efd; border-radius: 2px; resize:auto;padding:3px 4px;outline: none;'  class=' w-50 " . $class . " " . $container2 . "' name='cal" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'  id='cal" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $readonly . " >" . $cal . "</textarea></p>";



        $s .= "<div class='d-flex justify-content-between mb-3'><strong>Upload Bill</strong><div class='filedrf cllr '><label for='img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' class='btn btn-danger btn-sm ". $class_up . " img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'><i class='fa-solid fa-upload'></i>&nbsp; Upload</label><input type='file'  class='" . $class . "  " . $container2 . "'  name='img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "[]'  id='img_bil" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $disabled . "  multiple onclick='removePic(this,\"result\");' onchange='showPreview(this,\"result\");'></div></div> <output style='float:right;' id='result" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' > " . $link . "</output>
          ";
        $s .= "<div class='" . $container0 . " sdf'><div class='d-flex justify-content-between mb-3'><strong>Upload Feedback</strong><div class='filedrf cllr'><label for='img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'  class='btn btn-danger btn-sm ". $class_up . "  img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'><i class='fa-solid fa-upload'></i>&nbsp; Upload</label><input type='file'  class='" . $class . "  " . $container2 . "' name='img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "[]'  id='img_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' " . $disabled . "  multiple onclick='removePic(this,\"result_feed\");' onchange='showPreview(this,\"result_feed\");'></div></div> <div><output style='float:right' id='result_feed" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "' >" . $linkf . "</output></div></div>";
        $s .= "</div>";
        // $s.="";

        // $s.="<p   class='".$container0."'><div class='".$container1."'><textarea style='resize:auto;'  class='".$class." ".$container2."'  id='remarks".$valuesa[0]['id_client']."".$valuesa[0]['va_id']."' ".$readonly." >".$remarks."</textarea></div>
        // </p>";
        //if($type!=5){
        if ($valuesa[0]['purchaserate_added_date'] != '0000-00-00 00:00:00') {
          $s .= "<p style='display: flex; justify-content: space-between; align-items: center;clear:both;'><strong>Purchaserate Added Date:</strong><span class='cllr text-end'>" . (($valuesa[0]['purchaserate_added_date'] != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($valuesa[0]['purchaserate_added_date'])) . "<br> Days  " . $dateDiff_count : '-') . "</span></p>";
        }




        // if($valuesa[0]['purchase_rate_approval_status']==1){
        //    $s.="<p><strong>Approval Status:</strong><span align='center' style='color:#108510;font-weight: bold;background:transparent; padding-left:20px' class='label color_field'>Approved</span></p>";

        //  }
        //  else if($valuesa[0]['purchase_rate_approval_status']==0){
        //    $s.="<p><strong>Approval Status:</strong><span style='color:#851010;font-weight: bold;' class='label color_field'>Unapproved</span></p>";

        //  }

        if (($type == 3 || $type == 5) && $valuesa[0]['rejected_remark'] != "") {
          $s .= "<p><strong>Rejected Remark</strong>";

          $s .= "<div class='show_query cllr'><p> Remark<div class='show_me cllr'>" . $valuesa[0]['rejected_remark'] . "</div></p></div>";

          $s .= "</p>";
        } elseif ($type == 6 && $valuesa[0]['rejected_remark_approval'] != "") {
          $s .= "<p><strong>Rejected Remark</strong>";

          $s .= "<div class='cllr'><p> Remark<div class='show_me cllr'>" . $valuesa[0]['rejected_remark_approval'] . "</div></p></div>";

          $s .= "</p>";
        }

        // else{
        // $s.="-";

        // } 


        if (!empty($Combined_image_val)) {
          $s .= "<p style='display: flex; justify-content: space-between; align-items: center;'><strong>Images</strong>";
          $s .= '<button class="btn btn-primary btn-sm"><i class="fa-solid fa-eye view_bill" data="' . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . '"></i></button>';
          $s .= "<ul class='viewer_images' style='list-style-type: none;margin: 0 auto;text-align: center;columns: 3;'>";
          $a = 0;
          foreach ($Combined_image_val as $k => $image) {

            $s .= '<li style="padding:5px;display:none"><img class="img' . $valuesa[0]['id_client'] . $valuesa[0]['va_id'] . '" width="30px" height="20px" src="https://admin.buddiesholidays.in/img/uploads/purchaserate_bill/' . $image . '" title="Bill Image"/> </li>';
            $a++;
          }
          $s .= " </ul>";
          $s .= "</p>";
        }



        //}
        $s .= "<p class='bot_button cllr w-100 d-flex justify-content-center'> ";


        if ($label == 'Update') {

          $s .= "<div class='shohi parentdiv-" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . "'><span class='text modify' onclick='showhide(" . $valuesa[0]['id_client'] . "" . $valuesa[0]['va_id'] . ")'>Modify</span><button class='raz " . $color . " '   type='button' class='btn btn-default dialogs' onclick='Add(" . $valuesa[0]['va_id'] . "," . $valuesa[0]['id_client'] . ",\"update\"," . $valuesa[0]['trip_went_not'] . ")' " . $button_dis . " >" . $label . "</button></div>";
        } else {
          // $s.="<a class='customedit' href='".$url."&add_bill&va_id=".$valuesa[0]['va_id']."&id_client=".$valuesa[0]['id_client']."' >
          //    <button class='raz ".$color." modify'   type='button' class='btn btn-default dialogs' ".$disabled." >".$label."</button>
          //   </a>";
          $s .= "<button style='width:50%' class='raz btn btn-danger'" . $color . " modify' type='button' class='btn btn-default dialogs' onclick='Add(" . $valuesa[0]['va_id'] . "," . $valuesa[0]['id_client'] . ",\"add\"," . $valuesa[0]['trip_went_not'] . ")' " . $button_dis . " >" . $label . "</button>";
        }
        $s .= "</p>";

        $s .= '</div>';



        if ($toclosewhile == $sdfr) {


          $s .= '</div>';
          $s .= '</div>';
          $s .= '</li>';
        }
      }
    }
    return [
      "no_of_records"=>$toclosewhile,
      "mobile" => 1,
      "content" => $s,
      "searchFrom" => isset($minDate)
        ? $minDate
        : "",
      "searchTo" => isset($maxDate)
        ? $maxDate
        : "",
      "searchType" => isset($type) ? $type : "",
    ];
  }
  public function PurchaseRateAdd($GetDatas)
  {

    $img_feedArr = $img_billArr = [];

    $id_client = $GetDatas['id_client'];
    $va_id = $GetDatas['va_id'];
    $cal = $GetDatas['cal'];
    $pay = $GetDatas['bill_amount'];
    $total_km = $GetDatas['total_km'];
    $type = $GetDatas['type'];

    $file_namesss_fedd = $file_namesss_bill = [];


    function compress($source, $destination, $quality)
    {

      $info = getimagesize($source);

      if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

      elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

      elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

      imagejpeg($image, $destination, $quality);
      return $destination;
    }
    if (!empty($_FILES["img_bil"]["tmp_name"]) && $_FILES["img_bil"]["tmp_name"][0] != "") {


      foreach ($_FILES["img_bil"]["tmp_name"] as $key => $tmp_name) {
        $bb = [];

        $bb = explode('.', $_FILES["img_bil"]["name"][$key]);
        $img_billArr[$_FILES["img_bil"]["name"][$key]] = $file_namesss_bill = $bb[0] . '_' . time() . '.' . $bb[1];

        $source_img_bill = $_FILES["img_bil"]["tmp_name"][$key];
        $destination_img_bill = 'https://admin.buddiesholidays.in/img/uploads/purchaserate_bill/' . $file_namesss_bill;
        //$destination_img_bill = './assets/purchaserate_bill/'.$file_namesss_bill;

        $moved_compress_bill = compress($source_img_bill, $destination_img_bill, 20);
      }
      //$file_name_bill=json_encode($_FILES["img_bil"]["name"]);
      $file_name_bill = json_encode($img_billArr);
    } else {

      $find = $this->pdo->prepare('SELECT bill_images,trip_went_not FROM ps_vehicle_allotment where va_id=' . $va_id . ' and  client_table_id=' . $id_client);
      $find->execute();
      $find = $find->fetchAll(PDO::FETCH_ASSOC);

      if (empty($find[0]['bill_images']) && $find[0]['trip_went_not'] != 2) {
        echo 'Error!..Upload Bill';
        exit;
      } else {

        $file_name_bill = $find[0]['bill_images'];
      }
    }

    if (!empty($_FILES["img_feed"]["tmp_name"]) && $_FILES["img_feed"]["tmp_name"][0] != "") {

      foreach ($_FILES["img_feed"]["tmp_name"] as $key1 => $tmp_name1) {

        $ff = [];
        $ff = explode('.', $_FILES["img_feed"]["name"][$key1]);
        $img_feedArr[$_FILES["img_feed"]["name"][$key1]] = $file_namesss_fedd = $ff[0] . '_' . time() . '.' . $ff[1];

        $source_img_feedback = $_FILES["img_feed"]["tmp_name"][$key1];
        $destination_img_feedback = 'https://admin.buddiesholidays.in/img/uploads/purchaserate_bill/' . $file_namesss_fedd;
        //$destination_img_feedback = './assets/purchaserate_bill/'.$file_namesss_fedd;
        $moved_compress_feedback = compress($source_img_feedback, $destination_img_feedback, 20);
      }
      //$file_name_feedback=json_encode($_FILES["img_feed"]["name"]);
      $file_name_feedback = json_encode($img_feedArr);
    } else {
      $find1 = $this->pdo->prepare('SELECT feedback_images,trip_went_not FROM ps_vehicle_allotment where va_id=' . $va_id . ' and  client_table_id=' . $id_client);
      $find1->execute();
      $find1 = $find1->fetchAll(PDO::FETCH_ASSOC);

      if (empty($find1[0]['feedback_images']) && $find1[0]['trip_went_not'] != 2) {
        echo 'Error!..Upload Feedback.';
        exit;
      } else {
        $file_name_feedback = $find1[0]['feedback_images'];
      }
    }
    $tab_id = 263;
    $status = 0;
    $todayDateTime = date('Y-m-d H:i:s');

    if ($type == 'update') {

      $results = $this->pdo->prepare("UPDATE ps_vehicle_allotment SET purchase_rate_shared = :purchase_rate_shared, status = :status, total_km=:total_km, add_purchase_rate_cal=:add_purchase_rate_cal,bill_images=:bill_images,feedback_images=:feedback_images,employee_id=:employee_id,tab_id=:tab_id WHERE va_id = :va_id and client_table_id=:client_table_id");

      $results->bindParam(':purchase_rate_shared', $pay);
      $results->bindParam(':status', $status);
      $results->bindParam(':total_km', $total_km);
      $results->bindParam(':add_purchase_rate_cal', $cal);
      $results->bindParam(':bill_images', $file_name_bill);
      $results->bindParam(':feedback_images', $file_name_feedback);
      $results->bindParam(':employee_id', $_SESSION['user_id']);
      $results->bindParam(':tab_id', $tab_id);
      $results->bindParam(':va_id', $va_id);
      $results->bindParam(':client_table_id', $id_client);
      $results->execute();
    } else {
      $results = $this->pdo->prepare("UPDATE ps_vehicle_allotment SET purchase_rate_shared = :purchase_rate_shared, status = :status, total_km=:total_km, add_purchase_rate_cal=:add_purchase_rate_cal,bill_images=:bill_images,feedback_images=:feedback_images,purchaserate_added_date=:purchaserate_added_date,employee_id=:employee_id,tab_id=:tab_id WHERE va_id = :va_id and client_table_id=:client_table_id");

      $results->bindParam(':purchase_rate_shared', $pay);
      $results->bindParam(':status', $status);
      $results->bindParam(':total_km', $total_km);
      $results->bindParam(':add_purchase_rate_cal', $cal);
      $results->bindParam(':bill_images', $file_name_bill);
      $results->bindParam(':feedback_images', $file_name_feedback);
      $results->bindParam(':purchaserate_added_date', $todayDateTime);
      $results->bindParam(':employee_id', $_SESSION['user_id']);
      $results->bindParam(':tab_id', $tab_id);
      $results->bindParam(':va_id', $va_id);
      $results->bindParam(':client_table_id', $id_client);
      $results->execute();
    }

    if ($results) {
      echo 'Added successful';
    } else {
      echo 'Error in Add ...Pls try again later';
    }
    exit;
  }
}
