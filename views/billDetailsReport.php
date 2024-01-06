<?php include 'header.php';?>
<style type="text/css">
  .even td table,
  .odd td table {
    table-layout: fixed;
  }

  td {
    text-align: center !important;
  }

  p {
    margin-bottom: 0 !important;
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
    width: 200px;
    min-height: 50px;
    right: 10px;
    z-index: 1;
    padding: 10px 10px;
    word-break: break-all;
  }

  .show_me {
    display: none;
  }

  .cancel td {
    background: #e4b7d8 !important;
  }

  .arrived td {
    background: #EEDEF5 !important;
  }

  @media(max-width: 599px) {

    .sorting_1,
    .serialno,
    .sortid {
      display: none;
    }

    div.dt-buttons {
      float: unset !important;
      margin-left: 35px;
    }

    .medmargB {
      margin: 45px 0px 10px 0 !important;
    }

    #BillDetailsTable {
      border-spacing: 8px !important;
    }

    .cladatepicker {
      width: 100%;
    }
  }

  @media(width:320px) {
    .cllr {
      color: #7d7d7d;
      float: right;
      font-size: 10px;
    }

    .pdb {
      padding: 0px 3px 0px 0px !important;
    }

    .client_views label:after {
      content: "";
    }
  }

  @media (max-width: 1024px) {
    table tbody tr td {
      line-height: 28px !important;
    }

    .asr {
      color: black;
      float: left;
    }
/* 
    .asr:after {
      content: ":";
      position: absolute;
      right: 50%;
    } */

    .cllr {
      color: #7d7d7d;
      float: right;
      white-space: nowrap;
      overflow: hidden;
      width: 62%;
      text-align: right;
      text-overflow: ellipsis;
    }

    .client_views,
    .list_view {
      padding: 0px;
    }

    .client_views h3 {
      margin: 8px 0;
      font-size: 18px;
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
      background-color: #ffffff !important;
      padding: 20px 15px 20px 15px;
      box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.42);
      border: 1px solid #e4e4e4;
    }

    .bootstrap .table tbody>tr:nth-child(even)>td {
      background-color: #ffffff !important;
      padding: 20px 15px 20px 15px;
      box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.42);
      border: 1px solid #e4e4e4;
    }

    .bootstrap .table tbody>tr:nth-child(odd)>td,
    .bootstrap .table tbody>tr:nth-child(even)>td:hover {
      box-shadow: 0 10px 10px -10px rgba(0, 0, 0, 0.42);
      border: 1px solid #e4e4e4;
    }

    .icon-trash {
      color: #cc0707;
      font-size: 16px;
    }

    .dataTables_filter label {
      font-size: 12px !important;
    }

    .serialno {
      width: 14% !important;
    }

    .vechdet {
      text-align: center !important;
      font-weight: 600;
      text-transform: uppercase;
      width: 85% !important;
      /* background: linear-gradient(to bottom, #efe9e9 19%, #dcdcdc 56%) !important; */
    }

    .pdb {
      padding: 0px;
    }

    .margB {
      margin: 10px 0px 10px 0;
    }

    .medmargB {
      margin: 30px 0px 10px 0;
    }

    .ui-datepicker {
      z-index: 9999 !important;
    }
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {

    // if ($("input[name='type']:checked").val() != 2) {
    //   $('#datePickerContainer1').removeClass("d-none");
    //   $('#datePickerContainer2').removeClass("d-none");

    // } else {
    //   $('#datePickerContainer1').addClass("d-none");
    //   $('#datePickerContainer2').addClass("d-none");
    // }
    // $("input[name='type']").change(function() {
    //   if ($(this).val() != 2) {

    //     $('#datePickerContainer1').removeClass("d-none");
    //     $('#datePickerContainer2').removeClass("d-none");
    //   } else {
    //     $('#datePickerContainer1').addClass("d-none");
    //     $('#datePickerContainer2').addClass("d-none");
    //   }
    // });

    $("#min-date").datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-1:+1",
      dateFormat: 'dd/mm/yy',
      onSelect: function(dateText, inst) {
        $("#max-date").datepicker("option", "minDate",
          $("#min-date").datepicker("getDate"));
      }

    });
    $('#max-date').datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: "-1:+1",
      dateFormat: 'dd/mm/yy'
    });
  });

  function downloadReport(type) {
    if (type == 'excel')
      var url = './common_files/excel-report/billdetails_report.php?';
    window.open(url + "from=" + $('#min-date').val() + "&to=" + $('#max-date').val() + "&type=" + $('input[name=type]:checked').val(), "_blank");
    return false;
  }

  function showClientDetails(id_client, trans_id) {
    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=ShowClientBill",
      data: 'id_client=' + id_client + '&trans_id=' + trans_id,
      type: "POST",
      success: function(result) {

        if ($.trim(result) != '') {
          $("#BillReportModal .modal-body").html(result);
          $("#BillReportModal").modal("show");
        }
      }
    });
  }
</script>
<style>
   .dataTables_filter {
    width: 100%;
  }
/* 
  .dataTables_filter label {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    font-size: 14px;
    padding: 15px 0;
  } */

  .dataTables_filter label input {
    width: 100%;
  }

  @media only screen and (min-width: 992px) {
    .dataTables_filter label input {
      width: 20%;
    }

    .dataTables_filter label {
      display: inline-block;
      padding: 0;
    }
  }

/* @media only screen and(max-width:520px) {
  .total_records{
    width: 50%;
    position: relative;
    top: 35px;
    z-index: 55;
    left: 274px;
  }
} */

