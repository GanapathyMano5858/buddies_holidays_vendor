<?php include 'header.php';?>
<script type="text/javascript">
  $(document).ready(function() {
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
  input[type='text'] {
    border: 1px solid #0d6efd;
    border-radius: 2px;
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
      padding: 0;
    }
  }
</style>

<body>
  <div class="p-4 container-fluid container-xl ">
    <p style="font-size: 13px;" class=" page-head m-0 pb-2"><ul class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-container">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=outstanding-report">Report&nbsp;&nbsp;
    </a>
    </li>
    <li class="breadcrumb-current">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=outstanding-report">/&nbsp;&nbsp;Payment Adjusted Report
    </a>
    </li>
    </ul>
    </p>

    <div class="p-3 border rounded">
      <form action="" method="post" style="box-shadow: none;" class="p-0 w-100">
        <div class="row justify-content-between ">
          <div style="font-size: 14px;" class="col-1 text-nowrap pt-2 pt-lg-0">
            <label for="inputState" class="form-label m-0 text-nowrap ">Start Date :</label>
          </div>
          <div class="col-lg-2 pt-2 pt-lg-0">
            <div class="input-group ">
              <input style="height: 30px;" type="text" id="min-date" autocomplete="off" name="min-date" class=" form-control border-dark-subtle" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>">
            </div>
          </div>

          <div style="font-size: 14px;" class="col-1 text-nowrap pt-2 pt-lg-0">
            <label for="inputState" class="form-label m-0 text-nowrap">End Date :</label>
          </div>

          <div class="col-lg-2 pt-2 pt-lg-0">
            <div class="input-group ">
              <input style="height: 30px;" type="text" id="max-date" name="max-date" class="form-control border-dark-subtle" autocomplete="off" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>">
            </div>
          </div>

          <div class="btn-group pt-3 pt-lg-0 col-lg-3" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check btn-sm" name="type" id="btnradio1" autocomplete="off" checked value="1" onclick="toggleDatePicker('hide')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio1">Outstadning</label>

            <input type="radio" class="btn-check btn-sm" name="type" id="btnradio2" autocomplete="off" value="2" <?php echo (isset($response['searchType']) && $response['searchType'] == 2) ? 'checked' : ''; ?> onclick="toggleDatePicker('show')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio2">Purchase</label>
            <input type="radio" class="btn-check btn-sm" name="type" id="btnradio3" autocomplete="off" value="3" <?php echo (isset($response['searchType']) && $response['searchType'] == 3) ? 'checked' : ''; ?> onclick="toggleDatePicker('show')" />
            <label class="btn btn-outline-danger btn-sm" for="btnradio3">Tripadvance</label>
          </div>
          <div class="col-lg-1 col-md-3 col-sm-3 pt-lg-0 pt-3  ">
            <input type="submit" value="Submit" class="form-control btn btn-outline-danger btn-sm " />
          </div>
          <div class="col-lg-1 col-md-3 col-sm-3 col-12 pt-3 pt-lg-0 d-block d-lg-none">
            <button onclick="javascript:downloadReport('excel')" class="btn-sm w-100 btn btn-outline-success">
              Download &nbsp;<i class="fa-solid fa-download"></i>
            </button>
          </div>
        </div>
      </form>



      <!-- table Start -->


      <button onclick="javascript:downloadReport('excel')" style="top: 31px;" class="btn-sm d-none d-lg-block  text-nowrap btn btn-outline-success position-relative float-end ">
        Download &nbsp;<i class="fa-solid fa-download"></i>
      </button>
    <?php if ($response['mobile'] == 'true') { 
          echo(isset($response['no_of_records'])&&$response['no_of_records']!="")? '<var>Total Records : '.$response['no_of_records'].'</var>':'';
       } ?>

      <div class="table-responsive table">
        <table class="table table-striped table-hover table-borderless tableList" id="OutstandingTable">
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
  </div>
  <!-- <script>
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
  </script> -->
</body>

</html>