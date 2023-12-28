<?php include 'header.php'; ?>
<style type="text/css">
  .isDisabled {
    pointer-events: none;
    cursor: default;
    text-decoration: none;
    color: black;

  }

  .modal-dialog {
    margin: auto;
  }

  .ui-autocomplete {
    z-index: 9999;

  }

  .allot td {
    background: #d0cfcf;
  }

  #loadingDiv {
    display: none;
    margin: 0px;
    padding: 0px;
    position: fixed;
    right: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    background-color: #000;
    z-index: 30001;
    opacity: 0.8;
  }

  #loadingDiv div {
    position: absolute;
    top: 50%;
    left: 45%;
    color: #fff;
  }

  #remarks1 {
    width: 300px;
    margin: 0 auto;
  }

  #next_action {
    margin-top: 15px;
  }

  /*  .datallotment tbody{
    height:200px;
    overflow-y:auto;
    width: 100%;
    }*/
  .modal-body div.dataTables_wrapper {
    /*width: 800px;*/
    margin: 0 auto;

  }

  .modal-body .datatable-scroll {

    overflow-y: visible !important;
  }

  .modal-body {
    position: relative;
    padding: 15px !important;
  }

  .btn {
    padding: 4px 9px !important;
    margin-bottom: 2px !important;
    font-size: 13px !important;
    margin-left: 5px !important;
    margin-right: 7px;
  }

  .allot_button {
    color: white !important;
    padding: 4px 8px;
    font-size: 12px;
    text-decoration: none;
    border-radius: 3px;
    margin-bottom: 20px;
    display: inline-block;
  }


  input[name="allot_que"] {
    margin: 0 10px 0 10px;
  }

  .modal button.close {
    background: #252424;
    opacity: 1;
    border: 2px solid #fff;
    width: 29px;
    border-radius: 100%;
    height: 30px;
    color: #fff;
    position: absolute;
    right: -10px;
    top: -9px;
  }

  @media(max-width: 599px) {

    .serialno,
    .sortid {
      display: none;
    }

    .fancybox-opened {
      font-family: 'Open Sans', sans-serif;
      width: 350px !important;
    }

    .vehsearch {
      float: right;
    }

    .indexlistsort .sorting_1 {
      display: none;
    }

    .jconfirm.jconfirm-white .jconfirm-box,
    .jconfirm.jconfirm-light .jconfirm-box {
      width: 272px;
    }

    .vehicle_divss {
      border: none !important;
    }

    #datallotment_value_wrapper {
      margin-top: -3em !important;
    }

    .cladatepicker {
      width: 100%;
    }

    .vehsearch {
      margin: 15px 0px;
    }

    #allotmentTable {
      border-spacing: 8px !important;
    }

    .customedit {
      margin-right: -62px;
    }

    .canceltt {
      background: #e4b7d8 !important;
    }
  }

  @media (max-width: 1024px) {
    table tbody tr td {
      line-height: 28px !important;
    }

    .table-responsive {
      border: 1px solid #e4e4e4 !important;
    }

    .asr {
      color: #500606;
      float: left;
    }

    .asr:after {
      content: ":";
      position: absolute;
      /*right: 52%; */
    }

    .cllr {
      color: #7d7d7d;
      float: right;
      font-size: 11px;
    }

    .allot_button {
      float: right;
    }

    .request {
      color: #ffffff;
      background: transparent !important;
      padding: 2px 0px;
      text-transform: uppercase;
      color: #f31111 !important;
      font-weight: 600;
      font-size: 11px;
    }

    .bootstrap .table tbody>tr:nth-child(odd)>td {
      /*background-color:#ffffff!important;*/
      padding: 12px 12px 12px 15px !important;
      box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.42);
      border: 1px solid #e4e4e4;
    }

    .bootstrap .table tbody>tr:nth-child(odd)>td:hover,
    .bootstrap .table tbody>tr:nth-child(even)>td:hover {
      box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.42);
      border: 1px solid #e4e4e4;
    }

    .bootstrap .table tbody>tr:nth-child(even)>td {
      background-color: #ffffff;
      padding: 12px 12px 12px 15px !important;
      box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.42);
      border: 1px solid #e4e4e4;
    }

    /*.cancel td
  {
    background-color: #e4b7d8;
  }*/
    .icon-trash {
      color: #cc0707;
      font-size: 16px;
    }

    .dataTables_filter label {
      font-size: 12px !important;
    }

    /*.bootstrap .table tbody>tr:nth-child(even)
  {
    border:2px solid green!important;
  }*/
    .serialno {
      width: 14% !important;
    }

    .vechdet {
      text-align: center !important;
      font-weight: 600;
      text-transform: uppercase;
      width: 85% !important;
      background: linear-gradient(to bottom, #efe9e9 19%, #dcdcdc 56%) !important;
    }

    .serialno {
      background: linear-gradient(to bottom, #efe9e9 19%, #dcdcdc 56%) !important;
      text-align: center !important;
    }

    .dataTables_filter input {
      width: 245px !important;
    }

    #allotmentTable {
      width: 100% !important;
      margin: 0;
    }

    #ui-datepicker-div {
      z-index: 9999 !important;
    }

    .allot_button {
      padding: 0px 12px;
      box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
    }

    .adminvehicleallotment .fancybox-inner {
      width: auto !important;
    }

    .client_views,
    .list_view {
      padding: 0px;
    }

    .client_views h3 {
      margin: 8px 0;
      font-size: 18px;
    }

    .list_view table th {
      font-size: 12px;
      color: #c12231;
      /*font-weight: 600;*/
    }

    .fancybox-inner table tbody tr td {
      font-size: 12px !important;
    }

    .fancybox-opened {
      font-family: 'Open Sans', sans-serif;
    }

    .tabhead {
      background: linear-gradient(to bottom, #efe9e9 19%, #f1f1f1 56%);
    }

    .vehicle_divss {
      border: none !important;
    }

    .ui-datepicker-multi-2 {
      width: 30em !important;
      left: 6.5px !important;
    }

    #arrival_div label {
      margin-left: 0px !important;
      margin: 0px 5px;
      font-weight: 600;
      color: #484848;
    }

    .arrived td {
      background: #EEDEF5 !important;
    }

  }

  @media(width:320px) {
    .fancybox-opened {
      width: 290px !important;
    }

    .cllr {
      font-size: 8px;
      color: #232222;
    }
  }

  .fancybox-container--ready .fancybox-bg {
    opacity: 1;
    background: #000;
  }

  .jconfirm-box {
    width: 400px;
  }


  .show_query {
    position: relative;
    text-decoration: none !important;
    color: #555555 !important;
    font-weight: bold;

  }

  .show_query:hover .show_me {
    display: block;
    position: absolute;
    background-color: #515050;
    color: white;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;

    min-height: 50px;
    /*overflow: scroll; */
    left: 10px;
    z-index: 1;
    padding: 10px 10px;
    word-break: break-all;
  }

  .show_me {
    display: none;
  }

  #trip_status {
    margin-top: 10px;
  }

  .tripsub {
    padding-bottom: 0px;
  }

  #tripwent_or_not {
    width: 200px;
    height: 33px;
  }

  .driver_sms_modal .modal-content {
    margin: 50px auto !important;
  }

  .export_mail_modal .modal-content {
    margin: 50px auto !important;
  }

  .voucher_modal .modal-content {
    margin: 50px auto !important;
  }

  .allotmentmodel .modal-content {
    margin: 50px auto !important;
  }

  #getRemarks .modal-content {
    margin: 50px auto !important;
  }

  #getRemarks .modal-dialog {
    width: 450px;
  }


  @media (max-width: 600px) {
    #getRemarks .modal-dialog {
      width: 300px;
    }
  }


  @media (max-width: 600px) {
    .allotmentmodel .modal-dialog {
      width: 320px;
    }
  }

  .modal-title {
    /* background-image: linear-gradient(to bottom, #c12231, #c12231);*/
    color: #fff;
  }

  div.dt-button-background {
    background: none;
  }

  .disable td {
    background: #ABEBC6 !important;
  }

  .disable_class {
    background-color: #ABEBC6 !important;
  }

  table td {
    text-align: center !important;
    /*width: 60px;*/
  }

  table th {
    text-align: center !important;
    width: 60px;
  }

  /*table.dataTable thead th, table.dataTable thead td {
    padding: 6px 7px;}*/
  .cancel td {
    background: #e4b7d8 !important;
  }

  .violet td {
    background: #c4b7e4 !important;
  }

  .cancel_status {
    background: #e4b7d8 !important;
  }

  .ui-state-active,
  .ui-widget-content .ui-state-active,
  .ui-widget-header .ui-state-active,
  a.ui-button:active,
  .ui-button:active,
  .ui-button.ui-state-active:hover {
    border: 1px solid #c12a21 !important;
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%) !important;
    font-weight: normal;
    color: #ffffff !important;
  }


  .dataTables_wrapper .dataTables_paginate .paginate_button:active {
    border: 1px solid #910005;
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%);
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    border: 1px solid #910005;
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%);
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current,
  .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #fff !important;
    border: 1px solid #910005;
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%);
  }

  .ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header,
  .ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header {
    border-left-width: 0;
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%);
    color: white;
  }

  .ui-datepicker-header.ui-widget-header.ui-corner-left {
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%);
  }

  .option-input {
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    position: relative;
    top: -5.66667px;
    right: 0;
    bottom: 0;
    left: 0;
    height: 18px;
    width: 18px;
    transition: all 0.15s ease-out 0s;
    background: #cbd1d8;
    border: none;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    margin-right: 0.5rem;
    outline: none;
    position: relative;
    z-index: 1000;
  }

  .option-input:hover {
    background: #9faab7;
  }

  .option-input:checked {
    background: linear-gradient(to bottom, #DB0B0B 19%, #910005 56%);

  }

  .option-input:checked::before {
    height: 40px;
    width: 40px;
    position: absolute;
    content: '✔';
    display: inline-block;
    font-size: 13.66667px;
    text-align: center;
    line-height: 40px;
    top: -9px;
    left: -11px;
  }

  input[type=checkbox]:focus {
    outline: 0px;
    outline-offset: 0px;
  }

  .bootstrap .table thead>tr>th {
    background: linear-gradient(to bottom, #efe9e9 19%, #f1f1f1 56%);
    border: none;
    font-weight: normal;
    vertical-align: inherit;
    color: #c12231;
    padding: 6px 1px;
    font-size: 12px !important;
  }

  .bootstrap .table tbody>tr>td {
    border-top: none;
    color: #212121;
    padding: 6px 0px !important;
    vertical-align: middle;
    font-size: 12px;
  }

  .fancy_input {
    padding: 1px !important;
  }

  .vehsearch {
    margin-top: 16px;
    margin-left: 5px;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {

    $('#allotmentTable').DataTable({});
  });
  $(document).on("click", "input[name='allocate']", function() {
    // Uncheck all other checkboxes
    $("input[name='allocate']").not(this).prop("checked", false);

    // Check the clicked checkbox
    $(this).prop("checked", true);
  });
  $(document).on("click", "input[name='allocate_driver']", function() {
    // Uncheck all other checkboxes
    $("input[name='allocate_driver']").not(this).prop("checked", false);

    // Check the clicked checkbox
    $(this).prop("checked", true);
  });
  $(document).on("click", "input[name='allot_que']", function() {
    $(this).prop("checked", true);
  });


  function initaatedatepicker(datefrom, dateto, check) {

    var datefrom1 = datefrom;
    var todatess = $("#" + datefrom1).val();
    if ($("#from_date4").val() != '') {
      datefrom1 = 'from_date4';
      todatess = $("#" + datefrom1).val().replace(new RegExp('-', 'g'), '/');
    }

    // $("#to_date4,#to_date").datepicker({
    //  changeMonth: true,
    //  changeYear: true,
    //  numberOfMonths: 2,
    //  dateFormat: "dd/mm/yy", 
    //  minDate:todatess,
    //  maxDate:$("#"+dateto).val()
    // });

    if (check == '2') {
      $("#from_date4,#from_date").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 2,
        dateFormat: "dd/mm/yy",
        minDate: $("#" + datefrom).val(),
        maxDate: $("#" + dateto).val(),
        //onSelect: function(dateText, inst){
        // $("#to_date4").datepicker("option","minDate",$("#from_date4").datepicker("getDate"));
        // $("#to_date").datepicker("option","minDate",$("#from_date").datepicker("getDate"));

        //}

      });
    } else {
      $("#from_date4").val($("#" + datefrom1).val());
      $("#from_date").val($("#" + datefrom1).val());
    }
    //  $('#to_date,#to_date4').datepicker({  
    //  changeMonth:true,
    //  changeMonth: true,
    //  changeYear: true,
    //  numberOfMonths: 2,
    //  dateFormat: "dd/mm/yy",
    //  maxDate:$("#"+dateto).val(), 

    // });


  }

  function disable_checkbox() {
    $('#final_submit').prop('disabled', true);
  }

  function Allotmentvehicle(client_id, trans_id, va_id, start_date, end_date, driver_name, statusss) {

    var test = 0;

    if ($('input[name="allocate"]').is(':visible') && $('input[name="allocate"]:checked').length == 0) {
      $.alert('Please Select vehicle Detail');
      $('#final_submit').prop('disabled', false)
      return false;
    } else if ($('input[name="allocate_driver"]').is(':visible') && $('input[name="allocate_driver"]:checked').length == 0) {
      $.alert('Please Select Driver Detail');
      $('#final_submit').prop('disabled', false);
      return false;
    } else if ($('#from_date').is(':visible') && !$('#from_date').val() || !$('#to_date').val()) {

      $.alert('Please Select trip date');
      $('#final_submit').prop('disabled', false);
      return false;

    } else if ($('#from_date4').is(':visible') && !$('#from_date4').val() || !$('#to_date4').val()) {
      $.alert('Please Select trip date');
      $('#final_submit').prop('disabled', false);
      return false;

    } else if ($('#remarks').is(':visible') && $('#remarks').val() == "") {
      $.alert('Please Enter remarks');
      $('#final_submit').prop('disabled', false);
      return false;
    } else {
      if ($('#suuub').val() == 'Update') {
        test = 1;
      }

      addVehicle(client_id, trans_id, va_id, start_date, end_date, test, statusss);
    }
  }

  function addVehicle(client_id, trans_id, va_id, start_date, end_date, test, statusss) {
    var remarks = $('#remarks').val();

    if ($('#from_date').is(':visible')) {
      var start_date = $('#from_date').val();
      var end_date = $('#to_date').val();
    } else if ($('#from_date4').is(':visible')) {
      var start_date = $('#from_date4').val();
      var end_date = $('#to_date4').val();
    }
    var vehicle_id = $('input[name="allocate"]:checked').val();
    var driver_id = $('input[name="allocate_driver"]:checked').val();
    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=Allotmentvehicle",
      data: {
        trans_id: trans_id,
        va_id: va_id,
        client_id: client_id,
        driver_id: driver_id,
        vehicle_id: vehicle_id,
        start_date: start_date,
        end_date: end_date,
        remarks: remarks,
        test: test,
        statusss: statusss
      },
      type: "post",
      beforeSend: function() {
        $(".overlayss").css("display", "block");
      },
      success: function(res) {


        $(".overlayss").css("display", "none");
        if (res == 1) {
          $.alert("Assigned Successfully");
          $('#final_submit').prop('disabled', false);
          location.reload(true);
        } else {
          $.alert("Error ....Pls try again later");
          //location.reload(true);

        }
      }
    });
  }


  function allotment(start_date_client, end_date_client, id_client, trans_id, va_id, start_date, end_date, client_arrival, vehicle_type_client, typeOFtransporter, client_departure, client_arrival_name, vehicle_table_id, driver_table_id, status, old_transporter_date, checked = false, searched_fromdate = false, searched_todate = false, remarksss = false) {

    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=allotment",
      data: {
        id_client: id_client,
        trans_id: trans_id,
        start_date: start_date,
        end_date: end_date,
        client_arrival: client_arrival,
        vehicle_type_client: vehicle_type_client,
        calltype: 1,
        typeOFtransporter: typeOFtransporter,
        client_departure: client_departure,
        client_arrival_name: client_arrival_name,
        va_id: va_id,
        vehicle_table_id: vehicle_table_id,
        driver_table_id: driver_table_id,
        checked: checked,
        searched_fromdate: searched_fromdate,
        searched_todate: searched_todate,
        remarksss: remarksss,
        end_date_client: end_date_client,
        start_date_client: start_date_client,
        status: status,
        old_transporter_date: old_transporter_date
      },
      type: "post",
      dataType: 'json',
      beforeSend: function() {
        $(".allotmentmodel .modal-header").html("<h4 class='text-center'>Please Wait. While Loading..</h4>");


      },
      success: function(result) {
        console.log(result);

        $(".allotmentmodel .modal-header").html(result.head);

        $(".allotmentmodel .modal-body").html(result.cont);

        $(".allotmentmodel").modal("show");
        $('.close').click(function() {
          $(".allotmentmodel").modal("hide");

        });

        if ($.fn.dataTable.isDataTable('#datallotment_value')) {
          $('#datallotment_value').DataTable();

        } else {
          $('#datallotment_value').DataTable({
            fixedHeader: true,
            scrollY: 200,
            scrollCollapse: true,
            paging: false
          });
          $('.dataTables_scrollHeadInner,.dataTables_scrollHeadInner table').width('');

        }
        if ($.fn.dataTable.isDataTable('#datallotment_value_driver')) {
          $('#datallotment_value_driver').DataTable();
        } else {
          $('#datallotment_value_driver').DataTable({
            fixedHeader: true,
            scrollY: 200,
            scrollCollapse: true,
            paging: false
          });
          $('.dataTables_scrollHeadInner,.dataTables_scrollHeadInner table').width('');

        }

        $("input[name=allot_que]").on('click', function() {
          //$(this).data('clicked', true);


          $("#remark_div").css("display", "block");

        });


        $('#remarks1').on('keyup', function() {
          if ($(this).val().length == 0) {
            $("#next_action").prop("disabled", true);
          } else {
            $("#next_action").prop("disabled", false);
          }
        });

        $(".allotmentmodel").on("click", '#next_action', function() {
          var type_allot = $("input[name='allot_que']:checked").val();
          $('#hidden_type').val(type_allot);
          var type_remrks = $("#remarks1").val();
          $('#remarks').val(type_remrks);

          if ($("input[name='allot_que']:checked").val() == 1) {

            $("#que_div").css("display", "none");
            $("#vehicle_div").css("display", "block");
            $("#arrival_div").css("display", "inline");
            $("#date_div").css("display", "block");
            $(".allotmentmodel #myModalLabel").html("New Vehicle Assign");
            $("#final_submit").css("display", "block");


          } else if ($("input[name='allot_que']:checked").val() == 2) {

            $("#driver_div").css("display", "block");
            $("#que_div").css("display", "none");
            $("#arrival_div").css("display", "inline");
            $(".allotmentmodel #myModalLabel").html("New Driver Assign");
            $("#date_div").css("display", "block");



          } else if ($("input[name='allot_que']:checked").val() == 3) {


            $("#arrival_div").css("display", "inline");
            $("#date_div").css("display", "block");
            $("#vehicle_div").css("display", "block");
            $("#que_div").css("display", "none");
            $("#next_driver").css("display", "block");
            $(".allotmentmodel #myModalLabel").html("New Vehicle & Driver Assign");
            $("#previous_driver").css("display", "block");
            $(".allotmentmodel").on("click", '#next_driver', function() {

              if ($("input[name='allot_que']:checked").val() != 0) {
                $("#date_div").css("display", "block");
              }


            });
            $(".allotmentmodel").on("click", '#previous_driver', function() {
              if ($("input[name='allot_que']:checked").val() != 0) {
                $("#date_div").css("display", "block");
              }
            });

          }

        });


        $(".allotmentmodel").on("click", '#next_driver', function() {
          if ($('#from_date').is(':visible') && !$('#from_date').val() || !$('#to_date').val()) {

            $.alert('Please Select trip date');


          } else if ($('#from_date4').is(':visible') && !$('#from_date4').val() || !$('#to_date4').val()) {
            $.alert('Please Select trip date');


          } else if ($('input[name="allocate"]').is(':visible') && $('input[name="allocate"]:checked').length == 0) {
            $.alert('Please Select vehicle Detail');
          } else {
            $("#vehicle_div").css("display", "none");

            $("#driver_div").css("display", "block");
          }


        });
        $("input[name=allocate_driver]").on('click', function() {
          var checked = $(this).prop("checked");
          $("input[name=allocate_driver]").attr("checked", false);
          $(this).prop("checked", checked);
        });
        $("input[name=allocate]").on('click', function() {
          var checked = $(this).prop("checked");
          $("input[name=allocate]").attr("checked", false);
          $(this).prop("checked", checked);
        });


        $(".allotmentmodel").on("click", '#previous_driver', function() {
          //$("#span").val(0);
          $("#vehicle_div").css("display", "block");
          $("#driver_div").css("display", "none");

          //      if(("#span").val()==1){
          //                $("#vehicle_div").css("display", "none");
          // $("#driver_div").css("display", "block");
          //      }
          //      else{
          //               $("#vehicle_div").css("display", "block");
          //      $("#driver_div").css("display", "none");
          //      }
        });
      }
    });
  }

  function download(url, id_client, name, al_mobile, mobile, vehicle, vehicle_no, special, date, vendor) {


    window.open(url + '?id_client=' + id_client + '&&name=' + name + '&&al_mobile=' + al_mobile + '&&mobile=' + mobile + '&&vehicle=' + vehicle + '&&vehicle_no=' + vehicle_no + '&&special=' + special + '&&date=' + date + '&&vendor=' + vendor, '_blank');

  }

  function showClientDetails(id_client, trans_id) {
    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=ShowClientDetails",
      data: 'id_client=' + id_client + '&trans_id=' + trans_id,
      type: "POST",
      success: function(result) {

        if ($.trim(result) != '') {
          $.fancybox({
            'content': result,
            'autoSize': true,
            'minWidth': 300
          });
        }
      }
    });
  }
