<?php include 'header.php';?>
  <body>
    <div class="p-4 container hg250">
      <p class="m-0">Transport &nbsp; / &nbsp; Trip Advance Report</p>

      <div class="p-3 border rounded">
        <div class="row justify-content-end mb-4">
          <div class="col-lg-1">
            <a href="transporterOutstandingReport.html">
              <button type="button" class="btn btn-secondary">
                <i class="fa-solid fa-rotate"></i>
              </button>
            </a>
          </div>
        </div>

        <div class="row justify-content-lg-evenly align-items-center">
          <div class="col-lg-2 mb-md-3">
            <label for="inputState" class="form-label">Start Date</label>
            <div class="input-group mb-3">
              <input type="date" class="form-control border-dark-subtle" />
            </div>
          </div>

          <div class="col-lg-2 mb-md-3">
            <label for="inputState" class="form-label">End Date</label>
            <div class="input-group mb-3">
              <input type="date" class="form-control border-dark-subtle" />
            </div>
          </div>

          <div
            class="btn-group col-lg-4 mb-md-4"
            role="group"
            aria-label="Basic radio toggle button group"
          >
            <input
              type="radio"
              class="btn-check"
              name="btnradio"
              id="btnradio1"
              autocomplete="off"
              checked
              onclick="toggleDatePicker('hide')"
            />
            <label class="btn btn-outline-danger" for="btnradio1"
              >Paid</label
            >

            <input
              type="radio"
              class="btn-check"
              name="btnradio"
              id="btnradio2"
              autocomplete="off"
              onclick="toggleDatePicker('show')"
            />
            <label class="btn btn-outline-danger" for="btnradio2"
              >Unpaid</label
            >
          </div>
          <div class="col-lg-2 mb-md-4">
            <input
              type="submit"
              value="Submit"
              class="form-control btn btn-outline-danger"
            />
          </div>
        </div>
        <!-- Quick Search -->
        <div class="row ms-lg-4">
          <div class="col-lg-3">
            <label for="inputState" class="form-label">Quick Search</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control border-dark-subtle" />
            </div>
          </div>
        </div>

        <!-- table Start -->
        <div class="table-responsive table">
          <table class="table table-bordered table-hover d-none d-lg-block">
            <thead class="text-center">
              <tr>
                <th class="text-nowrap">Sl.No</th>
                <th class="text-nowrap">BH Ref No</th>
                <th class="text-nowrap">Client Name</th>
                <th class="text-nowrap">Trip Date</th>
                <th class="text-nowrap">Arrival Departure</th>
                <th class="text-nowrap">Trip Advance Request</th>
                <th class="text-nowrap">Trip Advance Paid</th>
                <th class="text-nowrap">Approval Status</th>
                <th class="text-nowrap">Paid Status</th>
                <th class="text-nowrap">Paid Date</th>
                <th class="text-nowrap">Remark</th>
                <th class="text-nowrap">Vehicle Remark</th>
              </tr>
            </thead>

            <tbody>
              <tr class="text-center align-items-center">
                <td>-</td>
                <td>-</td>
                <td class="text-nowrap">-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- table End -->

        <!-- Card Start -->

        <div class="border rounded d-lg-none">
          <div class="container border-bottom p-2 bg-secondary-subtle">
            BHCI009072
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Client Name :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Trip Date :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Arrival Departure :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Trip Advance :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Trip Advance :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Approval Status :</div>
            <div>
              <div class="text-secondary">-</div>
            </div>
          </div>

          <div
            class="container border-bottom align-items-center p-2 d-flex justify-content-between"
          >
            <div>Paid Status :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container align-items-center p-2 d-flex justify-content-between"
          >
            <div>Paid Date :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container align-items-center p-2 d-flex justify-content-between"
          >
            <div>Remark :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container align-items-center p-2 d-flex justify-content-between"
          >
            <div>Remark :</div>
            <div class="text-secondary">-</div>
          </div>

          <div
            class="container align-items-center p-2 d-flex justify-content-between"
          >
            <div>Vehicle Remark :</div>
            <div class="text-secondary">-</div>
          </div>
        </div>

        <!-- Card End -->
      </div>
    </div>
    <script>
      //   datepicker
      $(document).ready(function () {
        $("#myDateInput").datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
        });
      });
    </script>
  </body>
</html>
