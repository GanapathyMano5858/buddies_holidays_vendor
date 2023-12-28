<?php
class VehicleAllotmentModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function vehicleAllotment($GetDatas)
    {
        $vialist = [1 => "Flight", 2 => "Train", 3 => "Bus", 4 => "Residency"];
        $useragent = $_SERVER["HTTP_USER_AGENT"];

        if (
            preg_match(
                "/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i",
                $useragent
            ) ||
            preg_match(
                "/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|D(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i",
                substr($useragent, 0, 4)
            )
        ) {
            $mobile = "true";
        } else {
            $mobile = "false";
        }

        if (isset($GetDatas["type"]) && $GetDatas["type"] == 2) {
            $type =
                'va.va_driver_id!="" and va.va_vehicle_id!="" and c.cancel_status!=1 and c.arrivedornot!=1 and c.status_datechanged!=1';
        } elseif (isset($GetDatas["type"]) && $GetDatas["type"] == 3) {
            $type = "c.cancel_status!=1 and c.arrivedornot!=1";
        } elseif (isset($GetDatas["type"]) && $GetDatas["type"] == 4) {
            $type = "(c.cancel_status=1 or c.arrivedornot=1)";
        } else {
            $type =
                '(va.va_driver_id="" and va.va_vehicle_id="" and c.cancel_status!=1 and c.arrivedornot!=1) or c.status_datechanged=1';
        }

        if (
            isset($GetDatas["from"]) &&
            $GetDatas["from"] != "" &&
            isset($GetDatas["to"]) &&
            $GetDatas["to"] != ""
        ) {
            $fromdate = str_replace("/", "-", $GetDatas["from"]);
            $todate = str_replace("/", "-", $GetDatas["to"]);
            $where =
                'c.start_from BETWEEN  "' .
                date("Y-m-d", strtotime($fromdate)) .
                '" AND "' .
                date("Y-m-d", strtotime($todate)) .
                '"';
        } else {
            $where =
                "c.start_from between '" .
                date("Y-m-d") .
                "'and'" .
                date("Y-m-d", strtotime("+1 month")) .
                "'";
        }
        $vehicleallotmentlist = $this->pdo->prepare(
            "SELECT c.* ,va.status as vehicle_st,va.updated_date as update_d, va.create_date as vehicle_created_date, va.remarks as vehicle_remark ,va.va_driver_id ,va.va_vehicle_id,v.v_id,v.vehicle_type as d_vehicle_type,v.vehicle_no,dr.contact_no,dr.contactalterno,dr.driver_name,va.va_id,va.client_table_id,va.va_start_date,va.trip_went_not,va.trip_completed,va.va_end_date,va.va_transporter_id,t.transporter_name,t.trans_vendors,t.email,t.t_id,v.vehicle_no ,va.purchase_rate_shared from ps_client c left join ps_vehicle_allotment va on(va.client_table_id=c.id_client and va.va_transporter_id=" .
                $_SESSION["trans_vendor_id"] .
                ")  left join ps_vehicles v on(v.v_id=va.va_vehicle_id) left join ps_driver as dr on (dr.id_driver=va.va_driver_id)  left join ps_transporter t on(t.t_id=va.va_transporter_id ) where  c.package_type!=3 and c.status=0  and t.t_id=" .
                $_SESSION["trans_vendor_id"] .
                "  and " .
                $where .
                "  and " .
                $type .
                " and c.status_datechanged!=1 and va.trip_went_not!=2 order by c.start_from asc, va.va_id asc"
        );

        $vehicleallotmentlist->execute();
        $vehicleallotmentlist = $vehicleallotmentlist->fetchAll(
            PDO::FETCH_ASSOC
        );
        $privilege_query[0]["vendor"] = 1;
        $permission["edit"] = 1;

        $i = 1;
        $s = $ff = $input = "";

        function group_assoc($array, $key)
        {
            $return = [];
            foreach ($array as $v) {
                $return[$v[$key]][] = $v;
            }
            return $return;
        }

        //Group the requests by their account_id

        $vehicle_table = group_assoc($vehicleallotmentlist, "ref_no");
        //echo '<pre>';print_r($account_requestsgfg);die;

        $actual_link = './common_files/download_pdf_trans.php';

        $last_trans_date = [];

        foreach ($vehicle_table as $key => $list) {
            $Allot_button = "-";
            $arr_tranfffs = [];
            $t = 0;

            foreach ($list as $keys => $valus) {
                $select_last_trans = $this->pdo->prepare(
                    "select va_id from ps_vehicle_allotment where client_table_id=" .
                        $valus["id_client"] .
                        "  order by va_id desc limit 0,1"
                );
                $select_last_trans->execute();
                $select_last_trans = $select_last_trans->fetchAll(
                    PDO::FETCH_ASSOC
                );

                if ($t == 0) {
                    $select_client_id = $this->pdo->prepare(
                        'SELECT id_client FROM ps_client where  FIND_IN_SET("' .
                            $_SESSION["trans_vendor_id"] .
                            '",rejected_vendors)'
                    );
                    $select_client_id->execute();
                    $select_client_id = $select_client_id->fetchAll(
                        PDO::FETCH_ASSOC
                    );

                    $client_id_val1 = [];
                    foreach ($select_client_id as $client_id_val) {
                        $client_id_val1[] = $client_id_val["id_client"];
                    }

                    if (
                        in_array($valus["id_client"], $client_id_val1) &&
                        $privilege_query[0]["vendor"] == 1 &&
                        $_SESSION["trans_vendor_id"] != $valus["transporter_id"]
                    ) {
                        $s .= "<tr class='disable'>ujtyuytuty";
                        $ff .= "<tr class='disable'>ujtyuytuty";
                    } else {
                        if ($valus["status_datechanged"] == 1) {
                            $Color_datechanged = "violet";
                        } else {
                            $Color_datechanged = "zz";
                        }
                        if ($valus["cancel_status"] == 1) {
                            $s .=
                                "<tr  class='cancel " .
                                $Color_datechanged .
                                "' >";
                            $ff .=
                                "<tr  class='cancel " .
                                $Color_datechanged .
                                "' >";
                        } elseif ($valus["arrivedornot"] == 1) {
                            $s .=
                                "<tr class='arrived " .
                                $Color_datechanged .
                                "' >";
                            $ff .=
                                "<tr class='arrived " .
                                $Color_datechanged .
                                "' >";
                        } else {
                            $s .= "<tr class='" . $Color_datechanged . "'>";
                            $ff .= "<tr class='" . $Color_datechanged . "'>";
                        }
                    }
                    $arrivalviadetails =
                        $valus["a_train_flight_no"] != ""
                        ? " -(Via - " .
                        $vialist[$valus["arrival_via"]] .
                        ", " .
                        $valus["a_train_flight_no"] .
                        ")"
                        : "";
                    $departureviadetails =
                        $valus["d_train_flight"] != ""
                        ? " -(Via - " .
                        $vialist[$valus["departure_via"]] .
                        ", " .
                        $valus["d_train_flight"] .
                        ")"
                        : "";

                    if ($mobile == "true") {
                        // <span class='asr'>Arrival</span> <span class='cllr'>".$valus['client_arrival_name']." ".$arrivalviadetails."</span><br>
                        //     <span class='asr'>Departure</span> <span class='cllr'>".$valus['client_departure_name']." ".$departureviadetails."</span><br>
                        if ($privilege_query[0]["vendor"] == 1) {
                            if (
                                $valus["va_driver_id"] == "" ||
                                $valus["va_driver_id"] == 0
                            ) {
                                $VEHICLE = $valus["vehicle_type"];
                                $DATEFORM_star = $DATEFORM =
                                    $valus["start_from"];
                                $no_of_days = $valus["no_of_days"];
                            } else {
                                $countArr = count($list);
                                $VEHICLE =
                                    $list[$countArr - 1]["d_vehicle_type"];
                                $DATEFORM_star = $DATEFORM =
                                    $list[$countArr - 1]["va_start_date"];
                                $DATETO = $list[$countArr - 1]["va_end_date"];
                                $dateDiff =
                                    strtotime($DATETO) - strtotime($DATEFORM);
                                $no_of_days =
                                    floor($dateDiff / (3600 * 24)) + 1;
                            }
                        } else {
                            if (
                                $valus["va_driver_id"] == "" ||
                                $valus["va_driver_id"] == 0
                            ) {
                                $VEHICLE = $valus["vehicle_type"];
                                $DATEFORM = $valus["start_from"];
                            } else {
                                $countArr = count($list);
                                $VEHICLE =
                                    $list[$countArr - 1]["d_vehicle_type"];
                                $DATEFORM =
                                    $list[$countArr - 1]["va_start_date"];
                            }

                            $DATEFORM_star = $valus["start_from"];
                            $no_of_days = $valus["no_of_days"];
                        }

                        $cartypesdd = $this->pdo->prepare(
                            "SELECT b.vehicle_type_name,b.vt_id from   ps_vehicletypes as b  where b.vt_id=" .
                                $valus["vehicle_type"]
                        );
                        $cartypesdd->execute();
                        $cartypesdd = $cartypesdd->fetchAll(PDO::FETCH_ASSOC);

                        $ff .=
                            "<td>" . $Color_datechanged . "  " . $i . "</td>";
                        $ff .= "<td class=''>";
                        $ff .=
                            "<span class='asr'>Booking Id</span> <span class='cllr'>" .
                            $valus["ref_no"] .
                            "</span><br>";
                        $ff .=
                            "<span class='asr'> Guest Name</span> <span class='cllr'>" .
                            $valus["client_name"] .
                            "</span><br>";
                        if ($valus["trip_went_not"] != 2) {
                            $ff .=
                                "<span class='asr'>Arrival Date</span> <span class='cllr'>" .
                                date("d/m/Y", strtotime($DATEFORM_star)) .
                                "</span>";
                        } else {
                            $ff .=
                                "<span class='asr'>Arrival Date</span> <span class='cllr'>Trip Not Went</span>";
                        }

                        $ff .=
                            "<br>
								     <span class='asr'>No of days</span> <span class='cllr'>" .
                            $no_of_days .
                            " </span><br>
								         <span class='asr'>Vehicle Type</span> <span class='cllr'>" .
                            $cartypesdd[0]["vehicle_type_name"] .
                            " </span><br>";
                        // if($valus['details']){
                        $ff .=
                            " <span class='asr'>Download Itinerary</span> <span class='cllr'><span id='itinerary_down" .
                            $valus["id_client"] .
                            "'></span></span><br>";
                        //}
                        if ($privilege_query[0]["vendor"] == 0) {
                            $select_transporter1 = $this->pdo->prepare(
                                "SELECT email FROM ps_transporter where t_id=" .
                                    $valus["transporter_id"] .
                                    ""
                            );
                            $select_transporter1->execute();
                            $select_transporter1 = $select_transporter1->fetchAll(
                                PDO::FETCH_ASSOC
                            );
                            $ff .=
                                "<span class='asr'>Email</span><span class='cllr'><button type='button' class='mailee' data-toggle='modal' onclick='javascript:return export_mail_modal(" .
                                $valus["id_client"] .
                                ",\"" .
                                $select_transporter1[0]["email"] .
                                "\",\"" .
                                $valus["start_from"] .
                                "\"," .
                                $privilege_query[0]["vendor"] .
                                ")'><strong><i class='fa fa-envelope'></i></strong></button></span><br>";
                        }

                        $ff .=
                            "<span class='asr'>View</span>
									<span class='cllr'><a class='customedit' href='javascript:void(0)' title='View' onclick='javascript:return showClientDetails(" .
                            $valus["id_client"] .
                            "," .
                            $_SESSION["trans_vendor_id"] .
                            ");'>
									<i class='fa-solid fa-eye'></i>
									</a></span><br>";
                        //$valus['end_to']>=date('Y-m-d')&&
                        if (
                            $valus["cancel_status"] == 0 &&
                            $valus["arrivedornot"] == 0
                        ) {
                            $ff .= "<span class='asr'>Allot</span>";
                        }
                    } else {
                        $s .=
                            "<td style='display:none;'>" .
                            $Color_datechanged .
                            "</td>";

                        $s .= "<td>" . $i . "</td>";
                        $s .=
                            "<td>" .
                            (isset($valus["ref_no"]) ? $valus["ref_no"] : "-") .
                            "</td>";

                        $s .=
                            "<td class='text-nowrap'>" .
                            (isset($valus["client_name"])
                                ? $valus["client_name"]
                                : "-") .
                            "</td>
						
						<td /*class='text-nowrap'*/>" .
                            (isset($valus["client_arrival_name"])
                                ? $valus["client_arrival_name"]
                                : "-") .
                            "" .
                            $arrivalviadetails .
                            "
						</td>
						<td>" .
                            (isset($valus["client_departure_name"])
                                ? $valus["client_departure_name"]
                                : "-") .
                            " " .
                            $departureviadetails .
                            "
						</td>";
                        $s .=
                            "<td class='text-nowrap'>A:" .
                            ($valus["start_from"]
                                ? date("d-m-Y", strtotime($valus["start_from"]))
                                : "-") .
                            "<br>D:" .
                            ($valus["end_to"]
                                ? date("d-m-Y", strtotime($valus["end_to"]))
                                : "-") .
                            "</td>";

                        $s .=
                            "<td style='padding:0'><table style='width:100% !important'>";
                    }
                } //  if t close

                if (isset($last_trans_date[$valus["id_client"]])) {
                    $old_transporter_date = date(
                        "Y-m-d",
                        strtotime(
                            $last_trans_date[$valus["id_client"]] . " +1 day"
                        )
                    );
                } else {
                    $old_transporter_date = $valus["start_from"];
                }
                $select_driver = $this->pdo->prepare(
                    "select va_start_date,va_end_date,driver_name from ps_vehicle_allotment v left join ps_driver d on (d.id_driver=v.va_driver_id) where v.client_table_id=" .
                        $valus["id_client"] .
                        " and v.va_driver_id!=0 and v.va_vehicle_id!=0 and v.trip_went_not!=2 order by va_id desc limit 0,1"
                );
                $select_driver->execute();
                $select_driver = $select_driver->fetchAll(PDO::FETCH_ASSOC);
                if (
                    is_array($select_driver) &&
                    !empty($select_driver) &&
                    $select_driver[0]["va_start_date"] != "" &&
                    $select_driver[0]["va_start_date"] != "0000-00-00" &&
                    $select_driver[0]["va_start_date"] != "1970-01-01"
                ) {
                    $last_trans_date[$valus["id_client"]] =
                        $select_driver[0]["va_end_date"];
                }

                if ($mobile == "false") {
                    if (
                        $valus["va_driver_id"] == "" ||
                        $valus["va_driver_id"] == 0
                    ) {
                        $VEHICLE = $valus["vehicle_type"];
                        $DATEFORM = $valus["start_from"];
                        $DATETO = $valus["end_to"];
                        $TRANSPORTER = $valus["va_transporter_id"];
                        $TRANSPORTER_va_id = $valus["va_id"];
                        $s .=
                            "<tr><td style='width: 11%;'><span class='date_history" .
                            $TRANSPORTER .
                            $valus["id_client"] .
                            $valus["va_id"] .
                            "'></span><br><span >-</span></td>";
                    } else {
                        $VEHICLE = $valus["d_vehicle_type"];
                        $TRANSPORTER = $valus["va_transporter_id"];
                        $TRANSPORTER_va_id = $valus["va_id"];

                        if ($valus["trip_went_not"] == 2) {
                            $DATEFORM = $valus["va_start_date"];
                            $DATETO = $valus["va_end_date"];

                            //$s.="<tr ><td style='width: 11%;'><span class='date_history".$TRANSPORTER.$valus['id_client'].$valus['va_id']."'></span><br><span style='color: #2777bb;'>A:".(($DATEFORM) ?date('d-m-Y',strtotime($DATEFORM)) : '-')."</span><br>D:".(($DATETO) ? date('d-m-Y',strtotime($DATETO)).'(Trip Not Went)' : 'Trip Not Went')."</td>";
                            $s .=
                                "<tr ><td style='width: 11%;'><span class='date_history" .
                                $TRANSPORTER .
                                $valus["id_client"] .
                                $valus["va_id"] .
                                "'></span><br>Trip Not Went</td>";
                        } else {
                            $DATEFORM = $valus["va_start_date"];
                            $DATETO = $valus["va_end_date"];
                            $s .=
                                "<tr ><td style='width: 11%;'><span class='date_history" .
                                $TRANSPORTER .
                                $valus["id_client"] .
                                $valus["va_id"] .
                                "'></span><br><span style='color: #2777bb;'>A:" .
                                ($DATEFORM
                                    ? date("d-m-Y", strtotime($DATEFORM))
                                    : "-") .
                                "</span><br>D:" .
                                ($DATETO
                                    ? date("d-m-Y", strtotime($DATETO))
                                    : "-") .
                                "</td>";
                        }
                    }

                    $s .=
                        "<td style='width:65px;'>" .
                        ($t == 0 ? $valus["no_of_days"] : "") .
                        "</td>";

                    $select_transporter1 = $this->pdo->prepare(
                        "SELECT * FROM ps_transporter where t_id=" .
                            $TRANSPORTER .
                            ""
                    );
                    $select_transporter1->execute();
                    $select_transporter1 = $select_transporter1->fetchAll(
                        PDO::FETCH_ASSOC
                    );

                    if ($privilege_query[0]["vendor"] == 0) {
                        $s .=
                            "<td style='width:13%;'>" .
                            (isset($select_transporter1[0]["transporter_name"])
                                ? $select_transporter1[0]["transporter_name"]
                                : "-") .
                            "</td>";
                        $check_trip_status = "";
                    } else {
                        $check_trip_status = "and va_h.trip_went_not!=2";
                    }
                    $s .= "<td><table style='width:100%;' >
                              <tbody><tr>";
                    // if($privilege_query)

                    $vehicle_his = $this->pdo->prepare(
                        "SELECT va_h.trip_went_not, va_h.va_start_date as his_start,va_h.va_end_date as his_end,dr.contact_no as his_contact_no,v.vehicle_no as his_vehicle_no,b.vehicle_type_name as his_vehicle,dr.driver_name as his_driver,va_h.remarks as his_remarks from ps_vehicle_allotment_history va_h left join ps_vehicles v on(v.v_id =va_h.va_vehicle_id ) left join ps_vehicletypes as b on b.vt_id=v.vehicle_type left join ps_driver as dr on (dr.id_driver = va_h.va_driver_id) where va_h.id_history=" .
                            $valus["va_id"] .
                            " and va_h.client_table_id=" .
                            $valus["client_table_id"] .
                            "  " .
                            $check_trip_status .
                            ""
                    );
                    $vehicle_his->execute();
                    $vehicle_his = $vehicle_his->fetchAll(PDO::FETCH_ASSOC);

                    if ($vehicle_his) {
                        $date_append = "";
                        foreach ($vehicle_his as $key => $list) {
                            if ($list["trip_went_not"] == 2) {
                                //$date_append.='<span style="color: #2777bb;"> A:'.date('d-m-Y',strtotime($list['his_start'])).'</span><br><span>D:'.date('d-m-Y',strtotime($list['his_end'])).'(Trip Not Went)</span><br>';
                                $date_append .=
                                    '<span style="color: #2777bb;">Trip Not Went</span><br>';
                            } else {
                                $date_append .=
                                    '<span style="color: #2777bb;"> A:' .
                                    date(
                                        "d-m-Y",
                                        strtotime($list["his_start"])
                                    ) .
                                    "</span><br><span>D:" .
                                    date("d-m-Y", strtotime($list["his_end"])) .
                                    "</span><br>";
                            }

                            $s .= "<tr>";
                            $s .=
                                "<td style='width:10%;padding: 0px 0px;'>" .
                                (isset($list["his_vehicle"])
                                    ? $list["his_vehicle"]
                                    : "-") .
                                "</td>";
                            if ($privilege_query[0]["vendor"] == 0) {
                                $s .= "<td style='width:10%;'>  </td>";
                            }
                            // $s.="<td style='width:20%;'>   </td>";
                            $s .=
                                "<td style='width:10%;'><div class='show_query' >" .
                                (isset($list["his_driver"])
                                    ? $list["his_driver"]
                                    : "-") .
                                "<div  class='show_me'>Mobile No:" .
                                ($list["his_contact_no"]
                                    ? $list["his_contact_no"]
                                    : "Nil") .
                                "<br>Vehicle :" .
                                ($list["his_vehicle"]
                                    ? $list["his_vehicle"]
                                    : "Nil") .
                                " <br>Vehicle no :" .
                                ($list["his_vehicle_no"]
                                    ? $list["his_vehicle_no"]
                                    : "Nil") .
                                "</div></div></td>";
                            $s .= "<td style='width:10%;'>    </td>";
                            $s .= "<td style='width:10%;'>    </td>";
                            $s .=
                                "<td style='width:10%;'>" .
                                (isset($list["his_remarks"])
                                    ? "<div class='show_query'><p> Remark<div class='show_me'>" .
                                    $list["his_remarks"] .
                                    "</div></p></div>"
                                    : "-") .
                                "</td>";
                            $s .= "</tr>";
                        }

                        $s .=
                            "<script>$('.date_history" .
                            $TRANSPORTER .
                            $valus["id_client"] .
                            $valus["va_id"] .
                            "').html('" .
                            $date_append .
                            "')</script>";
                    } else {
                        $input = "     ";
                        $s .= "<tr>";
                        $s .= "<td style='width:10%;'>       </td>";
                        if ($privilege_query[0]["vendor"] == 0) {
                            $s .= "<td style='width:10%;'>    </td>";
                        }
                        // $s.="<td style='width:20%;'>       </td>";
                        $s .= "<td style='width:10%;'>      </td>";
                        $s .= "<td style='width:10%;'>    </td>";
                        $s .= "<td style='width:10%;'>     </td>";
                        $s .=
                            "<td style='width:10%;color:rgba(0,0,0,0);'>remark</td>";
                        $s .= "</tr>";
                    }

                    $s .= "</tr>";
                    $s .= "<tr>";

                    $cartype = $this->pdo->prepare(
                        "SELECT b.vehicle_type_name,b.vt_id from   ps_vehicletypes as b  where b.vt_id=" .
                            $VEHICLE
                    );
                    $cartype->execute();
                    $cartype = $cartype->fetchAll(PDO::FETCH_ASSOC);
                    $s .=
                        "<td style='width:10%;'>" .
                        (isset($cartype[0]["vehicle_type_name"])
                            ? $cartype[0]["vehicle_type_name"]
                            : "-") .
                        "</td>";

                    if (
                        in_array($valus["id_client"], $client_id_val1) &&
                        $privilege_query[0]["vendor"] == 1 &&
                        $_SESSION["trans_vendor_id"] != $valus["transporter_id"]
                    ) {
                        $s .=
                            "<td style='width:5%;'>" .
                            ($t == 0 ? "-" : "") .
                            "</td>";

                        $s .=
                            "<td  style='width:10%;'><div class='show_query' >" .
                            ($valus["driver_name"]
                                ? $valus["driver_name"]
                                : "-") .
                            "<div  class='show_me'>Mobile No:" .
                            ($valus["contact_no"]
                                ? $valus["contact_no"]
                                : "Nil") .
                            "<br>Vehicle :" .
                            ($cartype[0]["vehicle_type_name"]
                                ? $cartype[0]["vehicle_type_name"]
                                : "Nil") .
                            " <br>Vehicle no :" .
                            ($valus["vehicle_no"]
                                ? $valus["vehicle_no"]
                                : "Nil") .
                            "</div></div></td>";
                        $s .= "<td style='width:10%;'>-</td>";
                    } else {
                        if ($privilege_query[0]["vendor"] == 0) {
                            if ($valus["vehical_note"] != "") {
                                $s .=
                                    "<td style='width:10%;'>" .
                                    ($t == 0
                                        ? '<button  type="button" class=" dialogs" data-toggle="modal" onclick="Itinerary_modal(' .
                                        $valus["id_client"] .
                                        ',1);" ><img src="./assets/details.png" height="20" width="20" ></button>'
                                        : "") .
                                    "</td>";
                            } else {
                                $s .=
                                    "<td style='width:10%;'>" .
                                    ($t == 0 ? "-" : "") .
                                    "</td>";
                            }
                        }

                        $s .=
                            "<td style='width: 15px;%;' ><div class='show_query' >" .
                            ($valus["driver_name"]
                                ? $valus["driver_name"]
                                : "-") .
                            "<div  class='show_me'>Mobile No:" .
                            ($valus["contact_no"]
                                ? $valus["contact_no"]
                                : "Nil") .
                            "<br>Vehicle :" .
                            ($cartype[0]["vehicle_type_name"]
                                ? $cartype[0]["vehicle_type_name"]
                                : "Nil") .
                            " <br>Vehicle no :" .
                            ($valus["vehicle_no"]
                                ? $valus["vehicle_no"]
                                : "Nil") .
                            "</div></div>";
                        if (
                            $privilege_query[0]["vendor"] == 0 &&
                            $TRANSPORTER_va_id ==
                            $select_last_trans[0]["va_id"] &&
                            $valus["driver_name"] != ""
                        ) {
                            $s .=
                                "<button  type='button' class='driver_sms raz btn' data-toggle='modal' onclick='driver_sms_modal(" .
                                $valus["id_client"] .
                                "," .
                                $valus["va_id"] .
                                ")'><strong>SMS</strong></button>";
                        }
                        $s .= "</td>";

                        $s .= "<td style='width:10%;'>";
                        if (
                            $privilege_query[0]["vendor"] == 0 &&
                            $TRANSPORTER_va_id ==
                            $select_last_trans[0]["va_id"] &&
                            $valus["driver_name"] != ""
                        ) {
                            $s .=
                                "<button type='button' class='mailee' data-toggle='modal' onclick='javascript:return export_mail_modal(" .
                                $valus["id_client"] .
                                ",\"" .
                                $select_transporter1[0]["email"] .
                                "\",\"" .
                                $DATEFORM .
                                "\"," .
                                $privilege_query[0]["vendor"] .
                                ")'><strong><i class='fa fa-envelope'></i></strong></button>";
                        }
                        // if (
                        //     $TRANSPORTER_va_id ==
                        //         $select_last_trans[0]["va_id"] &&
                        //     $valus["driver_name"] != ""
                        // ) {
                        $s .=
                            "<button type='button' class='downloo btn btn-outline-primary ' onclick='download(\"" .
                            $actual_link .
                            "\"," .
                            $valus["id_client"] .
                            ",\"" .
                            $valus["driver_name"] .
                            "\",\"" .
                            $valus["contactalterno"] .
                            "\",\"" .
                            $valus["contact_no"] .
                            "\",\"" .
                            $cartype[0]["vehicle_type_name"] .
                            "\",\"" .
                            $valus["vehicle_no"] .
                            "\",0,\"" .
                            $DATEFORM .
                            "\"," .
                            $privilege_query[0]["vendor"] .
                            ")'><i class='fa fa-download' aria-hidden='true'></i></button>";
                        // }
                        $s .= "</td>";
                    }
                    $arr_trans = explode(",", $valus["rejected_vendors"]);
                    $arr_trans_remarks = explode(",", $valus["remarks"]);
                    $combine_value = array_combine(
                        $arr_trans,
                        $arr_trans_remarks
                    );

                    //&&$valus['transporter_id']!=$valus['t_id']

                    if (
                        isset($arr_trans_remarks[$keys]) &&
                        isset($combine_value[$valus["t_id"]]) &&
                        $valus["t_id"] != ""
                    ) {
                        $s .=
                            "<td style='width:10%;'><div class='show_query'><p>Remark  <div class='show_me'>" .
                            $arr_trans_remarks[$keys] .
                            "</div></p></div></td>";
                    } else {
                        $s .= "<td style='width:10%;'>-</td>";
                    }
                    $s .=
                        "<td style=' width:10% text-align: center !important;'>";

                    if ($valus["vehicle_remark"] != "") {
                        $s .=
                            "<div class='show_query'><p>  Remark<div class='show_me'>" .
                            $valus["vehicle_remark"] .
                            "<br>Date :" .
                            ($valus["update_d"] != "0000-00-00 00:00:00"
                                ? date(
                                    "d/m/Y h:i:s a",
                                    strtotime($valus["update_d"])
                                )
                                : date(
                                    "d/m/Y h:i:s a",
                                    strtotime($valus["vehicle_created_date"])
                                )) .
                            "</div></p></div></td>";
                    } else {
                        $s .= "-";
                    }

                    $s .= "</td>";

                    $s .= "</tr>";
                    $s .= "</tbody>";
                    $s .= "</table>";
                    $s .= "</td>";
                    $s .= "</tr>";
                }
                $t++;
            }

            $select_transporterssss = $this->pdo->prepare(
                "SELECT * FROM ps_transporter where t_id=" .
                    $valus["transporter_id"] .
                    ""
            );
            $select_transporterssss->execute();
            $select_transporterssss = $select_transporterssss->fetchAll(
                PDO::FETCH_ASSOC
            );

            if ($mobile == "false") {
                $s .= "</table></td>";
            }
            if ($valus["cancel_status"] == 1) {
                $s .=
                    "<td class='cancel_status' style='width:10%;vertical-align: bottom;'>";
            } elseif ($valus["arrivedornot"] == 1) {
                $s .= "<td  style='width:10%;vertical-align: bottom;'>";
            } else {
                $s .= "<td style='width:10%;vertical-align: bottom;'>";
            }
            if ($valus["trip_completed"] == 1) {
                $disabled_trip = "class='isDisabled'";
            } else {
                $disabled_trip = "";
            }
            if (
                date("Y-m-d") == $valus["end_to"] &&
                $valus["cancel_status"] != 1 &&
                $valus["arrivedornot"] != 1 &&
                $valus["va_id"] != ""
            ) {
                if (
                    $privilege_query[0]["vendor"] == 0 ||
                    ($privilege_query[0]["vendor"] == 1 &&
                        $_SESSION["trans_vendor_id"] ==
                        $valus["transporter_id"])
                ) {
                    $s .=
                        "<a " .
                        $disabled_trip .
                        " href='javascript:void(0)' title='Trip Completed' onclick='trip_completed(\"" .
                        $valus["id_client"] .
                        "\",\"" .
                        $valus["va_id"] .
                        "\")'; style='background: red;' class='allot_button'>Trip Completed</a><br>";
                }
            }

            if ($permission["edit"] == 1) {
                $TRANSPORTER = $valus["va_transporter_id"];
                $TRANSPORTER_va_id = $valus["va_id"];
                if (
                    $valus["va_driver_id"] == "" ||
                    $valus["va_driver_id"] == 0
                ) {
                    $VEHICLE = $valus["vehicle_type"];
                    $DATEFORM = $valus["start_from"];
                    $DATETO = $valus["end_to"];
                } else {
                    $VEHICLE = $valus["d_vehicle_type"];
                    $DATEFORM = $valus["va_start_date"];
                    $DATETO = $valus["va_end_date"];
                }
                $cartype = $this->pdo->prepare(
                    "SELECT b.vehicle_type_name,b.vt_id from   ps_vehicletypes as b  where b.vt_id=" .
                        $VEHICLE
                );
                $cartype->execute();
                $cartype = $cartype->fetchAll(PDO::FETCH_ASSOC);

                $ff .=
                    "<script>$('#itinerary_down" .
                    $valus["id_client"] .
                    "').html('<button type=\'button\' class=\'downloo\ btn btn-outline-primary  ' onclick=\"download(\'" .
                    $actual_link .
                    "\'," .
                    $valus["id_client"] .
                    ",\'" .
                    $valus["driver_name"] .
                    "\',\'" .
                    $valus["contactalterno"] .
                    "\',\'" .
                    $valus["contact_no"] .
                    "\',\'" .
                    $cartype[0]["vehicle_type_name"] .
                    "\',\'" .
                    $valus["vehicle_no"] .
                    "\',0,\'" .
                    $DATEFORM .
                    "\'," .
                    $privilege_query[0]["vendor"] .
                    ")\"><i class=\'fa fa-download\' aria-hidden=\'true\'></i></button>');</script>";

                if ($valus["cancel_status"] == 1) {
                    $disabled = "class='isDisabled'";
                } elseif ($valus["arrivedornot"] == 1) {
                    $disabled = "class='isDisabled'";
                } else {
                    $disabled = "";
                }

                if (
                    $valus["va_driver_id"] != 0 &&
                    $valus["va_vehicle_id"] != 0 &&
                    $valus["id_client"] == $valus["client_table_id"]
                ) {
                    // if($t+1 == $c)
                    // {
                    if (
                        in_array($valus["id_client"], $client_id_val1) &&
                        $privilege_query[0]["vendor"] == 1 &&
                        $_SESSION["trans_vendor_id"] != $valus["transporter_id"]
                    ) {
                        //$s.="jhgjhgjj";

                        $s .= "<br>";
                    } else {
                        if ($privilege_query[0]["vendor"] == 1) {
                            $kjhfsdf = "transporter";
                        } else {
                            $kjhfsdf = "vendor";
                        }

                        if (
                            $valus["cancel_status"] == 0 &&
                            $valus["arrivedornot"] == 0 &&
                            $TRANSPORTER_va_id == $select_last_trans[0]["va_id"]
                        ) {
                            $ff .=
                                "<span class='cllr'><a  " .
                                $disabled .
                                " href='javascript:void(0)' title='Modify vehicle' onclick='allotment(\"" .
                                $valus["start_from"] .
                                "\",\"" .
                                $valus["end_to"] .
                                "\",\"" .
                                $valus["id_client"] .
                                "\",\"" .
                                $valus["transporter_id"] .
                                "\",\"" .
                                $valus["va_id"] .
                                "\",\"" .
                                $valus["va_start_date"] .
                                "\",\"" .
                                $valus["va_end_date"] .
                                "\",\"" .
                                $valus["client_arrival"] .
                                "\",\"" .
                                $VEHICLE .
                                "\",\"" .
                                $kjhfsdf .
                                "\",\"" .
                                $valus["client_departure"] .
                                "\",\"" .
                                $valus["client_arrival_name"] .
                                "\",\"" .
                                $valus["va_vehicle_id"] .
                                "\",\"" .
                                $valus["va_driver_id"] .
                                "\",\"" .
                                $valus["status_datechanged"] .
                                "\",\"" .
                                $old_transporter_date .
                                "\",0)'; style='background: linear-gradient(to bottom, #2196F3 19%, #078ac6 56%);' class='allot_button'>Modify</a></span>";
                            $s .=
                                "<span class='cllr'><a " .
                                $disabled .
                                " href='javascript:void(0)' title='Modify vehicle' onclick='allotment(\"" .
                                $valus["start_from"] .
                                "\",\"" .
                                $valus["end_to"] .
                                "\",\"" .
                                $valus["id_client"] .
                                "\",\"" .
                                $valus["transporter_id"] .
                                "\",\"" .
                                $valus["va_id"] .
                                "\",\"" .
                                $valus["va_start_date"] .
                                "\",\"" .
                                $valus["va_end_date"] .
                                "\",\"" .
                                $valus["client_arrival"] .
                                "\",\"" .
                                $VEHICLE .
                                "\",\"" .
                                $kjhfsdf .
                                "\",\"" .
                                $valus["client_departure"] .
                                "\",\"" .
                                $valus["client_arrival_name"] .
                                "\",\"" .
                                $valus["va_vehicle_id"] .
                                "\",\"" .
                                $valus["va_driver_id"] .
                                "\",\"" .
                                $valus["status_datechanged"] .
                                "\",\"" .
                                $old_transporter_date .
                                "\",0)'; style='background: linear-gradient(to bottom, #8fd83a 19%, #8BC34D 56%);' class='allot_button'>Modify</a></span>";
                        }
                    }
                } elseif (
                    $valus["va_transporter_id"] != "" &&
                    in_array($valus["va_transporter_id"], $arr_tranfffs)
                ) {
                    $s .= "<br>";
                }
                ///
                else {
                    if (
                        in_array($valus["id_client"], $client_id_val1) &&
                        $privilege_query[0]["vendor"] == 1 &&
                        $_SESSION["trans_vendor_id"] != $valus["transporter_id"]
                    ) {
                        $s .= "<br>";
                    } else {
                        if ($privilege_query[0]["vendor"] == 1) {
                            $kjhfsdf = "transporter";
                        } else {
                            $kjhfsdf = "vendor";
                        }
                        if (
                            $permission["edit"] == 1 &&
                            $select_transporterssss[0]["t_id"] != "" &&
                            $TRANSPORTER_va_id == $select_last_trans[0]["va_id"]
                        ) {
                            if (
                                $valus["cancel_status"] == 0 &&
                                $valus["arrivedornot"] == 0
                            ) {
                                $ff .=
                                    "<a " .
                                    $disabled .
                                    " href='javascript:void(0)' title='Add vehicle' onclick='allotment(\"" .
                                    $valus["start_from"] .
                                    "\",\"" .
                                    $valus["end_to"] .
                                    "\",\"" .
                                    $valus["id_client"] .
                                    "\",\"" .
                                    $select_transporterssss[0]["t_id"] .
                                    "\",\"" .
                                    $valus["va_id"] .
                                    "\",\"" .
                                    $valus["start_from"] .
                                    "\",\"" .
                                    $valus["end_to"] .
                                    "\",\"" .
                                    $valus["client_arrival"] .
                                    "\",\"" .
                                    $VEHICLE .
                                    "\",\"" .
                                    $kjhfsdf .
                                    "\",\"" .
                                    $valus["client_departure"] .
                                    "\",\"" .
                                    $valus["client_arrival_name"] .
                                    "\",\"" .
                                    $valus["va_vehicle_id"] .
                                    "\",\"" .
                                    $valus["va_driver_id"] .
                                    "\",\"" .
                                    $valus["status_datechanged"] .
                                    "\",\"" .
                                    $old_transporter_date .
                                    "\",0)' style='background: linear-gradient(to bottom, #8fd83a 19%, #8BC34D 56%);' class='allot_button'>Allot</a>";
                                $s .=
                                    "<a " .
                                    $disabled .
                                    " href='javascript:void(0)' title='Add vehicle' onclick='allotment(\"" .
                                    $valus["start_from"] .
                                    "\",\"" .
                                    $valus["end_to"] .
                                    "\",\"" .
                                    $valus["id_client"] .
                                    "\",\"" .
                                    $select_transporterssss[0]["t_id"] .
                                    "\",\"" .
                                    $valus["va_id"] .
                                    "\",\"" .
                                    $valus["start_from"] .
                                    "\",\"" .
                                    $valus["end_to"] .
                                    "\",\"" .
                                    $valus["client_arrival"] .
                                    "\",\"" .
                                    $VEHICLE .
                                    "\",\"" .
                                    $kjhfsdf .
                                    "\",\"" .
                                    $valus["client_departure"] .
                                    "\",\"" .
                                    $valus["client_arrival_name"] .
                                    "\",\"" .
                                    $valus["va_vehicle_id"] .
                                    "\",\"" .
                                    $valus["va_driver_id"] .
                                    "\",\"" .
                                    $valus["status_datechanged"] .
                                    "\",\"" .
                                    $old_transporter_date .
                                    "\",0)' style='background: linear-gradient(to bottom, #8fd83a 19%, #8BC34D 56%);' class='allot_button'>Allot</a>";
                            }
                        }
                    }
                }
            }
            $s .= "</td>";

            $s .= "</tr>";
            $ff .= "</tr>";
            $i++;
        }
        if ($mobile == "true") {
            $ff .= "</td>";
        }

        return [
            "mobile" => $mobile,
            "content" => $mobile == "true" ? $ff : $s,
            "searchFrom" => isset($GetDatas["min-date"])
                ? $GetDatas["min-date"]
                : "",
            "searchTo" => isset($GetDatas["max-date"])
                ? $GetDatas["max-date"]
                : "",
            "searchType" => isset($GetDatas["type"]) ? $GetDatas["type"] : "",
        ];
    }
    public function Allotmentvehicle($GetDatas)
    {
        $new_date = $END_DATE = "";
        $todayDateTime = date('Y-m-d H:i:s');
        $DATE_FROM = str_replace("/", "-", $GetDatas['start_date']);
        $DATE_TO = str_replace("/", "-", $GetDatas['end_date']);

        $start_date = date('Y-m-d', strtotime($DATE_FROM));
        $end_date = date('Y-m-d', strtotime($DATE_TO));

        $tab_id = 266;
        $res = $ress = '';
        if ($GetDatas['test'] == 0 && $GetDatas['statusss'] != 1) {

            $res = $this->pdo->prepare("UPDATE ps_vehicle_allotment SET client_table_id = :client_table_id, va_start_date = :va_start_date, va_end_date=:va_end_date, va_transporter_id=:va_transporter_id,va_driver_id=:va_driver_id,va_vehicle_id=:va_vehicle_id,employee_id=:employee_id,tab_id=:tab_id WHERE va_id = :va_id");

            $res->bindParam(':client_table_id', $GetDatas['client_id']);
            $res->bindParam(':va_start_date', $start_date);
            $res->bindParam(':va_end_date', $end_date);
            $res->bindParam(':va_transporter_id', $GetDatas['trans_id']);
            $res->bindParam(':va_driver_id', $GetDatas['driver_id']);
            $res->bindParam(':va_vehicle_id', $GetDatas['vehicle_id']);
            $res->bindParam(':employee_id', $_SESSION['user_id']);
            $res->bindParam(':tab_id', $tab_id);
            $res->bindParam(':va_id', $GetDatas['va_id']);

            $res->execute();
        } else if ($GetDatas['test'] == 1 || $GetDatas['statusss'] == 1) {


            $select = $this->pdo->prepare('SELECT * from ps_vehicle_allotment where va_id=' . $GetDatas['va_id']);
            $select->execute();
            $select = $select->fetchAll(PDO::FETCH_ASSOC);

            if ($select[0]['va_start_date'] < $start_date) {

                $trip_status = 1;
                $ENDDATE = date('Y-m-d', strtotime($start_date . "-1 day"));
            } else {

                $trip_status = 2;
                $ENDDATE = $select[0]['va_end_date'];
            }

            if (isset($GetDatas['driver_id']) && $GetDatas['driver_id'] != "" && $GetDatas['driver_id'] != 0 && isset($GetDatas['vehicle_id']) && $GetDatas['vehicle_id'] != "" && $GetDatas['vehicle_id'] != 0) {

                $ress = $this->pdo->prepare('UPDATE ps_vehicle_allotment SET client_table_id=:client_table_id,va_start_date=:va_start_date,va_end_date=:va_end_date,va_transporter_id=:va_transporter_id,updated_date=:updated_date,employee_id=:employee_id,tab_id=:tab_id,status=:status,trip_went_not=:trip_went_not,va_driver_id=:va_driver_id,va_vehicle_id=:va_vehicle_id WHERE va_id=:va_id');
                $status = 0;
                $trip_went_not = 0;
                $ress->bindParam(':client_table_id', $GetDatas['client_id']);
                $ress->bindParam(':va_start_date', $start_date);
                $ress->bindParam(':va_end_date', $end_date);
                $ress->bindParam(':va_transporter_id', $GetDatas['trans_id']);
                $ress->bindParam(':updated_date', $todayDateTime);
                $ress->bindParam(':tab_id', $tab_id);
                $ress->bindParam(':employee_id', $_SESSION['user_id']);
                $ress->bindParam(':status', $status);
                $ress->bindParam(':trip_went_not', $trip_went_not);
                $ress->bindParam(':va_driver_id', $GetDatas['driver_id']);
                $ress->bindParam(':va_vehicle_id', $GetDatas['vehicle_id']);
                $ress->bindParam(':va_id', $GetDatas['va_id']);
                $ress->execute();
            } elseif (isset($GetDatas['driver_id']) && $GetDatas['driver_id'] != "" && $GetDatas['driver_id'] != 0) {

                $ress = $this->pdo->prepare('UPDATE ps_vehicle_allotment SET client_table_id=:client_table_id,va_start_date=:va_start_date,va_end_date=:va_end_date,va_transporter_id=:va_transporter_id,updated_date=:updated_date,employee_id=:employee_id,tab_id=:tab_id,status=:status,trip_went_not=:trip_went_not,va_driver_id=:va_driver_id WHERE va_id=:va_id');
                $status = 0;
                $trip_went_not = 0;
                $ress->bindParam(':client_table_id', $GetDatas['client_id']);
                $ress->bindParam(':va_start_date', $start_date);
                $ress->bindParam(':va_end_date', $end_date);
                $ress->bindParam(':va_transporter_id', $GetDatas['trans_id']);
                $ress->bindParam(':updated_date', $todayDateTime);
                $ress->bindParam(':tab_id', $tab_id);
                $ress->bindParam(':status', $status);
                $ress->bindParam(':employee_id', $_SESSION['user_id']);
                $ress->bindParam(':trip_went_not', $trip_went_not);
                $ress->bindParam(':va_driver_id', $GetDatas['driver_id']);
                $ress->bindParam(':va_id', $GetDatas['va_id']);
                $ress->execute();
            } elseif (isset($GetDatas['vehicle_id']) && $GetDatas['vehicle_id'] != "" && $GetDatas['vehicle_id'] != 0) {

                $ress = $this->pdo->prepare('UPDATE ps_vehicle_allotment SET client_table_id=:client_table_id,va_start_date=:va_start_date,va_end_date=:va_end_date,va_transporter_id=:va_transporter_id,updated_date=:updated_date,employee_id=:employee_id,tab_id=:tab_id,status=:status,trip_went_not=:trip_went_not,va_vehicle_id=:va_vehicle_id WHERE va_id=:va_id');
                $status = 0;
                $trip_went_not = 0;
                $ress->bindParam(':client_table_id', $GetDatas['client_id']);
                $ress->bindParam(':va_start_date', $start_date);
                $ress->bindParam(':va_end_date', $end_date);
                $ress->bindParam(':va_transporter_id', $GetDatas['trans_id']);
                $ress->bindParam(':updated_date', $todayDateTime);
                $ress->bindParam(':tab_id', $tab_id);
                $ress->bindParam(':status', $status);
                $ress->bindParam(':employee_id', $_SESSION['user_id']);
                $ress->bindParam(':trip_went_not', $trip_went_not);
                $ress->bindParam(':va_vehicle_id', $GetDatas['vehicle_id']);
                $ress->bindParam(':va_id', $GetDatas['va_id']);
                $ress->execute();
            }




            if ($GetDatas['statusss'] == 1) {
                $resssss = $this->pdo->prepare("UPDATE ps_client set status_datechanged=:status_datechanged where id_client=:id_client");
                $status_datechanged = 0;
                $resssss->bindParam(':status_datechanged', $status_datechanged, PDO::PARAM_STR);
                $resssss->bindParam(':id_client', $GetDatas['client_id'], PDO::PARAM_INT);
                $resssss->execute();
            }
            if ($GetDatas['statusss'] != 1) {

                $res = $this->pdo->prepare('INSERT INTO ps_vehicle_allotment_history (client_table_id,va_start_date,va_end_date,va_transporter_id,va_driver_id,va_vehicle_id,remarks,create_date,trip_went_not,id_history) VALUES(:client_table_id,:va_start_date,:va_end_date,:va_transporter_id,:va_driver_id,:va_vehicle_id,:remarks,:create_date,:trip_went_not,:id_history)');

                $remarks = $GetDatas['remarks'] . ' ,changed Date :' . date('Y-m-d H:i:s');
                $res->bindParam(':client_table_id', $select[0]['client_table_id']);
                $res->bindParam(':va_start_date', $select[0]['va_start_date']);
                $res->bindParam(':va_end_date', $ENDDATE);
                $res->bindParam(':va_transporter_id', $select[0]['va_transporter_id']);
                $res->bindParam(':va_driver_id', $select[0]['va_driver_id']);
                $res->bindParam(':va_vehicle_id', $select[0]['va_vehicle_id']);
                $res->bindParam(':remarks', $remarks);
                $res->bindParam(':create_date', $todayDateTime);
                $res->bindParam(':trip_went_not', $trip_status);
                $res->bindParam(':id_history', $GetDatas['va_id']);

                $res->execute();
            }

            // $fetech_details_driver=$this->pdo->prepare("select driver_name from ps_driver where id_driver=".$GetDatas['driver_id']."");
            //      $fetech_details_driver->execute();
            //      $fetech_details_driver = $fetech_details_driver->fetchAll(PDO::FETCH_ASSOC);
            // $fetech_details_vehicle=$this->pdo->prepare("select vehicle_no from ps_vehicles where v_id=".$GetDatas['vehicle_id']."");
            //      $fetech_details_vehicle->execute();
            //      $fetech_details_vehicle = $fetech_details_vehicle->fetchAll(PDO::FETCH_ASSOC);
            // $customer_arrival_id=$this->pdo->prepare("select client_arrival,ref_no from ps_client where id_client=".$GetDatas['client_id']."");
            //      $customer_arrival_id->execute();
            //      $customer_arrival_id = $customer_arrival_id->fetchAll(PDO::FETCH_ASSOC);



            // $datediff =  strtotime($start_date) - time();
            // $hours=round($datediff / (60 * 60 * 24));
            // if($ress&&$hours<=0){
            //   $transport_manager_no=transportmanagerSMS($customer_arrival_id[0]['client_arrival']);
            // $mesage =("Hi,".$privilege_query[0]['firstname']." have changed Driver:".$fetech_details_driver[0]['driver_name']." and Vehicle:".$fetech_details_vehicle[0]['vehicle_no']." for ".$customer_arrival_id[0]['ref_no']." ");
            // $smss=smsAPICall($transport_manager_no,$mesage);

            // }
        }

        if ($res || $ress) {
            echo 1;
        } else {
            echo 0;
        }

        exit;
    }

    public function allotment($GetDatas)
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            $mobile = 'true';
        } else {
            $mobile = 'false';
        }

        $allotdriver = $allotVehicle = [];
        $values = $valuesfdsf = array();
        $cont = $heading = $select_ve = $vehicle_categoryfsdf = $VEHICLE = $display = '';
        $id_client = $GetDatas['id_client'];
        $calltype = $GetDatas['calltype'];
        $trans_id = $GetDatas['trans_id'];
        $fromdate = $GetDatas['start_date'];
        $end_date = $GetDatas['end_date'];
        $fromdate_client = $GetDatas['start_date_client'];
        $end_date_client = $GetDatas['end_date_client'];
        $client_arrival = $GetDatas['client_arrival'];
        $vehicle_type_client = $GetDatas['vehicle_type_client'];
        $typeOFtransporter = $GetDatas['typeOFtransporter'];
        $client_departure = $GetDatas['client_departure'];
        $client_arrival_name = $GetDatas['client_arrival_name'];
        $va_id = $GetDatas['va_id'];
        $vehicle_table_id = $GetDatas['vehicle_table_id'];
        $driver_table_id = $GetDatas['driver_table_id'];
        $checked = $GetDatas['checked'];
        $searched_fromdate = $GetDatas['searched_fromdate'];
        $searched_todate = $GetDatas['searched_todate'];
        $REMARKS = $GetDatas['remarksss'];
        $statusss = $GetDatas['status'];
        $old_transporter_date = $GetDatas['old_transporter_date'];
        $check_reject_vendor = $this->pdo->prepare('SELECT rejected_vendors from ps_client where id_client=' . $id_client);
        $check_reject_vendor->execute();
        $check_reject_vendor = $check_reject_vendor->fetchAll(PDO::FETCH_ASSOC);
        $dirver_name_update = $this->pdo->prepare('SELECT driver_name from ps_driver where id_driver=' . $driver_table_id);
        $dirver_name_update->execute();
        $dirver_name_update = $dirver_name_update->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($dirver_name_update) && $dirver_name_update[0]['driver_name']) {
            $dirver_name_update[0]['driver_name'] = $dirver_name_update[0]['driver_name'];
        } else {
            $dirver_name_update[0]['driver_name'] = '';
        }
        if (!$REMARKS) {
            $REMARKS = 0;
        }
        $searched_fromdate = str_replace("/", "-", $searched_fromdate);
        $searched_todate = str_replace("/", "-", $searched_todate);


        if ($searched_fromdate != 'false') {
            $start_date_list = date('Y-m-d', strtotime($searched_fromdate));
            $end_date_list = date('Y-m-d', strtotime($searched_todate));
        } else {
            if ($checked == 1 || $checked == 2 || $checked == 3) {
                $start_date_list = $fromdate;
                $end_date_list = $end_date;
            } elseif ($statusss == 1) {
                $start_date_list = $fromdate_client;
                $end_date_list = $end_date_client;
            } elseif (($vehicle_table_id == 0 && !empty($check_reject_vendor[0]['rejected_vendors']))) {

                $start_date_list = $old_transporter_date;
                $end_date_list = $end_date_client;
            } else {

                $start_date_list = $fromdate;
                $end_date_list = $end_date;
            }
        }


        $privilege_query = $this->pdo->prepare('select * from ps_employee as a left join ps_privilege as b on a.pri_id=b.pri_id where a.active=1 and a.id_employee=' . $_SESSION['user_id'] . '');
        $privilege_query->execute();
        $privilege_query = $privilege_query->fetchAll(PDO::FETCH_ASSOC);

        $client_vehicle = $this->pdo->prepare('SELECT v.vehicle_category from ps_client as c left join ps_vehicletypes as v on (c.vehicle_type=v.vt_id) where id_client=' . $id_client);
        $client_vehicle->execute();
        $client_vehicle = $client_vehicle->fetchAll(PDO::FETCH_ASSOC);
        $select_ve1 = $this->pdo->prepare('SELECT vt_id,vehicle_type_name FROM ps_vehicletypes where vehicle_category="' . $client_vehicle[0]['vehicle_category'] . '" and status=0');
        $select_ve1->execute();
        $select_ve1 = $select_ve1->fetchAll(PDO::FETCH_ASSOC);

        $select_ve2 = $this->pdo->prepare('SELECT vt_id,vehicle_type_name FROM ps_vehicletypes where vehicle_category=(select vehicle_category from ps_vehicletypes where vt_id=' . $vehicle_type_client . ') and status=0');
        $select_ve2->execute();
        $select_ve2 = $select_ve2->fetchAll(PDO::FETCH_ASSOC);

        $select_ve = array_unique(array_merge($select_ve1, $select_ve2), SORT_REGULAR);

        foreach ($select_ve as $pvalue) {

            $values[] = $pvalue['vt_id'];
            $valuesfdsf[$pvalue['vt_id']] = $pvalue['vehicle_type_name'];
        }
        $vehicle_categoryfsdf = implode(',', $values);


        if ($typeOFtransporter == 'vendor') {

            $can_allot_vehicle = $this->pdo->prepare('SELECT  tr.trans_vendors ,tr.transporter_name as transporter_name_v,tr.reference_no as transporter_ref_no,ps_vehicletypes.vehicle_type_name as vehicle_type_client,ps_client.id_client, v.vehicle_no,v.v_id,v.blocked FROM  ps_client left join ps_vehicles as v  ON (ps_client.transporter_id=v.transporter_id)  left join ps_transporter as tr on tr.t_id=v.transporter_id left join ps_vehicletypes on ps_vehicletypes.vt_id=v.vehicle_type where v.status not in (1,3,6)  and v.transporter_id=' . $trans_id . ' and v.vehicle_type in (' . $vehicle_categoryfsdf . ')  and v.blocked=0 and tr.status=0 and tr.blocked=0 and ps_client.id_client=' . $id_client . '  and v.v_id!="' . $vehicle_table_id . '"');
            $can_allot_vehicle->execute();
            $can_allot_vehicle = $can_allot_vehicle->fetchAll(PDO::FETCH_ASSOC);


            if ($vehicle_table_id == 0 || $statusss == 1) {
                $where1 = 1;
                $where = 1;
            } else {
                $where1 = 'v.v_id!=' . $vehicle_table_id . '';
                $where = 'dr.id_driver!=' . $driver_table_id . '';
            }

            $can_allot_driver = $this->pdo->prepare('SELECT dr.id_driver,dr.blocked,dr.driver_name,dr.contact_no as driver_contact_no,tr.trans_vendors ,tr.transporter_name as transporter_name_v,tr.reference_no as transporter_ref_no,ps_client.id_client FROM ps_client LEFT JOIN ps_driver as dr   ON (ps_client.transporter_id=dr.transporter_id)  left join ps_transporter as tr on tr.t_id=dr.transporter_id  where dr.status not in (1,3,6)  and dr.transporter_id=' . $trans_id . '  and dr.blocked=0 and tr.status=0 and tr.blocked=0 and ps_client.id_client=' . $id_client . ' and dr.id_driver!="' . $driver_table_id . '"');

            $can_allot_driver->execute();
            $can_allot_driver = $can_allot_driver->fetchAll(PDO::FETCH_ASSOC);

            $can_allot_value_vehicle = $this->pdo->prepare('SELECT va.va_vehicle_id FROM ps_vehicles as v left join ps_vehicle_allotment as va on(v.v_id=va.va_vehicle_id ) left join ps_client on (va.client_table_id=ps_client.id_client) where v.status=0 and (("' . $start_date_list . '"  BETWEEN va.va_start_date AND va.va_end_date) or ("' . $end_date_list . '" BETWEEN va.va_start_date AND va.va_end_date ))  and va.va_transporter_id="' . $trans_id . '" and ' . $where1 . ' and va.trip_went_not in(0,1) and ps_client.cancel_status=0 and ps_client.status=0 and ps_client.arrivedornot=0 and va.trip_completed!=1');

            $can_allot_value_vehicle->execute();
            $can_allot_value_vehicle = $can_allot_value_vehicle->fetchAll(PDO::FETCH_ASSOC);

            $can_allot_value_vehicle_repeating = $this->pdo->prepare('SELECT GROUP_CONCAT(vehicles) as v_ids from (select GROUP_CONCAT(v.v_id) as vehicles FROM ps_vehicles v where v.status not in (1,6) and v.transporter_id=' . $trans_id . ' group by REPLACE(REPLACE(REPLACE(v.vehicle_no, " ", ""),",",""),"-","") Having COUNT(v.v_id) > 1) AA');
            $can_allot_value_vehicle_repeating->execute();
            $can_allot_value_vehicle_repeating = $can_allot_value_vehicle_repeating->fetchAll(PDO::FETCH_ASSOC);

            $own_driver_multi_rec = $this->pdo->prepare('SELECT count(v.v_id) as count FROM ps_vehicles v left join ps_transporter t on (v.transporter_id=t.t_id) where  v.transporter_id=' . $trans_id . '  and  v.status not in (1,6) and t.trans_vendors=0');
            $own_driver_multi_rec->execute();
            $own_driver_multi_rec = $own_driver_multi_rec->fetchAll(PDO::FETCH_ASSOC);

            $can_allot_value_driver = $this->pdo->prepare('SELECT va.va_driver_id FROM ps_driver as dr left join ps_vehicle_allotment as va on(dr.id_driver=va.va_driver_id ) left join ps_client on (va.client_table_id=ps_client.id_client)  where dr.status=0 and (("' . $start_date_list . '"  BETWEEN va.va_start_date AND va.va_end_date) or ("' . $end_date_list . '" BETWEEN va.va_start_date AND va.va_end_date ))  and ' . $where . ' and va.trip_went_not in(0,1) and ps_client.cancel_status=0 and ps_client.status=0 and ps_client.arrivedornot=0 and va.trip_completed!=1');
            $can_allot_value_driver->execute();
            $can_allot_value_driver = $can_allot_value_driver->fetchAll(PDO::FETCH_ASSOC);
        } else {

            $can_allot_vehicle = $this->pdo->prepare('SELECT  tr.trans_vendors ,tr.transporter_name as transporter_name_v,tr.reference_no as transporter_ref_no,ps_vehicletypes.vehicle_type_name as vehicle_type_client,ps_client.id_client, v.vehicle_no,v.v_id,v.blocked FROM  ps_client  LEFT JOIN ps_vehicles as v  ON (ps_client.transporter_id=v.transporter_id) left join ps_transporter as tr on tr.t_id=v.transporter_id left join ps_vehicletypes on ps_vehicletypes.vt_id=v.vehicle_type where v.status not in (1,3,6) and v.transporter_id=' . $trans_id . ' and v.vehicle_type in (' . $vehicle_categoryfsdf . ')   and v.blocked=0 and tr.status=0 and tr.blocked=0 and ps_client.id_client=' . $id_client . '  and v.v_id!="' . $vehicle_table_id . '"  and v.transporter_id=' . $privilege_query[0]['trans_vendor_id']);
            $can_allot_vehicle->execute();
            $can_allot_vehicle = $can_allot_vehicle->fetchAll(PDO::FETCH_ASSOC);

            if ($vehicle_table_id == 0 || $statusss == 1) {
                $where1 = 1;
                $where = 1;
            } else {
                $where1 = 'v.v_id!=' . $vehicle_table_id . '';
                $where = 'dr.id_driver!=' . $driver_table_id . '';
            }

            $can_allot_driver = $this->pdo->prepare('SELECT dr.id_driver,dr.blocked,dr.driver_name,dr.contact_no as driver_contact_no,tr.trans_vendors ,tr.transporter_name as transporter_name_v,tr.reference_no as transporter_ref_no,ps_client.id_client FROM ps_client LEFT JOIN ps_driver as dr ON (ps_client.transporter_id=dr.transporter_id)  left join ps_transporter as tr on tr.t_id=dr.transporter_id  where dr.status not in (1,3,6)  and dr.transporter_id=' . $trans_id . '  and dr.blocked=0 and tr.status=0 and tr.blocked=0 and ps_client.id_client=' . $id_client . ' and dr.id_driver!="' . $driver_table_id . '"  and dr.transporter_id=' . $privilege_query[0]['trans_vendor_id']);

            $can_allot_driver->execute();
            $can_allot_driver = $can_allot_driver->fetchAll(PDO::FETCH_ASSOC);


            $can_allot_value_vehicle = $this->pdo->prepare('SELECT va.va_vehicle_id FROM ps_vehicles as v left join ps_vehicle_allotment as va on(v.v_id=va.va_vehicle_id ) left join ps_client on (va.client_table_id=ps_client.id_client) where v.status=0 and (("' . $start_date_list . '"  BETWEEN va.va_start_date AND va.va_end_date) or ("' . $end_date_list . '" BETWEEN va.va_start_date AND va.va_end_date ))   and va.va_transporter_id="' . $trans_id . '" and ' . $where1 . ' and va.trip_went_not in(0,1) and ps_client.cancel_status=0 and ps_client.status=0 and ps_client.arrivedornot=0 and va.trip_completed!=1 and v.transporter_id=' . $privilege_query[0]['trans_vendor_id']);

            $can_allot_value_vehicle->execute();
            $can_allot_value_vehicle = $can_allot_value_vehicle->fetchAll(PDO::FETCH_ASSOC);

            $can_allot_value_vehicle_repeating = $this->pdo->prepare('SELECT GROUP_CONCAT(vehicles) as v_ids from (select GROUP_CONCAT(v.v_id) as vehicles FROM ps_vehicles v where v.status not in (1,6) and v.transporter_id=' . $privilege_query[0]['trans_vendor_id'] . ' group by REPLACE(REPLACE(REPLACE(v.vehicle_no, " ", ""),",",""),"-","") Having COUNT(v.v_id) > 1) AA');
            $can_allot_value_vehicle_repeating->execute();
            $can_allot_value_vehicle_repeating = $can_allot_value_vehicle_repeating->fetchAll(PDO::FETCH_ASSOC);
            $own_driver_multi_rec = $this->pdo->prepare('SELECT count(v.v_id) as count FROM ps_vehicles v left join ps_transporter t on (v.transporter_id=t.t_id) where  v.transporter_id=' . $privilege_query[0]['trans_vendor_id'] . '  and  v.status not in (1,6) and t.trans_vendors=0');
            $own_driver_multi_rec->execute();
            $own_driver_multi_rec = $own_driver_multi_rec->fetchAll(PDO::FETCH_ASSOC);



            $can_allot_value_driver = $this->pdo->prepare('SELECT va.va_driver_id FROM ps_driver as dr left join ps_vehicle_allotment as va on(dr.id_driver=va.va_driver_id ) left join ps_client on (va.client_table_id=ps_client.id_client) where dr.status=0 and (("' . $start_date_list . '"  BETWEEN va.va_start_date AND va.va_end_date) or ("' . $end_date_list . '" BETWEEN va.va_start_date AND va.va_end_date ))  and va.va_transporter_id="' . $trans_id . '" and ' . $where . ' and va.trip_went_not in(0,1) and ps_client.cancel_status=0 and ps_client.arrivedornot=0 and va.trip_completed!=1 and  dr.transporter_id=' . $privilege_query[0]['trans_vendor_id']);
            $can_allot_value_driver->execute();
            $can_allot_value_driver = $can_allot_value_driver->fetchAll(PDO::FETCH_ASSOC);
        }
        $vehicleAllotment = array('0' => $can_allot_vehicle, '1' => $can_allot_driver);

        $heading .= '<button type="button" class="close clst" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title text-center" id="myModalLabel">New Vehicle & Driver Assign</h4>
     <input type="hidden" id="hidden_type" value="' . $checked . '">';


        if ($checked == 1) {

            $cont .= '<script>
$("#que_div").css("display", "none");
$("#vehicle_div").css("display", "block");
$("#arrival_div").css("display", "inline");
$("#date_div").css("display", "block");
$("#final_submit").css("display", "block");
$(".allotmentmodel #myModalLabel").html("New Vehicle Assign");
initaatedatepicker("from_date_modify","end_date_modify",2);


</script>';
        } else if ($checked == 2) {

            $cont .= '<script>
$("#driver_div").css("display", "block");
$("#que_div").css("display", "none");
$("#arrival_div").css("display", "inline");
$("#date_div").css("display", "block");
$(".allotmentmodel #myModalLabel").html("New Driver Assign");
initaatedatepicker("from_date_modify","end_date_modify",2);

</script>';
        } else if ($checked == 3) {
            $cont .= '<script>
$("#arrival_div").css("display", "inline");
$("#date_div").css("display", "block");
$("#vehicle_div").css("display", "block");
$("#que_div").css("display", "none");
$("#next_driver").css("display", "block");
$(".allotmentmodel #myModalLabel").html("New Vehicle & Driver Assign");
$("#previous_driver").css("display", "block");
initaatedatepicker("from_date_modify","end_date_modify",2);
</script>';
        } elseif ($statusss == 1) {
            $cont .= '<script>initaatedatepicker("from_date12","end_date6",1);
     $("#date_div").css("display", "block");</script>';
        } elseif (($vehicle_table_id == 0 && !empty($check_reject_vendor[0]['rejected_vendors']))) {
            $cont .= '<script>initaatedatepicker("from_date1","end_date6",1);
     $("#date_div").css("display", "block");</script>';
        } else {
            $cont .= '<script>
	initaatedatepicker("from_date_modify","end_date_modify",2);

	</script>';
        }


        $checke = $checke2 = $checke3 = '';
        if ($checked == 1) {
            $checke = 'checked';
        }
        if ($checked == 2) {
            $checke2 = 'checked';
        }
        if ($checked == 3) {
            $checke3 = 'checked';
        }
        $cont .= '<input type="hidden"  name="remarks" id="remarks" value="' . $REMARKS . '">';
        if ($vehicle_table_id != 0 && $statusss != 1) {
            $cont .= '	<div id="que_div" style="text-align:center;">
           <p >DO YOU WANT TO MODIFY</p>
<div style="text-align:center;">
<input type="radio" id="allot_vehicle" name="allot_que" value="1" ' . $checke . '><label for="allot_vehicle">Vehicle Only</label>
<input type="radio" id="allot_driver" name="allot_que" value="2"  ' . $checke2 . '><label for="allot_driver">Driver Only</label>
<input type="radio" id="allot_both" name="allot_que" value="3" ' . $checke3 . '><label for="allot_both">Modify Both</label>
</div>';
            $cont .= '<div id="remark_div" style="display:none;margin-top:10px;"><lable>Reason For Modify</lable>
<input type="text" class="fancy_input remarks" name="remarks1" id="remarks1" value=" "></div>';
            $cont .= '<button style="float:right;"  id="next_action" name="next_action" class="btn btn-search" disabled >Next</button>
   </div>';
        }


        if ($vehicle_table_id != 0 && $statusss != 1) {
            $display = 'style="display:none;"';
            $display_s = 'style="float: right; display:none;"';
            $display_p = 'style="float: left ; display:none;"';
        } else {
            $display = 'style="display:inline;"';
            $display_s = 'style="float: right; display:block;"';
            $display_p = 'style="float: left ; display:block;"';
        }

        $cont .= '<span id="arrival_div" ' . $display . '>
       <label style="margin-left: 10px;">Client Arrival : </label> 
        <span >' . $client_arrival_name . '</span>
        <input type="hidden" id="span" value="0">
        
   		<label style="margin-left: 50px;">Vehicle Type : </label><span>';
        if (array_key_exists($vehicle_type_client, $valuesfdsf)) {
            $VEHICLE = $valuesfdsf[$vehicle_type_client];
        }
        $cont .= $VEHICLE . '</span></span>';



        // if($va_id==""&&$check_reject_vendor[0]['rejected_vendors']!=""){
        // 	$displaygdfg='style="display:block;float:right;"';

        // }
        // else{
        // 	$displaygdfg='style="display:none;float:right;"';

        // }
        if ($searched_fromdate != 'false') {
            $start_date_value = $searched_fromdate;
            $end_date_value = $searched_todate;
        } else {
            $start_date_value = '';
            $end_date_value = date('d/m/Y', strtotime($end_date));
        }
        $cont .= '<span id="date_div" style="display:none;" >
		     	<span class="col-sm-4 col-md-3">
		    <label>From</label>
   	
	        <input  type="text" readonly name="from_date4" id="from_date4" autocomplete="off" readonly value="' . $start_date_value . '"   onchange="allotment(\'' . $fromdate_client . '\',\'' . $end_date_client . '\',\'' . $id_client . '\',\'' . $trans_id . '\',\'' . $va_id . '\',\'' . $fromdate . '\',\'' . $end_date . '\',\'' . $client_arrival . '\',\'' . $vehicle_type_client . '\',\'' . $typeOFtransporter . '\',\'' . $client_departure . '\',\'' . $client_arrival_name . '\',\'' . $vehicle_table_id . '\',\'' . $driver_table_id . '\',\'' . $statusss . '\',\'' . $old_transporter_date . '\',document.getElementById(\'hidden_type\').value,this.value,document.getElementById(\'to_date4\').value,document.getElementById(\'remarks\').value);">
	        <input type="hidden" id="span" value="0">
	        <input  type="hidden"  name="from_date12" id="from_date12" value="' . date('d/m/Y', strtotime($fromdate_client)) . '" >
	        <input  type="hidden"  name="from_date1" id="from_date1" value="' . date('d/m/Y', strtotime($old_transporter_date)) . '" >
	           <input  type="hidden"  name="end_date6" id="end_date6" value="' . date('d/m/Y', strtotime($end_date_client)) . '" >
	            <input  type="hidden"  name="from_date_modify" id="from_date_modify" value="' . date('d/m/Y', strtotime($fromdate)) . '" >
	           <input  type="hidden"  name="end_date_modify" id="end_date_modify" value="' . date('d/m/Y', strtotime($end_date)) . '" ></span>
	           <span class="col-sm-4 col-md-3">
		      <label>To</label> <input type="text" readonly name="to_date4" id="to_date4" autocomplete="off" value="' . $end_date_value . '"  onchange="allotment(\'' . $fromdate_client . '\',\'' . $end_date_client . '\',\'' . $id_client . '\',\'' . $trans_id . '\',\'' . $va_id . '\',\'' . $fromdate . '\',\'' . $end_date . '\',\'' . $client_arrival . '\',\'' . $vehicle_type_client . '\',\'' . $typeOFtransporter . '\',\'' . $client_departure . '\',\'' . $client_arrival_name . '\',\'' . $vehicle_table_id . '\',\'' . $driver_table_id . '\',\'' . $statusss . '\',\'' . $old_transporter_date . '\',document.getElementById(\'hidden_type\').value,document.getElementById(\'from_date4\').value,this.value,document.getElementById(\'remarks\').value);">
		        <input type="hidden" id="span" value="0"></span>
		      </span> <div class="clearfix"></div>';



        $cont .= '<br>
			<div class="table-responsive clearfix vehicle_divss" id="vehicle_div" reer4 ' . $display . '>
			<table id="datallotment_value" class="table table-striped table-hover responsive datallotment" cellspacing="0" style="width:100% !important;">
			 <thead >
					<tr>';
        if ($privilege_query[0]['vendor'] == 0) {
            if ($mobile == 'true') {
                $cont .= '<th >S.no</th>
						    <th >Vehicle Type</th>
                          	<th >Vehicle No</th>
                          	<th >Choose</th>';
            } else {
                $cont .= '<th >S.no</th>
							<th >Vendor / Transporter</th>
							<th >Transporter Name</th>
						    <th >Transporter Id</th>
						    <th >Vehicle Type</th>
                          	<th >Vehicle No</th>
                            <th >Choose</th>';
            }
        } elseif ($privilege_query[0]['vendor'] == 1) {

            $cont .= '<th >S.no</th>
							<th >Type of Vehicle</th>
							<th >Vehicle No</th>
						    <th >Choose</th>';
        }
        $cont .= '</tr>
				</thead>
				<tbody>';

        foreach ($can_allot_value_vehicle as $allotlist) {
            $allotVehicle[] = $allotlist['va_vehicle_id'];
        }

        $i = 0;
        foreach ($vehicleAllotment[0] as $vehiclesvalues) {
            $i++;
            $cont .= '<tr ' . ((in_array($vehiclesvalues['v_id'], $allotVehicle) && $vehiclesvalues['blocked'] == 1) ? 'class="allot"' : '') . '>';
            //check own driver vehicle 
            if ($own_driver_multi_rec[0]['count'] > 1) {
                $cont .= 'Transporter Can\'t add more than one vehicle, so remove duplicates and keep only one valid vehicle record';
            } else {

                if ($privilege_query[0]['vendor'] == 0) {
                    if ($mobile == 'true') {
                        $cont .= '<td >' . $i . '</td>
						<td >' . $vehiclesvalues['vehicle_type_client'] . '</td>
						<td >' . $vehiclesvalues['vehicle_no'] . '</td>';
                    } else {
                        $cont .= '<td >' . $i . '</td>
						<td >' . (($vehiclesvalues['trans_vendors'] == 1) ? 'Vendor' : 'Transporter') . '</td>
						<td >' . $vehiclesvalues['transporter_name_v'] . '</td>
						<td >' . $vehiclesvalues['transporter_ref_no'] . '</td>
						<td >' . $vehiclesvalues['vehicle_type_client'] . '</td>
						<td >' . $vehiclesvalues['vehicle_no'] . '</td>';
                    }
                } elseif ($privilege_query[0]['vendor'] == 1) {

                    $cont .= '<td >' . $i . '</td>
						<td >' . $vehiclesvalues['vehicle_type_client'] . '</td>
						<td >' . $vehiclesvalues['vehicle_no'] . '</td>';
                }
                $cont .= '<td class="text-center">';
                if (isset($can_allot_value_vehicle_repeating[0]['v_ids'])) {
                    $ve = explode(",", $can_allot_value_vehicle_repeating[0]['v_ids']);
                }

                if ($vehicle_table_id == 0 || $statusss == 1) {
                    if (isset($ve) && in_array($vehiclesvalues['v_id'], $ve)) {
                        $cont .= '(   You can\'t Allot this Vehicle because this vehicle no is repaeting)';
                    } else {
                        $cont .= '<input type="checkbox" class="option-input checkbox" name="allocate" id="allocate' . $vehiclesvalues['v_id'] . '" value="' . $vehiclesvalues['v_id'] . '"  ' . ((in_array($vehiclesvalues['v_id'], $allotVehicle)) ? 'disabled' : '') . '>';
                    }
                } else {
                    if (in_array($vehiclesvalues['v_id'], $allotVehicle)) {
                        $disabled = 'disabled';
                    } else {
                        $disabled = '';
                    }
                    if (isset($ve) && in_array($vehiclesvalues['v_id'], $ve)) {
                        $cont .= 'You can\'t Allot this Vehicle because this vehicle no is repaeting';
                    } else {

                        $cont .= '<input type="checkbox" class="option-input checkbox" name="allocate" id="allocate' . $vehiclesvalues['v_id'] . '" value="' . $vehiclesvalues['v_id'] . '" ' . (($vehiclesvalues['v_id'] == $vehicle_table_id) ? 'style="display:none;"' : '') . ' ' . $disabled . '>';
                    }
                }

                $cont .= '</td>';
            } //check own driver Condition closse
            $cont .= '</tr>';
        }
        $cont .= '</tbody>
			</table>
	<input class="btn-search" ' . $display_s . ' type="button" name="next_driver" id="next_driver" value="Next">';
        if ($vehicle_table_id != 0 && $statusss != 1) {
            $cont .= '<input class="btn btn-search" style="float: right;margin-left: 4px;margin-top: 3px; display:none;" type="button" name="final_submit" id="final_submit" value="Confirm" onclick="disable_checkbox(),Allotmentvehicle(\'' . $id_client . '\',\'' . $trans_id . '\',\'' . $va_id . '\',\'' . $fromdate . '\',\'' . $end_date . '\',\'' . $dirver_name_update[0]['driver_name'] . '\',\'' . $statusss . '\')";> <input type="hidden" value="Update" id="suuub">';
        }
        $cont .= '<div id="loadingDiv" style="display: none">
    <div>
       Please Wait!..  <img src="./assets/load_search.gif">
    </div>
