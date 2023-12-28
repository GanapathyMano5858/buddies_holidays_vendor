<?php
include "header.php";
//  echo '<pre>';
// print_r($response);
// echo '</pre>';
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#vehicleTable').DataTable({
      lengthMenu: [
        [-1],
        ['All']
      ],
      dom: 'Blfrtip',
      buttons: [{
        extend: 'excel',
        className: 'custom-excel-button margin',
        text: '<button class="btn btn-outline-success">Download &nbsp;<i class="fa-solid fa-download"></i></button>',
        // '<i class="fa-solid fa-download" style="width: 40px />',
        // '<img src="./assets/excel.png" alt="Excel" style="width: 40px;">',
        title: 'Vehicle List'

      }],
    });
  });
</script>

<body>
  <div class="container-sm p-4 hg250">
    <p class="m-0">Transport &nbsp; / &nbsp; Add Vehicle</p>
    <div class="notification" id="notification" style="display:none;">
      <?php echo (isset($_GET['error']) ? $_GET['error'] : ''); ?>
    </div>
    <div class="alert alert-success" id="notification_success" style="display:none;">
      <?php echo (isset($_GET['success']) ? $_GET['success'] : ''); ?>
    </div>
    <div class="p-3 border rounded">
      <!-- <div class="row justify-content-xs-evenly justify-content-lg-end mb-4"> -->




        <?php if ($response['CheckvehiclecountForOwnCome']['count'] == 0) { ?>
          <div class="col-1 left">
            <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addVehicle">
              <button type="button" class="btn btn-primary">
                Add &nbsp;
                <i class="fa-solid fa-circle-plus"></i>
              </button>
            </a>
          </div>
        <?php } ?>

        <!-- <div class="col-2">
          <a href="" onclick="window.location.reload();">
            <button type="button" class="btn btn-secondary">
              Reload &nbsp;
              <i class="fa-solid fa-rotate"></i>
            </button>
          </a>
        </div> -->
      <!-- </div> -->


      <div class="table-responsive table d-none d-lg-block topper">
        <table id="vehicleTable" class="table table-striped table-hover table-borderless">
          <thead class="text-center">
            <tr>
              <th class="text-nowrap" style="font-size: 13px;">Sl.No</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle category</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle Name</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle No</th>
              <th class="text-nowrap" style="font-size: 13px;">Vehicle MFG Year</th>
              <!-- <th class="text-nowrap">Edit</th>
              <th class="text-nowrap">Update Status</th> -->
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

                <td><?php echo ($values['vehicle_status'] == 3 ? 'Request Send' : ($values['vehicle_status'] == 6 ? 'Request Canceled' : '')); ?></td>
                <!-- <td> -->
                  <?php if (isset($values['vehicle_no'])) {
                    $ve = explode(' ', $values['vehicle_no']);
                  }
                  if ($values['vehicle_year'] == "" || (isset($ve) && strlen($ve[0]) != 2 && count_characters($ve[0], true))) {
                    echo '<td style="color:red" > Incomplete</td>';
                  } else {
                    echo '<td style="color:green"> Complete</td>';
                  }
                  ?>

                <!-- </td> -->
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>  


      <!-- Card Start -->
      <div class="row justify-content-start d-lg-none">
        <div class="col-lg-3">
          <label for="inputState" class="form-label">Quick Search</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="quickSearch" onkeyup="quickSearch('vehicleListTable');" />
          </div>
        </div>
      </div>
      <div class="d-lg-none" id="vehicleListTable">
        <?php
        foreach ($response['vehicleList'] as $values) {
        ?>
          <br>
          <div class="cards border">
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

            <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
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
            </div>

            <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
              <div>Update Status :</div>
              <div class="text-secondary"><?php echo ($values['vehicle_status'] == 4 ? 'Request Send' : ($values['vehicle_status'] == 5 ? 'Request Canceled' : '')); ?></div>
            </div>

            <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
              <div>Active Status</div>
              <div class="text-secondary"><?php echo ($values['vehicle_status'] == 3 ? 'Request Send' : ($values['vehicle_status'] == 6 ? 'Request Canceled' : '')); ?></div>
            </div>

            <div class="container align-items-center p-2 d-flex justify-content-between">
              <div>Status :</div>
              <div class="text-secondary">
                <?php if (isset($values['vehicle_no'])) {
                  $ve = explode(' ', $values['vehicle_no']);
                }
                if ($values['vehicle_year'] == "" || (isset($ve) && strlen($ve[0]) != 2 && count_characters($ve[0], true))) {
                  echo 'Incomplete';
                } else {
                  echo 'completed';
                }
                ?>

              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- Card End -->

    </div>
  </div>

</body>

</html>