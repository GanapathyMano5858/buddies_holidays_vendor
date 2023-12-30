<?php include 'header.php';

?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#OutstandingTable').DataTable({
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

  function downloadReport(type) {
    if (type == 'excel')
      var url = './common_files/excel-report/outstanding_report.php?';
    window.open(url + "from=" + $('#min-date').val() + "&to=" + $('#max-date').val() + "&type=" + $('input[name=type]:checked').val(), "_blank");
    return false;
  }
</script>

<style>
  input[type='text']{
    border: 1px solid #0d6efd;
    border-radius: 2px;
  }
</style>

<body>
  <div class="p-4 container hg250">
    <p class="m-0">
      Transport &nbsp; / &nbsp; Transporter outstanding report
    </p>

    <div class="p-3 border rounded">
      <!-- <div class="row justify-content-end mb-4">
          <div class="col-lg-1">
            <a href="transporterOutstandingReport.html">
              <button type="button" class="btn btn-secondary">
                <i class="fa-solid fa-rotate"></i>
              </button>
            </a>
          </div>
        </div> -->
      <!-- <div class="a bt-group pdf_icon" style="position: relative;">
        <a style="padding-top: 0px;display: block;position: absolute;z-index: 99;right: 30px;top:-5px;" href="#" onclick="javascript:downloadReport('excel');"><img width="37" src="./assets/excel.png" title="Export" alt="" style="margin-top: 10px;"></a>
      </div> -->
   
      <form action="" method="post" style="box-shadow: none;" class="ps-0 pe-0 pb-0 ">
        <div class="row justify-content-lg-evenly align-items-center">
          <div class="col-lg-3 flex-row mb-md-3 mb-lg-0">
            <div class="col-2 col-lg-3 text-nowrap ">
              <label for="inputState" class="form-label">Start Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="min-date" name="min-date" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>" />
            </div>
          </div>

          <div class="col-lg-3 flex-row mb-md-3 mb-lg-0">
            <div class="col-2 col-lg-3 text-nowrap ">
              <label for="inputState" class="form-label">End Date :</label>
            </div>
            <div class="col-9">
              <input style="height: 30px;" type="text" class="form-control border-dark-subtle" autocomplete="off" id="max-date" name="max-date" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>" />
            </div>
          </div>

          <div class="btn-group col-lg-3 mb-md-3 mb-lg-0" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check btn-sm" name="btnradio" id="btnradio1" autocomplete="off" checked value="1" onclick="toggleDatePicker('hide')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio1">Outstadning</label>

            <input type="radio" class="btn-check btn-sm" name="btnradio" id="btnradio2" autocomplete="off" value="2" <?php echo (isset($response['searchType']) && $response['searchType'] == 2) ? 'checked' : ''; ?> onclick="toggleDatePicker('show')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio2">Purchase</label>
            <input type="radio" class="btn-check btn-sm" name="btnradio" id="btnradio3" autocomplete="off" value="3" <?php echo (isset($response['searchType']) && $response['searchType'] == 3) ? 'checked' : ''; ?> onclick="toggleDatePicker('show')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio3">Tripadvance</label>
          </div>
          <div class="col-lg-2">
            <input type="submit" value="Submit" class="form-control btn btn-outline-danger btn-sm " />
          </div>
        </div>
      </form>


      <!-- table Start -->
      <button onclick="javascript:downloadReport('excel')" style="top: 45px; z-index:5;" class="btn-sm btn btn-outline-success position-relative float-end ">
      Download &nbsp;<i class="fa-solid fa-download"></i>
      </button>
      <div class="table-responsive table">
        <table class="table table-striped table-hover table-borderless" id="OutstandingTable">
          <thead class="text-center">
            <tr>
              <?php if ($response['mobile'] == 'true') { ?>

                <th class="vechdet" style="width: 10% !important">Client Details</th>

              <?php } else { ?>
                <?php if (isset($response['searchType']) && $response['searchType'] == 3) { ?>
                  <th>S.no</th>

                  <th class="text-nowrap ">BH Ref No</th>
                  <th class="text-nowrap ">Client Name</th>
                  <th class="text-nowrap ">Travel Date</th>
                  <th class="text-nowrap ">Trip Date</th>
                  <th>
                    <table class="table" style="width:100%;margin-bottom:0 !important;">
                      <thead id="scroll">
                        <tr>
                          <th class="text-nowrap">Trip Advance Request</th>
                          <th class="text-nowrap">Payable Amount</th>
                          <th class="text-nowrap">Paid Amount</th>
                          <th class="text-nowrap">Adjusted From</th>
                        </tr>
                      </thead>
                    </table>
                  </th>

                <?php } else { ?>
                  <th>S.no</th>

                  <th class="text-nowrap ">BH Ref No</th>
                  <th class="text-nowrap ">Client Name</th>
                  <th class="text-nowrap ">Travel Date</th>
                  <th class="text-nowrap ">Trip Date</th>
                  <th class="text-nowrap ">Purchase Amount</th>
                  <th class="text-nowrap ">Trip Advance</th>
                  <th class="text-nowrap ">Driver Received Amount</th>
                  <th class="text-nowrap ">TDS</th>
                  <?php if (isset($response['searchType']) && $response['searchType'] == 2) { ?>
                    <th class="text-nowrap">Payable Amount</th>
                    <th class="text-nowrap">Paid Amount</th>
                    <th class="text-nowrap">Adjusted From</th>
                  <?php } else { ?>
                    <th class="text-nowrap ">Outstanding Amount</th>


              <?php }
                }
              }
              ?>

            </tr>
          </thead>

          <tbody>

            <?php echo $response['content']; ?>
          </tbody>
        </table>
      </div>
      <!-- table End -->
    </div>
  </div>
  <script>
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
</body>

</html>