</div>
	
	</div>
	<div class="table-responsive clearfix" id="driver_div" style="display:none">
	<span id="date_div" style="display:none" >
		    <label>From</label>
   		
	       <input  type="text"  name="from_date" id="from_date"  readonly autocomplete="off" value="' . $start_date_value . '" style="width:110px;" onchange="allotment(\'' . $fromdate_client . '\',\'' . $end_date_client . '\',\'' . $id_client . '\',\'' . $trans_id . '\',\'' . $va_id . '\',\'' . $fromdate . '\',\'' . $end_date . '\',\'' . $client_arrival . '\',\'' . $vehicle_type_client . '\',\'' . $typeOFtransporter . '\',\'' . $client_departure . '\',\'' . $client_arrival_name . '\',\'' . $vehicle_table_id . '\',\'' . $driver_table_id . '\',\'' . $statusss . '\',\'' . $old_transporter_date . '\',document.getElementById(\'hidden_type\').value,this.value,document.getElementById(\'to_date\').value,document.getElementById(\'remarks\').value);">
	        <input type="hidden" id="span" value="0">
	         <input  type="hidden"  name="from_date12" id="from_date12" value="' . date('d/m/Y', strtotime($fromdate_client)) . '" >
	        <input  type="hidden"  name="from_date1" id="from_date1" value="' . date('d/m/Y', strtotime($old_transporter_date)) . '" >
	          <input  type="hidden"  name="end_date6" id="end_date6" value="' . date('d/m/Y', strtotime($end_date_client)) . '" >
	           <input  type="hidden"  name="from_date_modify" id="from_date_modify" value="' . date('d/m/Y', strtotime($fromdate)) . '" >
	           <input  type="hidden"  name="end_date_modify" id="end_date_modify" value="' . date('d/m/Y', strtotime($end_date)) . '" >
		      <label>To</label> <input type="text" readonly  name="to_date" id="to_date" autocomplete="off" value="' . $end_date_value . '" style="width:110px;" onchange="allotment(\'' . $fromdate_client . '\',\'' . $end_date_client . '\',\'' . $id_client . '\',\'' . $trans_id . '\',\'' . $va_id . '\',\'' . $fromdate . '\',\'' . $end_date . '\',\'' . $client_arrival . '\',\'' . $vehicle_type_client . '\',\'' . $typeOFtransporter . '\',\'' . $client_departure . '\',\'' . $client_arrival_name . '\',\'' . $vehicle_table_id . '\',\'' . $driver_table_id . '\',\'' . $statusss . '\',\'' . $old_transporter_date . '\',document.getElementById(\'hidden_type\').value,document.getElementById(\'from_date\').value,this.value,document.getElementById(\'remarks\').value);">
		        <input type="hidden" id="span" value="0">
		      </span> <div class="clearfix"></div>

		     <div class="table-responsive clearfix">
			<table id="datallotment_value_driver" class="table table-striped table-hover responsive datallotment" cellspacing="0" style="width:100% !important;">
			 <thead >
					<tr>';
        $VALUE = 'Submit';
        if ($privilege_query[0]['vendor'] == 0) {
            if ($mobile == 'true') {
                $cont .= '<th style="width:5% !important;">S.no</th>
                          	 <th >Driver</th>
						     <th >Contact No</th>
                             <th >Choose</th>';
            } else {
                $cont .= '<th style="width:5% !important;">S.no</th>
							<th >Vendor / Transporter</th>
							<th >Transporter Name</th>
						    <th >Transporter Id</th>
                          	<th >Driver</th>
						    <th >Contact No</th>
                            <th >Choose</th>';
            }
        } elseif ($privilege_query[0]['vendor'] == 1) {

            $cont .= '<th >S.no</th>
							 <th >Driver</th>
						    <th >Contact No</th>
						     <th >Choose</th>';
        }
        $cont .= '</tr>
				</thead>
				<tbody>';

        foreach ($can_allot_value_driver as $allotlist) {
            $allotdriver[] = $allotlist['va_driver_id'];
        }


        $i = 0;
        foreach ($vehicleAllotment[1] as $vehiclesvalues) {
            $i++;
            $cont .= '<tr ' . ((in_array($vehiclesvalues['id_driver'], $allotdriver) && $vehiclesvalues['blocked'] == 1) ? 'class="allot"' : '') . '>';


            if ($privilege_query[0]['vendor'] == 0) {
                if ($mobile == 'true') {
                    $cont .= '<td >' . $i . '</td>
						<td >' . $vehiclesvalues['driver_name'] . '</td>
						<td >' . $vehiclesvalues['driver_contact_no'] . '</td>';
                } else {
                    $cont .= '<td >' . $i . '</td>
							<td >' . (($vehiclesvalues['trans_vendors'] == 1) ? 'Vendor' : 'Transporter') . '</td>
							<td >' . $vehiclesvalues['transporter_name_v'] . '</td>
							<td >' . $vehiclesvalues['transporter_ref_no'] . '</td>
							<td >' . $vehiclesvalues['driver_name'] . '</td>
							<td >' . $vehiclesvalues['driver_contact_no'] . '</td>';
                }
            } elseif ($privilege_query[0]['vendor'] == 1) {

                $cont .= '<td >' . $i . '</td>
						<td >' . $vehiclesvalues['driver_name'] . '</td>
						<td >' . $vehiclesvalues['driver_contact_no'] . '</td>';
            }

            $cont .= '<td >';

            if ($vehicle_table_id == 0 || $statusss == 1) {
                $VALUE = 'Confirm';
                $VALUqE = 'submit';
                $cont .= '<input type="checkbox" class="option-input checkbox" name="allocate_driver" id="allocate_driver' . $vehiclesvalues['id_driver'] . '" value="' . $vehiclesvalues['id_driver'] . '" ' . ((in_array($vehiclesvalues['id_driver'], $allotdriver)) ? 'disabled' : '') . '>';
            } else {
                $VALUE = 'Confirm';
                $VALUqE = 'Update';
                if (in_array($vehiclesvalues['id_driver'], $allotdriver)) {
                    $disabled = 'disabled';
                } else {
                    $disabled = '';
                }
                $cont .= '<input type="checkbox" class="option-input checkbox" name="allocate_driver" id="allocate_driver' . $vehiclesvalues['id_driver'] . '" value="' . $vehiclesvalues['id_driver'] . '" ' . (($vehiclesvalues['id_driver'] == $driver_table_id) ? 'style="display:none;"' : '') . ' ' . $disabled . '>';
            }

            $cont .= '</td>
					 </tr>';
        }
        $cont .= '</tbody>
			</table>';
        $cont .= '<input class="btn-search" style="float: right;margin-left: 4px;margin-top: 3px;" type="button" name="final_submit" id="final_submit" value="' . $VALUE . '" onclick="disable_checkbox(),Allotmentvehicle(\'' . $id_client . '\',\'' . $trans_id . '\',\'' . $va_id . '\',\'' . $fromdate . '\',\'' . $end_date . '\',\'' . $dirver_name_update[0]['driver_name'] . '\',\'' . $statusss . '\')";> <input type="hidden" value="' . $VALUqE . '" id="suuub">';
        // if($va_id==""){
        // $cont.='<div id="remark_div" style="float:right;"><lable>Remark</lable>
        //          <input type="text" class="fancy_input remarks" name="remarks" id="remarks" value=""></div>';
        //            }	  

        $cont .= '<input class="btn-search" ' . $display_p . ' type="button" name="previous_driver" id="previous_driver" value="Previous">
			<div class="clearfix"></div>
			<div id="loadingDiv1" style="display: none">
    <div>
       Please Wait!..  <img src="./assets/load_search.gif">
    </div>
