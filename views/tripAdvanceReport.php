<?php include 'header.php'; ?>
<script type=text/javascript>
  $(document).ready(function() {
    $(document).on('click', '.close', function() {
      // Find the closest modal and hide it
      $(this).closest('.modal').modal('hide');
    });
    $('#tripPayment').DataTable({
      lengthMenu: [
        [-1],
        ['All']
      ],
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

<body>
  <div class="p-4">
    <p class="m-0">Transport &nbsp; / &nbsp; Trip Advance Report</p>

    <div class="p-3 border rounded">
      <form action="" method="post" style="box-shadow: none;" class="pb-0 pe-1 ps-1">
        <div class="row justify-content-lg-around align-items-center">
          <div class="col-lg-3 flex-row pe-md-4 ps-md-4 mb-md-3 mb-lg-0">
            <div class="col-3 text-nowrap ">
              <label for="inputState" class="form-label">Start Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="min-date" name="min-date" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>" />
            </div>
          </div>

          <div class="col-lg-3 flex-row pe-md-4 ps-md-4 mb-md-3 mb-lg-0">
            <div class="col-3 text-nowrap ">
              <label for="inputState" class="form-label">End Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="max-date" name="max-date" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>" />
            </div>
          </div>

          <div class="btn-group col-lg-2 mb-md-4 mb-lg-0" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check btn-sm" name="btnradio" id="btnradio1" value="3" name="type" autocomplete="off" checked onclick="toggleDatePicker('hide')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio1">Paid</label>

            <input type="radio" class="btn-check btn-sm" name="btnradio" id="btnradio2" name="type" value="2" autocomplete="off" <?php echo (isset($response['type']) && $response['type'] == 2) ? 'checked' : ''; ?> onclick="toggleDatePicker('show')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio2">Unpaid</label>
          </div>
          <div class="col-lg-2 mb-md-4 mb-lg-0">
            <input type="submit" value="Submit" class="form-control btn btn-outline-danger btn-sm" />
          </div>
        </div>
      </form>

      <!-- table Start -->
      <button onclick="javascript:downloadReport('excel')" style="right: 31px; top: 45px; z-index: 2;" class="btn-sm btn btn-outline-success position-relative float-end ">
        Download &nbsp;<i class="fa-solid fa-download"></i>
      </button>
      <div class="table-responsive table">
        <table class="table table-striped table-hover table-borderless" id="tripPayment">
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