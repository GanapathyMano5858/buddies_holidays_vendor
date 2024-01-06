<?php include 'header.php'; ?>
<style type="text/css">
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
</style>
<script type=text/javascript>
  $(document).ready(function() {
    $(document).on('click', '.close', function() {
      // Find the closest modal and hide it
      $(this).closest('.modal').modal('hide');
    });
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

  function showClientDetails(id_client, trans_id) {
    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=ShowClientTrip",
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

  function downloadReport(type) {
    if (type == 'excel')
      var url = './common_files/excel-report/trip_advance_payment_report.php?';


    window.open(url + "from=" + $('#min-date').val() + "&to=" + $('#max-date').val() + "&type=" + $('input[name="type"]:checked').val(), "_blank");
    return false;
  }

  function Itinerary_modal(id, type) {
    $(".itinerary_modal").modal('show');
    $.ajax({
      type: "POST",
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=ViewDetailsAdvance",
      data: {
        id: id,
        type: type
      },
      dataType: 'json',
      beforeSend: function() {
        $(".itinerary_modal .modal-body").html("<h4 class='text-center'>Please Wait. While Loading..</h4>");
      },
      success: function(data) {
        //console.log(data);
        $(".itinerary_modal .modal-body").html(data.cont);
        $(".itinerary_modal .modal-header").html(data.head);
      }
    });
  }
</script>

<style>
  .modal-header {
    flex-direction: row-reverse;
  }

  
  .dataTables_filter {
    width: 100%;
  }

  .dataTables_filter label {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    font-size: 14px;
    padding: 15px 0;
  }

  .dataTables_filter label input {
    width: 100%;
  }

  @media only screen and (min-width: 992px) {
    .dataTables_filter label input {
      width: 20%;
    }

    .dataTables_filter label {
      display: inline-block;
      /* padding: 0; */
    }
  }


</style>

<body>
  <div class="p-4">
  <!-- <p style="font-size: 13px;" class=" page-head m-0 pb-2"> -->
  <ul class="breadcrumb page-breadcrumb mb-1">
    <li class="breadcrumb-container">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=outstanding-report">Report&nbsp;&nbsp;
    </a>
    </li>
    <li class="breadcrumb-current">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=tripadvance-report">/&nbsp;&nbsp;Trip Advance Report 
    </a>
    </li>
    </ul>
    <!-- </p> -->
   

    <div class="p-3 border rounded">
      <form action="" method="post" style="box-shadow: none;" class="w-100 py-0 px-0">
        <div class="row justify-content-lg-around justify-content-between align-items-center gap-3 gx-md-2 gx-lg-1 gx-sm-3">
          <div class="col-lg-3 flex-row pe-md-4 mb-md-3 mb-lg-0">
            <div class="col-3 text-nowrap ">
              <label for="inputState" class="form-label">Start Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="min-date" name="min-date" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>" />
            </div>
          </div>

          <div class="col-lg-3 flex-row mb-md-3 mb-lg-0">
            <div class="col-3 text-nowrap ">
              <label for="inputState" class="form-label">End Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="max-date" name="max-date" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>" />
            </div>
          </div>

          <div class="btn-group col-lg-2 mb-md-4 mb-lg-0" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check btn-sm" id="btnradio1" value="3" name="type" autocomplete="off" checked />
            <label class="btn btn-outline-danger btn-sm" for="btnradio1">Paid</label>

            <input type="radio" class="btn-check btn-sm" id="btnradio2" name="type" value="2" autocomplete="off" <?php echo (isset($response['tysearcTypepe']) && $response['searcType'] == 2) ? 'checked' : ''; ?>  />
            <label class="btn btn-outline-danger btn-sm" for="btnradio2">Unpaid</label>
          </div>
          <div class="col-lg-1 col-md-3 col-sm-3">
            <input type="submit" value="Submit" class="form-control btn btn-outline-danger btn-sm" />
          </div>
          <div class="col-lg-2 col-md-3 col-sm-3 col-12">
            <button onclick="javascript:downloadReport('excel')" class="w-100 btn-sm btn btn-outline-success text-nowrap">
              Download &nbsp;<i class="fa-solid fa-download"></i>
            </button>
          </div>
        </div>

      </form>

      <!-- table Start -->
     <?php if ($response['mobile'] == 'true') { 
          echo(isset($response['no_of_records'])&&$response['no_of_records']!="")? '<var>Total Records : '.$response['no_of_records'].'</var>':'';
       } ?>
      <div class="table-responsive table">
        <table class="table table-striped table-hover table-borderless tableList" id="tripPayment">
          <thead class="text-center">
            <tr>
              <?php if ($response['mobile'] == 'true') { ?>

                <th class="vechdet" style="width: 7% !important">Client Details</th>

              <?php } else { ?>
                <th>S.no</th>
                <th>BH Ref No</th>
                <th>Client Name</th>
                <th>Trip Date</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Itinerary</th>
                <th>
                  <table style="margin-bottom:0 !important;">
                    <thead id="scroll">
                      <tr>

                        <th>
                          <table style="margin-bottom:0 !important;">
                            <thead id="scroll">
                              <tr>
                                <th class="text-nowrap">Trip Advance Request &nbsp;&nbsp; &nbsp;</th>
                                <th class="text-nowrap">Trip Advance Paid &nbsp;&nbsp; &nbsp;</th>
                                <th class="text-nowrap">Approval Status &nbsp;&nbsp; &nbsp;</th>
                                <th class="text-nowrap">Paid Status &nbsp;&nbsp; &nbsp;</th>
                                <th class="text-nowrap">Paid Date &nbsp;&nbsp; &nbsp;</th>
                                <th class="text-nowrap">Remark &nbsp;&nbsp; &nbsp;</th>
                                <th class="text-nowrap">Vehicle Remark &nbsp;&nbsp; &nbsp;</th>

                              </tr>
                            </thead>
                          </table>
                        </th>

                      </tr>
                    </thead>
                  </table>
                </th>

              <?php } ?>
            </tr>
          </thead>
          <?php echo $response['content']; ?>
          <tbody>

          </tbody>
        </table>
      </div>
      <!-- table End -->


    </div>
  </div>
</body>
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

</html>