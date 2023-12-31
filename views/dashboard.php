<?php 
include"header.php";
?>
  <body>

    <div class="container-sm p-4 hg250">
      <p class="page-head m-0 pb-2"><a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=GetCount">Dashboard
    </a></p>

      <div class="row border rounded-4 p-lg-5 pt-sm-5">
        <div class="col-lg-4 p-3">
          <div
            class="card text-center"
            style="background: #7ac721; transition: all 0.4s ease"
          >
            <i class="fa-solid fa-car-side h3 mt-3"></i>
            <div class="card-body">
              <p class="h5 mb-3"> <?php echo $response['unalloted_vehicle_vendors'];?></p>
              <a href="<?php echo _ROOT_DIRECTORY_;?>index.php?action=vehicle-allotment" class="h6 text-decoration-none">Unalloted Vehicles</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 p-3">
          <div
            class="card text-center"
            style="background: #2196f3; transition: all 0.4s ease"
          >
            <i class="fa-solid fa-file-circle-question h3 mt-3"></i>
            <!-- <i class="fa-solid fa-car-side ></i> -->
            <div class="card-body">
              <p class="h5 mb-3"> <?php echo $response['unpaid_bill_vendors'];?></p>
              <a href="<?php echo _ROOT_DIRECTORY_;?>index.php?action=billdetails-report" class="h6 text-decoration-none">Unpaid Bill</a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 p-3">
          <div
            class="card text-center"
            style="background: #ffc107; transition: all 0.4s ease"
          >
            <i class="fa-solid fa-comments h3 mt-3"></i>
            <!-- <i class="fa-solid fa-car-side h3 mt-3"></i> -->
            <div class="card-body">
              <p class="h5 mb-3"> <?php echo $response['unsubmitted_bill_vendors'];?></p>
              <a href="<?php echo _ROOT_DIRECTORY_;?>index.php?action=add-purchase-bill" class="h6 text-decoration-none">Unsubmitted Bill</a>
            </div>
          </div>
        </div>

        <!-- <div class="container border border-1 rounded p-3 mt-lg-5">
          <div class="row justify-content-center">
            <div class="col-lg-4">
              <label for="inputState" class="form-label">State</label>
              <select id="inputState" class="form-select">
                <option>2019</option>
                <option>2020</option>
                <option>2021</option>
                <option>2022</option>
                <option selected>2023</option>
                <option>2024</option>
              </select>
            </div>
          </div> -->

        <!-- <div class="row border border-1 rounded hg m-3">
            <div class="col">

            </div>
          </div> -->
      </div>
    </div>

  </body>
</html>
