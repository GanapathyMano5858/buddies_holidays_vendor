<?php include 'header.php';?>
<body>

    <div class="p-4 container hg250">
      <p class="m-0">Transport &nbsp; / &nbsp; Bill Details Report</p>

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

        <div class="row justify-content-between align-items-center">
          <div
            class="btn-group col-lg-3 mb-md-3"
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
            <label class="btn btn-outline-danger" for="btnradio1">Unpaid</label>

            <input
              type="radio"
              class="btn-check"
              name="btnradio"
              id="btnradio2"
              autocomplete="off"
              onclick="toggleDatePicker('show')"
            />
            <label class="btn btn-outline-danger" for="btnradio2">Paid</label>

            <input
              type="radio"
              class="btn-check"
              name="btnradio"
              id="btnradio3"
              autocomplete="off"
              onclick="toggleDatePicker('show')"
            />
            <label class="btn btn-outline-danger" for="btnradio3">All</label>
          </div>

          <div class="gap-3 col-lg-3 mb-md-2 d-none" id="datePickerContainer1">
            <label for="datepicker" class="form-label">Start Date:</label>
            <input type="date" class="form-control" id="datepicker" />
          </div>
          <div class="gap-3 col-lg-3 mb-md-2 d-none" id="datePickerContainer2">
            <label for="datepicker" class="form-label">End Date:</label>
            <input type="date" class="form-control" id="datepicker" />
          </div>

          <div class="gap-3 mb-md-3 mt-md-3 col-lg-2 custom-btn">
            <input
              type="button"
              class="form-control btn btn-danger"
              value="SUBMIT"
            />
          </div>
        </div>
        <!-- Quick Search -->
        <div class="row">
          <div class="col-lg-4">
            <label for="inputState" class="form-label">Quick Search</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control border-dark-subtle" />
            </div>
          </div>
        </div>
        <!-- Quick Search -->

        <!-- table Start -->
        <div class="table-responsive table">
          <table class="table table-bordered table-hover d-none d-lg-block">
            <thead class="text-center">
              <tr>
                <th class="text-nowrap">Sl.No</th>
                <th class="text-nowrap">BH Ref No</th>
                <th class="text-nowrap">Client Name</th>
                <th class="text-nowrap">Arrival</th>
                <th class="text-nowrap">Trip Date</th>
                <th class="text-nowrap">Bill Amount</th>
                <th class="text-nowrap">TDS</th>
                <th class="text-nowrap">Trip Advance</th>
                <th class="text-nowrap">Driver Received Amount</th>
                <th class="text-nowrap">Remaining Individual payable Amount</th>
                <th class="text-nowrap">Vehicle Remark</th>
                <th class="text-nowrap">Status</th>
              </tr>
            </thead>

            <tbody>
              <tr class="text-center align-items-center">
                <td>1</td>
                <td>BHCI009287</td>
                <td class="text-nowrap">Shumsuddin Mysore</td>
                <td>S:13/01/2023 E:16/01/2023</td>
                <td>0</td>
                <td>0</td>
                <td>-</td>
                <td>-</td>
                <td>0</td>
                <td>-</td>
                <td>-</td>
                <td class="text-nowrap fw-bold text-danger-emphasis">
                  Awaiting for<br />verify
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- table End -->

        <!-- Card Start -->

        <div class="d-lg-none">
          <div
            class="container text-center text-danger mb-3 rounded border-bottom p-2 bg-secondary-subtle"
          >
            CLIENT DETAILS
          </div>

          <div class="border rounded">
            <div
              class="container border-bottom p-2 d-flex justify-content-between"
            >
              <div>Bh Ref No :</div>
              <div class="text-secondary">BHCI009072</div>
            </div>

            <div
              class="container border-bottom p-2 d-flex justify-content-between"
            >
              <div>Travel Date :</div>
              <div class="text-secondary">A:13/01/2023<br />D:16/01/2023</div>
            </div>

            <div
              class="container border-bottom p-2 d-flex justify-content-between"
            >
              <div>Amount :</div>
              <div class="text-secondary">0</div>
            </div>

            <div
              class="container border-bottom p-2 d-flex justify-content-between"
            >
              <div>Status :</div>
              <div class="text-nowrap fw-bold text-danger-emphasis">
                Awaiting for<br />verify
              </div>
            </div>

            <div class="container p-2 d-flex justify-content-between">
              <div>View :</div>

              <div>
                <!-- Button trigger modal -->
                <button
                  type="button"
                  class="btn btn-primary btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                >
                  <i class="fa-solid fa-eye"></i>
                </button>

                <!-- Modal Start -->
                <div
                  class="modal fade"
                  id="exampleModal"
                  tabindex="-1"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true"
                >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                          Driver Details
                        </h5>
                        <button
                          type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                        ></button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid border p-3 rounded">
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">BH Ref No :</div>
                            <div class="col-md-6 text-secondary text-end">
                              BHCI009072
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Client Name :</div>
                            <div class="col-md-6 text-secondary text-end">
                              Shumsuddin
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Arrival :</div>
                            <div class="col-md-6 text-secondary text-end">
                              Mysore
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Departure :</div>
                            <div class="col-md-6 text-secondary text-end">
                              Mysore
                            </div>
                          </div>
                          <div class="row justify-content-between p-2">
                            <div class="col-md-6 text-start">Trip Date :</div>
                            <div class="col-md-6 text-secondary text-end">
                              S:13/01/2023<br />E:16/01/2023
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Bill Amount :</div>
                            <div class="col-md-6 text-secondary text-end">
                              0
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">TDS :</div>
                            <div class="col-md-6 text-secondary text-end">
                              0
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Trip Advance :</div>
                            <div class="col-md-6 text-secondary text-end">
                              0
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Driver Received Amount :</div>
                            <div class="col-md-6 text-secondary text-end">
                              0
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Remaining Individual Payable Amount :</div>
                            <div class="col-md-6 text-secondary text-end">
                              0
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Vehicle Remark :</div>
                            <div class="col-md-6 text-secondary text-end">
                              -
                            </div>
                          </div>
                          <div
                            class="row justify-content-between p-2 align-items-center"
                          >
                            <div class="col-md-6 text-start">Status  :</div>
                            <div class="col-md-6 text-danger-emphasis text-end">
                              Awaiting for<br />verify
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal End-->
              </div>
            </div>
          </div>
        </div>

        <!-- Card End -->
      </div>
    </div>
    <script>
      // Initialize date picker
      //   $("#datepicker").datepicker();

      // Function to toggle date picker visibility
      function toggleDatePicker(action) {
        var datePickerContainer1 = document.getElementById(
          "datePickerContainer1"
        );
        var datePickerContainer2 = document.getElementById(
          "datePickerContainer2"
        );

        if (action === "show") {
          datePickerContainer1.classList.remove("d-none");
          datePickerContainer2.classList.remove("d-none");
        } else {
          datePickerContainer1.classList.add("d-none");
          datePickerContainer2.classList.add("d-none");
        }
      }
    </script>
  </body>
</html>