</script>

<body>

  <div class="p-4  hg250">
    <p class="m-0">Transport &nbsp; / &nbsp; Vehicle Allotment</p>

    <div class="p-3 border rounded">
      <div class="row justify-content-end mb-4">
        <div class="col-lg-1">
          <a href="vehicleAllotment.html">
            <button type="button" class="btn btn-secondary">
              <i class="fa-solid fa-rotate"></i>
            </button>
          </a>
        </div>
      </div>
      <form action="" method="post" style="box-shadow: none;">
        <div class="row container m-auto  justify-content-lg-evenly align-items-center">
          <div class="col-lg-1 mt-auto mb-auto ms-auto ">
            <label for="inputState" class="form-label m-0 text-nowrap ">Start Date</label>
          </div>
          <div class="col-lg-2 mt-auto mb-auto">
            <div class="input-group">
              <input type="text" id="min-date" autocomplete="off" name="min-date" class="form-control border-dark-subtle" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>">
            </div>
          </div>

          <div class="col-lg-1 mt-auto mb-auto ms-auto">
            <label for="inputState" class="form-label m-0">End Date</label>
          </div>

          <div class="col-lg-2 mt-auto mb-auto">
            <!-- <label for="inputState" class="form-label">End Date</label> -->
            <div class="input-group ">
              <input type="text" id="max-date" name="max-date" class="form-control border-dark-subtle" autocomplete="off" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>">
            </div>
          </div>

          <div class="btn-group col-lg-4" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="type" id="btnradio1" autocomplete="off" value="1" checked onclick="toggleDatePicker('hide')" />
            <label class="btn btn-outline-danger" for="btnradio1">Un Allotted</label>

            <input type="radio" class="btn-check" name="type" id="btnradio2" value="2" <?php echo (isset($response['searchType']) && $response['searchType'] == 2) ? 'checked' : ''; ?> autocomplete="off" />
            <label class="btn btn-outline-danger" for="btnradio2">Allotted</label>
            <input type="radio" class="btn-check" name="type" id="btnradio3" autocomplete="off" value="3" <?php echo (isset($response['searchType']) && $response['searchType'] == 3) ? 'checked' : ''; ?> />
            <label class="btn btn-outline-danger" for="btnradio3">All</label>
          </div>
          <div class="col-lg-1">
            <input type="submit" value="Search" class="form-control btn btn-outline-danger" />
          </div>
        </div>
      </form>


      <!-- table Start -->
      <div class="table-responsive table ">
        <table class=" table table-striped table-hover table-borderless" id="allotmentTable">
          <thead class="tabel-row">
            <tr>
              <?php if ($response['mobile'] == 'true') { ?>

                <th class="serialno">S.no</th>
                <th class="vechdet">Client Details</th>

              <?php } else { ?>
                <th style="display: none;">S.no</th>
                <th>S.no</th>
                <th class="text-nowrap ">Booking Id </th>
                <th>Guest Name</th>
                <th>Arrival </th>
                <th>Departure </th>
                <th class="text-nowrap">Travel Date</th>
                <th class="p-0 ">
                  <table style='width:100%;'>
                    <thead>
                      <th class=" text-nowrap" style='padding:10px;'>Trip Date</th>
                      <th class="text-nowrap" style='padding:10px;'>No of days</th>
                      <th>
                        <table style='width:100%;'>
                          <thead>
                            <th class="text-nowrap" style='padding:10px;'>Vehicle Type</th>
                            <th class="text-nowrap" style='padding:10px;'>Driver name</th>
                            <th class="text-nowrap" style='padding:10px;'>Download Itinerary</th>
                            <th class="text-nowrap" style='padding:10px;'>Vendor Remark</th>
                            <th class="text-nowrap" style='padding:10px;'>Vehicle Remark</th>
                          </thead>
                        </table>
                      </th>
                    </thead>
                  </table>
                </th>
                <th>Allotment</th>
                <!-- <?php } ?> -->
            </tr>
          </thead>


          <tbody class="text-center align-items-center">
            <?php echo $response['content']; ?>

          </tbody>
        </table>
      </div>
      <!-- table End -->

    </div>
  </div>
  <script>
    //   datepicker
    $(document).ready(function() {
      $("#min-date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
        onSelect: function(dateText, inst) {
          $("#max-date").datepicker("option", "minDate",
            $("#min-date").datepicker("getDate"));
        }

      });
      $('#max-date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
      });
    });

    //   toggle btn

    function toggleButton(selectedButton) {
      // Get all buttons
      var buttons = document.getElementsByClassName("btn-outline-danger");

      // Toggle the active state for all buttons
      for (var i = 0; i < buttons.length; i++) {
        if (i + 1 === selectedButton) {
          // Toggle the selected button
          buttons[i].classList.toggle("active");
        } else {
          // Unselect other buttons
          buttons[i].classList.remove("active");
        }
      }
    }
  </script>
  <div class="modal fade itinerary_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">


        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade allotmentmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">


        </div>
        <div class="modal-body">


        </div>
      </div>
    </div>
  </div>
  <div id="getRemarks" class="modal fade getRemarks">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <!--   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
          <h4 class="modal-title" style="text-align:center">Trip Status </h4>
        </div>
        <div class="modal-body">
          <!-- <div>
              <input type="button" class="btn-search" name="add" value="Add" id="add">     
              <input type="button" class="btn-search" name="modify" value="Modify" id="modify">
          </div> -->
          <div class="row" id="trip_status">
            <div class="col-md-6 form-group">
              <h5 id="trip_went_label"></h5>
            </div>
            <div class="col-md-3 form-group">
              <label for="Yes_trip">Yes</label>
              <input type="radio" name="tripwent_or_not" id="Yes_trip" value="1">

            </div>
            <div class="col-md-3 form-group">
              <label for="no_trip">No</label>
              <input type="radio" name="tripwent_or_not" id="no_trip" value="2">

            </div>

            <button type="button" id="trip" class="btn btn-search">Submit</button>

          </div>

          <div id="loadingDiv1" style="display: none">
            <div>
              Please Wait!.. <img src="./assets/load_search.gif">
            </div>
          </div>


        </div>

      </div>
    </div>
  </div>
  <div class="overlayss __web-inspector-hide-shortcut__">
    <div class="loader-box">
      <div id="loader-2">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <div class="loading" data-name="Loading">Please Wait....</div>
      </div>
    </div>
  </div>
</body>

</html>