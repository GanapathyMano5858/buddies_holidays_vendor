<?php
include "header.php";?>
<script type="text/javascript">
  function downloadReport(type) {
    if (type == 'excel')
      var url = './common_files/excel-report/vehicleList.php?';
    window.open(url, "_blank");
    return false;
  }
</script>

<body>
  <div class="container-fluid container-lg p-4">
    <p style="font-size: 13px;" class=" page-head m-0 pb-2"><ul class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-container">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-vehicleList">Transport&nbsp;&nbsp;
    </a>
    </li>
    <li class="breadcrumb-current">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-vehicleList">/&nbsp;&nbsp;Add Vehicle 
    </a>
    </li>
    </ul>
    </p>
    <div class="notification" id="notification" style="display:none;">
      <?php echo (isset($_GET['error']) ? $_GET['error'] : ''); ?>
    </div>
    <div class="alert alert-success" id="notification_success" style="display:none;">
      <?php echo (isset($_GET['success']) ? $_GET['success'] : ''); ?>
    </div>
    <div class="p-3 border rounded">
      <?php if ($response['CheckvehiclecountForOwnCome']['count'] == 0) { ?>
        <div class="row d-flex justify-content-end">
          <div class="col-lg-1 col-md-2 col-3 text-end" style="z-index: 5;">
            <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addVehicle">
              <button type="button" class="text-nowrap btn btn-primary btn-sm">
                Add &nbsp;
                <i class="fa-solid fa-circle-plus"></i>
              </button>
            </a>
          </div>
          <div class="col-lg-2 col-md-3 col-5 d-flex justify-content-end" style="z-index: 5;">
            <button onclick="javascript:downloadReport('excel')" class="btn-sm btn btn-outline-success ">
              Download &nbsp;<i class="fa-solid fa-download"></i>
            </button>
          </div>
        </div>
      <?php } ?>

      <div class="table-responsive table d-none d-md-block" style="position: relative; top:-38px;">
        <table id="vehicleTable" class="table table-striped table-hover table-borderless tableList">
          <thead class="text-center">
            <tr>
              <th class="text-nowrap" style="font-size: 13px;">Sl.No</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle category</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle Name</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle No</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle MFG Year</th>
              <th class="text-nowrap" style="font-size: 13px;">Active Status</th>
              <th class="text-nowrap" style="font-size: 13px;">Status</th>
            </tr>
          </thead>

          <tbody class="text-center align-items-center">
            <?php $i = 0;
            foreach ($response['vehicleList'] as $values) {
              $i++;
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $values['vehicle_category']; ?></td>
                <td class="text-nowrap"><?php echo $values['vehicle_type_name']; ?></td>
                <td class="text-nowrap "><?php echo $values['vehicle_no']; ?></td>
                <td><?php echo $values['vehicle_year']; ?></td>

                <?php echo ($values['vehicle_status'] == 3 ? '<td style="color:blue" >Request Send</td>' : ($values['vehicle_status'] == 6 ? '<td style="color:orange" >Request Canceled</td>' : '<td></td>')); ?>

                <?php
                if ($values['vehicle_year'] < 2014 || $values['vehicle_type_name'] == "") {
                  echo '<td style="color:red" > Incomplete</td>';
                } else {
                  echo '<td style="color:green"> Completed</td>';
                }
                ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>


      <!-- Card Start -->
      <div class="d-md-none  d-xs-block ">
        <div class="row justify-content-start d-lg-none align-items-center mt-3">
          <div class="col-6 col-lg-3">
            <div class="input-group">
              <input type="text" placeholder="Quick Search" class="form-control" id="quickSearch" onkeyup="quickSearch('vehicleListTable');" />
            </div>
          </div>
          <div class="col-6 ps-0">
            <?php echo(isset($response['no_of_records'])&&$response['no_of_records']!="")? '<div class="text-end">Total Records : '.$response['no_of_records'].'</div>':'';?>
          </div>
        </div>
        
        <div class="d-lg-none" id="vehicleListTable">
              <?php
              if (empty($response['vehicleList'])) {
              echo '<div class="alert alert-secondary" role="alert">
                      No data available
                    </div>';
              } else {
         
          foreach ($response['vehicleList'] as $values) {
          ?>
          
            <div class="cards border my-3 rounded">
              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Vehicle category :</div>
                <div class="text-secondary"><?php echo $values['vehicle_category']; ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Vehicle Name :</div>
                <div class="text-secondary"><?php echo $values['vehicle_type_name']; ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Vehicle No :</div>
                <div class="text-secondary"><?php echo $values['vehicle_no']; ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Vehicle MFG Year :</div>
                <div class="text-secondary"><?php echo $values['vehicle_year']; ?></div>
              </div>

              <!-- <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Edit :</div>
                <div class="text-secondary">
                  <?php if (!in_array($values['vehicle_status'], [1, 3, 6])) : ?>
                    <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addVehicle&&v_id=<?php echo $values['v_id'] ?>">
                      <button type="button" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-pen-to-square link-light"></i>
                      </button>
                    </a>
                  <?php else : ?>
                    <?php echo '-'; ?>
                  <?php endif; ?>

                </div>
              </div> -->

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Active Status</div>
                <div class="text-secondary"><?php echo ($values['vehicle_status'] == 3 ? '<span style="color:blue" > Request Send </span>' : ($values['vehicle_status'] == 6 ? '<span style="color:orange" >Request Canceled</span>' : '')); ?></div>
              </div>

              <div class="container align-items-center p-2 d-flex justify-content-between">
                <div>Status :</div>
                <div class="text-secondary">
                  <?php
                  if (isset($values['vehicle_no'])) {
                    $ve = explode(' ', $values['vehicle_no']);
                  }
                  if ($values['vehicle_year'] == "" || (isset($ve) && strlen($ve[0]) != 2 && count_characters($ve[0], true)))

                    if ($values['vehicle_year'] < 2014 || $values['vehicle_type_name'] == "") {
                      echo '<span style="color:red" >Incomplete</span>';
                    } else {
                      echo '<span style="color:green" >completed </span>';
                    }
                  ?>

                </div>
              </div>
            </div>
          <?php } }?>
        </div>
      </div>
      <!-- Card End -->

    </div>
  </div>

  <script>
    // Function to dynamically update styles based on screen size
    function updateStyles() {
      var windowWidth = window.innerWidth;

      var element = document.querySelector('.position-relative');

      // Remove existing Bootstrap classes
      element.classList.remove('position-md-relative', 'position-lg-relative');

      // Apply appropriate Bootstrap class based on screen size
      if (windowWidth >= 992) {
        // Large (lg) screen
        element.classList.add('position-lg-relative');
      } else {
        // Medium (md) screen
        element.classList.add('position-md-relative');
      }
    }

    // Call the function on window resize and on page load
    window.addEventListener('resize', updateStyles);

    // Initial call to update styles on page load
    updateStyles();
  </script>

</body>

</html>