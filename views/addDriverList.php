<?php
include "header.php"; ?>
<script type="text/javascript">
  function viewdriver(id) {

    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?action=viewdriver",
      data: 'id=' + id,
      type: "POST",
      success: function(result) {

        if ($.trim(result) != '') {
          $('#exampleModal .modal-body').html(result);
          $('#exampleModal').modal('show');
        }
      }
    });
  }

  function downloadReport(type) {
    if (type == 'excel')
      var url = './common_files/excel-report/driverList.php?';
    window.open(url, "_blank");
    return false;
  }
</script>
<style>
  /* Custom styles for full-width responsive modal */
  .modal-full {
    width: 100%;
    margin: 0;
  }

  .modal-full .modal-content {
    height: 100vh;
  }

  @media (max-width: 576px) {
    .modal-full {
      width: 100%;
    }
  }
</style>
<div class="container-fluid container-lg p-4">
  <p style="font-size: 13px;" class=" page-head m-0 pb-2">
  <ul class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-container">
      <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-vehicleList">Transport&nbsp;&nbsp;
      </a>
    </li>
    <li class="breadcrumb-current">
      <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-driverList">/&nbsp;&nbsp;Add Driver
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
    <div class="row d-flex justify-content-end gap-5">
      <div class="col-lg-1 col-md-2 col-sm-2 col-3" style="z-index: 5;">
        <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addDriver">
          <button type="button" class="text-nowrap btn btn-primary btn-sm">
            Add &nbsp;
            <i class="fa-solid fa-circle-plus"></i>
          </button>
        </a>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-2 col-3 d-flex justify-content-end" style="z-index: 5;">
        <button onclick="javascript:downloadReport('excel')" class="text-nowrap btn-sm btn btn-outline-success ">
          Download &nbsp;<i class="fa-solid fa-download"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive table d-none d-md-block" style="position: relative; top:-38px;">
      <table id="driverTable" class="table table-striped table-hover table-borderless tableList">
        <thead class="text-center">
          <tr>
            <th class="text-nowrap">Sl.No</th>
            <th class="text-nowrap">Driver Name</th>
            <th class="text-nowrap">Driver Contact No.</th>
            <th class="text-nowrap">Driving License</th>
            <th class="text-nowrap">View</th>
            <th class="text-nowrap">Edit</th>
            <th class="text-nowrap">Update Status</th>
            <th class="text-nowrap">Active Status</th>
            <th class="text-nowrap">Status</th>
          </tr>
        </thead>

        <tbody class="text-center align-items-center">
          <?php $i = 0;
          foreach ($response['driverList'] as $values) {
            $i++;
          ?>
            <tr>
              <td class="align-middle"><?php echo $i; ?></td>
              <td class="align-middle"><?php echo $values['driver_name']; ?></td>
              <td class="align-middle"><?php echo $values['driver_contact']; ?>&nbsp;/&nbsp;<?php echo $values['driver_alternate']; ?></td>
              <td class="align-middle"><?php echo $values['driving_license']; ?></td>
              <td class="align-middle">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-sm" onclick="viewdriver(<?php echo $values['id_driver']; ?>)">

                  <i class="fa-solid fa-eye"></i>
                </button>

              </td>
              <td class="align-middle">
                <?php if (!in_array($values['status'], [1, 3, 6])) : ?>
                  <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addDriver&&id_driver=<?php echo $values['id_driver'] ?>">
                    <button type="button" class="btn btn-warning btn-sm">
                      <i class="fa-solid fa-pen-to-square link-light"></i>
                    </button>
                  </a>
                <?php else : ?>
                  <?php echo '-'; ?>
                <?php endif; ?>

              </td>
              <?php echo ($values['status'] == 4 ? '<td class="align-middle" style="color:blue">Request Send</td>' : ($values['status'] == 5 ? '<td class="align-middle" style="color:orange">Request Canceled</td>' : '<td></td>')); ?>
              <?php echo ($values['status'] == 3 ? '<td class="align-middle" style="color:pink">Request Send</td>' : ($values['status'] == 6 ? '<td class="align-middle" style="color:maroon">Request Canceled</td>' : '<td></td>')); ?>

              <td class="align-middle" style="color: <?php echo ($values['driving_license'] == "" ? 'red' : 'green'); ?>">
                <?php echo ($values['driving_license'] == "" ? 'Incomplete' : 'Completed'); ?>
              </td>
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
            <input type="text" class="form-control" placeholder="Quick Search" id="quickSearch" onkeyup="quickSearch('driverListTable');" />
          </div>
        </div>
        <div class="col-6 ps-0">
          <?php echo (isset($response['no_of_records']) && $response['no_of_records'] != "") ? '<div class="text-end">Total Records : ' . $response['no_of_records'] . '</div>' : ''; ?>
        </div>
      </div>
      <div class="d-lg-none" id="driverListTable">
        <?php
        if (empty($response['driverList'])) {
          echo '<div class="alert alert-secondary" role="alert">
                  No data available
                </div>';
        } else {
          $i = 0;
          foreach ($response['driverList'] as $values) {
            $i++;
        ?>
            <div class="cards border border-dark-subtle my-4 rounded">
              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Driver Name :</div>
                <div class="text-secondary text-wrap"><?php echo $values['driver_name']; ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Driver Contact No. :</div>
                <div class="text-secondary"><?php echo $values['driver_contact']; ?><br><?php echo $values['driver_alternate']; ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Driving License :</div>
                <div class="text-secondary"><?php echo $values['driving_license']; ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>View :</div>
                <div>
                  <button type="button" class="btn btn-primary btn-sm" onclick="viewdriver(<?php echo $values['id_driver']; ?>)">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Edit :</div>
                <div>
                  <?php if (!in_array($values['status'], [1, 3, 6])) :
                  ?>
                    <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addDriver&&id_driver=<?php echo $values['id_driver'] ?>">
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
                <div class="text-secondary"><?php echo ($values['status'] == 4 ? '<span style="color:blue">Request Send</span>' : ($values['status'] == 5 ? '<span style="color:orange"> Request Canceled</span>' : '')); ?></div>
              </div>

              <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
                <div>Active Status</div>
                <div class="text-secondary"><?php echo ($values['status'] == 3 ? '<span style="color:pink"> Request Send </span>' : ($values['status'] == 6 ? '<span style="color:maroon"> Request Canceled</span>' : '')); ?></div>
              </div>

              <div class="container align-items-center p-2 d-flex justify-content-between">
                <div>Status :</div>
                <div class="text-secondary"><span style="color: <?php echo ($values['driving_license'] == "" ? 'red' : 'green'); ?>"><?php echo ($values['driving_license'] == "" ? 'Incomplete' : 'Completed'); ?></span></div>
              </div>
            </div>
        <?php }
        }
        ?>
      </div>

    </div>
    <!-- Card End -->
  </div>




</div>

<!-- Modal Start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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