</div>
</div>
	</div>';

        echo json_encode(array('cont' => $cont, 'head' => $heading));



        exit;
    }
    public function ShowClientDetails($GetDatas)
    {
        $emp_id = $_SESSION['user_id'];
        $id_client = $GetDatas['id_client'];
        $trans_id = $GetDatas['trans_id'];
        $actual_link = './common_files/download_pdf_trans.php';
        if ($trans_id != "" && $trans_id != 0) {
            $transporter = 'and a.transporter_id="' . $trans_id . '" and d.va_transporter_id="' . $trans_id . '"';
        } else {
            $transporter = '';
        }

        $clientList = $this->pdo->prepare('select a.id_client, a.transporter_id,d.va_start_date ,a.rejected_vendors,a.remarks as vendor_remarks,d.remarks ,d.va_end_date,a.start_from,a.end_to,a.ref_no,a.client_name,a.client_arrival_name,a.client_departure_name,a.no_of_days,a.arrival_via,a.a_train_flight_no,a.departure_via,a.d_train_flight,dr.driver_name,dr.contact_no,dr.contactalterno,e.vehicle_type_name,va_v.vehicle_type_name as va_vehicle_name,d.va_id,ps_vehicles.vehicle_no  from ps_client as a left join ps_vehicle_allotment as d on a.id_client=d.client_table_id left join ps_driver as dr on (dr.id_driver=d.va_driver_id) left join ps_vehicletypes as e on (e.vt_id=a.vehicle_type and e.status=0)  left join ps_vehicles on (ps_vehicles.v_id=d.va_vehicle_id) left join ps_vehicletypes as va_v on (va_v.vt_id=ps_vehicles.vehicle_type ) where a.status!=1 and a.id_client="' . $id_client . '" ' . $transporter . ' ');
        $clientList->execute();
        $clientList = $clientList->fetchAll(PDO::FETCH_ASSOC);

        if ($trans_id != "" && $trans_id != 0) {

            $transporter_his = 'and va_h.id_history=' . $clientList[0]['va_id'] . '';
        } else {

            $transporter_his = '';
        }

        $vehicle_his = $this->pdo->prepare('SELECT va_h.trip_went_not, va_h.va_start_date as his_start,va_h.va_end_date as his_end,dr.contact_no as his_contact_no,v.vehicle_no as his_vehicle_no,b.vehicle_type_name as his_vehicle,dr.driver_name as his_driver,va_h.remarks as his_remarks from ps_vehicle_allotment_history va_h left join ps_vehicles v on(v.v_id =va_h.va_vehicle_id ) left join ps_vehicletypes as b on b.vt_id=v.vehicle_type left join ps_driver as dr on (dr.id_driver = va_h.va_driver_id) where  va_h.client_table_id=' . $id_client . ' ' . $transporter_his . '');
        $vehicle_his->execute();
        $vehicle_his = $vehicle_his->fetchAll(PDO::FETCH_ASSOC);

        $arr_trans = explode(",", $clientList[0]['rejected_vendors']);
        $arr_trans_remarks = explode(",", $clientList[0]['vendor_remarks']);
        $combine_value = array_combine($arr_trans, $arr_trans_remarks);
        $viaList = array(1 => 'Flight', 2 => 'Train', 3 => 'Bus', 4 => 'Residency');
        $vendor = (($trans_id != "" && $trans_id != 0) ? 1 : 0);

        echo '<style type="text/css">
    table td{
        line-height: 1.5; 
        padding: 5px;
        font-size: 12px;
    }
    table th{
        line-height: 1.5; 
        width: 50%;
        vertical-align: top;
        font-weight: normal;
        color: #000;
        font-size: 14px;
    }
    fieldset {
        border: 1px solid #c0c0c0;
        margin: 0 2px;
        padding: 0.35em 0.625em 0.75em;
    }
</style>';

        if (!empty($clientList)) {
            $countArr = count($clientList);

            echo '<fieldset>
        <div class="container client_views">
            <h3 style="text-align: center;"> Client Details</h3>
            <hr>
            <div class="col-sm-6 col-md-4">
                <label>BH Ref No </label>
                ' . $clientList[0]['ref_no'] . '
            </div>
            <div class="col-sm-6 col-md-4">
                <label>Client Name</label>
                ' . $clientList[0]['client_name'] . '
            </div>
            <div class="col-sm-6 col-md-4">
                <label>Arrival</label>' . $clientList[0]['client_arrival_name'] . '
            </div>
            <div class="col-sm-6 col-md-4">
                <label>Departure:</label>
                ' . $clientList[0]['client_departure_name'] . '
            </div>
            <div class="col-sm-6 col-md-4">
                <label>No Of Days</label>';
            if ($vendor == 0) {
                echo $clientList[0]['no_of_days'];
            } else {
                $dateDiff = strtotime($clientList[$countArr - 1]['va_end_date']) - strtotime($clientList[$countArr - 1]['va_start_date']);
                echo (floor($dateDiff / (3600 * 24))) + 1;
            }
            echo '</div>
            <div class="clearfix"></div>
            <div class="col-sm-6 col-md-4">
                <label>Arrival Via</label>';
            if (array_key_exists($clientList[0]['arrival_via'], $viaList)) {
                echo $viaList[$clientList[0]['arrival_via']];
            } else {
                echo '-';
            }
            if ($clientList[0]['a_train_flight_no'] != "") {
                echo ' , ' . $clientList[0]['a_train_flight_no'];
            }
            echo '</div>
            <div class="col-sm-6 col-md-4">
                <label>Departure Via</label>';
            if (array_key_exists($clientList[0]['departure_via'], $viaList)) {
                echo $viaList[$clientList[0]['departure_via']];
            } else {
                echo '-';
            }
            if ($clientList[0]['d_train_flight'] != "") {
                echo ' , ' . $clientList[0]['d_train_flight'];
            }
            echo '</div>';
            if ($vendor == 0) {
                echo '<div class="col-sm-6 col-md-4">
                <label>From Date</label>
                ' . $clientList[0]['start_from'] . '
            </div>
            <div class="col-sm-6 col-md-4">
                <label>To Date</label>
                ' . $clientList[0]['end_to'] . '
            </div>';
            }
            echo '<div class="col-sm-6 col-md-4">
                <label>Vehicle Type</label>
                ' . $clientList[0]['vehicle_type_name'] . '
            </div>
            <div class="col-sm-6 col-md-4">
                <label>Download Itinerary</label>
                <button type="button" class="downloo btn btn-outline-primary " onclick="download(\'' . $actual_link . '\',\'' . $clientList[0]['id_client'] . '\',\'' . $clientList[$countArr - 1]['driver_name'] . '\',\'' . $clientList[$countArr - 1]['contactalterno'] . '\',\'' . $clientList[$countArr - 1]['contact_no'] . '\',\'' . $clientList[$countArr - 1]['va_vehicle_name'] . '\',\'' . $clientList[$countArr - 1]['vehicle_no'] . '\',0,\'' . $clientList[$countArr - 1]['va_start_date'] . '\',' . $vendor . ')"><i class="fa fa-download" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-12 col-md-12 list_view" >
                <div class="table-responsive">
                    <table class="table" >
                        <tr class="tabhead">
                            <th>Arrival & Departure</th>
                            <th>Driver Name</th>
                            <th>Contact No</th>
                            <th>Vehicle</th>
                            <th>Vehicle No</th>
                            <th>Vendor Remark</th>
                            <th></th>
                            <th>Vehicle Remark</th>
                        </tr>';

            if (!empty($vehicle_his)) {
                foreach ($vehicle_his as $List) {
                    echo '<tr>
                    <td>' . (($List['trip_went_not'] != 2) ? 'A:' . $List['his_start'] . '<br>D:' . $List['his_end'] : 'Trip Not Went') . '</td>
                    <td>' . (($List['his_driver'] != "") ? $List['his_driver'] : '-') . '</td>
                    <td>' . (($List['his_contact_no'] != "") ? $List['his_contact_no'] : '-') . '</td>
                    <td>' . (($List['his_vehicle'] != "") ? $List['his_vehicle'] : '-') . '</td>
                    <td>' . (($List['his_vehicle_no'] != "") ? $List['his_vehicle_no'] : '-') . '</td>
                    <td><td>
                    <td >' . (($List['his_remarks'] != "") ? $List['his_remarks'] : '-') . '</td>
                </tr>';
                }
            }
            foreach ($clientList as $ListTable) {
                echo '<tr class="text-nowrap">
                <td>' . (($ListTable['driver_name'] != "") ? 'A:' . $ListTable['va_start_date'] . '<br>D:' . $ListTable['va_end_date'] : '-') . '</td>
                <td>' . (($ListTable['driver_name'] != "") ? $ListTable['driver_name'] : '-') . '</td>
                <td>' . (($ListTable['contact_no'] != "") ? $ListTable['contact_no'] : '-') . '</td>
                <td>' . (($ListTable['va_vehicle_name'] != "") ? $ListTable['va_vehicle_name'] : '-') . '</td>
                <td>' . (($ListTable['vehicle_no'] != "") ? $ListTable['vehicle_no'] : '-') . '</td>';
                if (array_key_exists($ListTable['transporter_id'], $combine_value)) {
                    echo '<td style="width:10%;">' . $combine_value[$ListTable['transporter_id']] . '</td>';
                } else {
                    echo '<td style="width:10%;">-</td>';
                }
                echo '<td>' . (($ListTable['remarks'] != "") ? $ListTable['remarks'] : '-') . '</td>
            </tr>';
            }
            echo '</table>
                </div>
            </div>
        </div>
    </fieldset>';
        }
    }
}