@media only screen and (max-width: 600px) {
  .total_records{
    width: 40%;
    position: relative;
    top: 27px;
    z-index: 55;
    left: 250px;
  }
}

#BillDetailsTable_filter{
  margin:0 !important;
}
#BillDetailsTable_filter label{
  padding:0 !important;
  margin:0 !important
}
</style>


<body>

  <div class="p-4 container">
    <p style="font-size: 13px;" class=" page-head m-0 pb-2"><ul class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-container">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=outstanding-report">Report&nbsp;&nbsp;
    </a>
    </li>
    <li class="breadcrumb-current">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=billdetails-report">/&nbsp;&nbsp;Bill Details Report 
    </a>
    </li>
    </ul>
    </p>

    <div class="p-3 border rounded">

      <form action="" method="post" style="box-shadow: none;" class="w-100 py-0 px-0">
        <div class="row justify-content-between   gap-3 gx-md-2 gx-lg-1 gx-sm-3">
          <div class="btn-group col-lg-2 " role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="type" id="btnradio1" autocomplete="off" value="2" checked />
            <label class="btn btn-outline-danger btn-sm " for="btnradio1">Unpaid</label>

            <input type="radio" class="btn-check" name="type" id="btnradio2" value="3" autocomplete="off" <?php echo (isset($response['searchType']) && $response['searchType'] == 3) ? 'checked' : ''; ?> />
            <label class="btn btn-outline-danger btn-sm" for="btnradio2">Paid</label>

            <input type="radio" class="btn-check" name="type" id="btnradio3" value="1" autocomplete="off" <?php echo (isset($response['searchType']) && $response['searchType'] == 1) ? 'checked' : ''; ?> />
            <label class="btn btn-outline-danger btn-sm" for="btnradio3">All</label>
          </div>

          <div class="col-lg-3 flex-row px-4 px-lg-0" id="datePickerContainer1">
            <div class="col-3 text-nowrap ">
              <label for="inputState" class="form-label">Start Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="min-date" name="min-date" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>" />
            </div>
          </div>

          <div class="col-lg-3 flex-row px-4 px-lg-0" id="datePickerContainer2">
            <div class="col-3 text-nowrap ">
              <label for="inputState" class="form-label">End Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="max-date" name="max-date" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>" />
            </div>
          </div>


          <div class="col-lg-1 col-4 ">
            <input type="submit" value="Submit" class="form-control btn btn-outline-danger btn-sm " />
          </div>
          <div class="col-lg-1 col-5  d-block d-lg-none">
          <button onclick="javascript:downloadReport('excel')" class="w-100 btn-sm btn btn-outline-success text-nowrap">
              Download &nbsp;<i class="fa-solid fa-download"></i>
          </div>

        </div>

      </form>

      <!-- table Start -->
      <button onclick="javascript:downloadReport('excel')" style="top: 31px;" class="btn-sm d-none d-lg-block  text-nowrap btn btn-outline-success position-relative float-end ">
        Download &nbsp;<i class="fa-solid fa-download"></i>
      </button>
      <?php if ($response['mobile'] == 'true') { 
          echo(isset($response['no_of_records'])&&$response['no_of_records']!="")? '<div class="total_records">Total Records : '.$response['no_of_records'].'</div>':'';
       } ?>
      <div class="table-responsive table">
        <table class="table table-striped table-hover table-borderless tableList" id="BillDetailsTable">
          <thead class="text-center">
            <tr class="align-middle">
              <?php if ($response['mobile'] == 'true') { ?>

                <th class="vechdet" style="width: 10% !important">Client Details</th>

              <?php } else { ?>
                <th style="width: 3% !important">S.no</th>
                <th style="width: 7% !important">BH Ref No</th>
                <th style="width: 7% !important">Client Name</th>

                <th style="width: 7% !important">Arrival</th>

                <th>
                  <table class="table table-striped table-hover table-borderless" style="margin-bottom:0 !important; width: 100% !important" ;>
                    <thead id="scroll">
                      <tr class="align-middle">

                        <th class="p-0" style="width: 10% !important">Trip Date</th>
                        <th class="p-0 text-nowrap" style="width: 7% !important">Bill Amount </th>
                        <th class="p-0" style="width: 5% !important">TDS</th>
                        <th class="p-0" style="width: 10% !important">
                          <table class="table table-striped table-hover table-borderless" style="margin-bottom:0 !important; width: 100% !important" ;>
                            <thead id="scroll">
                              <tr class="align-middle">
                                <th class="p-0">Trip Advance</th>

                              </tr>
                            </thead>
                          </table>
                        </th>
                        <th class="p-0" style="width: 5% !important">Driver Received Amount</th>
                        <th class="p-0" style="width: 7% !important">
                          <?php if (isset($response['searchType']) && $response['searchType'] == 3) {
                            echo "Remaining Individual paid Amount";
                          } elseif (isset($searchCity) && $searchCity == 1) {
                            echo "Remaining Individual Amount";
                          } else {
                            echo "Remaining Individual payable Amount";
                          }
                          ?>
                        </th>
                        <th class="p-0" style="width: 6% !important">Vehicle Remark</th>
                        <th class="p-0" style="width: 8% !important">Status</th>
                      </tr>
                    </thead>
                  </table>
                </th>
              <?php } ?>
            </tr>
          </thead>

          <tbody>

            <?php echo $response['content']; ?>

          </tbody>
        </table>
      </div>
      <!-- table End -->

      <!-- Modal Start -->
      <div class="modal fade" id="BillReportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Driver Details
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
          </div>
        </div>
      </div>
      <!-- Modal End-->

    </div>
  </div>
</body>

</html>