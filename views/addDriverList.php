<?php
include "header.php";
//  echo '<pre>';
// print_r($response);
// echo '</pre>';
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#driverTable').DataTable({
      lengthMenu: [
        [-1],
        ['All']
      ],
      dom: 'Blfrtip',
      buttons: [{
        extend: 'excel',
        className: 'custom-excel-button margin',
        text: '<button class="btn btn-sm btn-outline-success">Download &nbsp;<i class="fa-solid fa-download"></i></button>',
        // text: '<img src="./assets/excel.png" alt="Excel" style="width: 48px;">',
        title: 'Driver List'

      }],
    });
  });

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
<div class="container p-4">
  <p class="m-0" style="font-size: 14px;">Transport / Add Driver</p>
  <div class="notification" id="notification" style="display:none;">
    <?php echo (isset($_GET['error']) ? $_GET['error'] : ''); ?>
  </div>
  <div class="alert alert-success" id="notification_success" style="display:none;">
    <?php echo (isset($_GET['success']) ? $_GET['success'] : ''); ?>
  </div>

  <div class="p-3 border rounded">
      <div class="col-lg-1 col-md-2 position-relative" >
        <a href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=addDriver">
          <button type="button" class="btn btn-sm btn-primary button">
            Add &nbsp;
            <i class="fa-solid fa-circle-plus"></i>
          </button>
        </a>
      </div>

    <div class="table-responsive table" style="position: relative;
    top: -40px;">
      <table id="driverTable" class="table table-striped table-hover table-borderless ">
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
              <td class="align-middle"><?php echo ($values['status'] == 4 ? 'Request Send' : ($values['status'] == 5 ? 'Request Canceled' : '')); ?></td>
              <td class="align-middle"><?php echo ($values['status'] == 3 ? 'Request Send' : ($values['status'] == 6 ? 'Request Canceled' : '')); ?></td>
              <td class="align-middle" style="color: <?php echo ($values['driving_license'] == "" ? 'red' : 'green'); ?>">
                <?php echo ($values['driving_license'] == "" ? 'Incomplete' : 'Completed'); ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Card Start -->
    <div class="row justify-content-start d-none">
      <div class="col-lg-3">
        <label for="inputState" class="form-label">Quick Search</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="quickSearch" onkeyup="quickSearch('driverListTable');" />
        </div>
      </div>
    </div>
    <div class="d-lg-none" id="driverListTable">
      <?php $i = 0;
      foreach ($response['driverList'] as $values) {
        $i++;
      ?>
        <br>
        <div class="cards border">
          <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
            <div>Driver Name :</div>
            <div class="text-secondary"><?php echo $values['driver_name']; ?></div>
          </div>

          <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
            <div>Driver Contact No. :</div>
            <div class="text-secondary"><?php echo $values['driver_contact']; ?>&nbsp;/&nbsp;<?php echo $values['driver_alternate']; ?></div>
          </div>

          <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
            <div>Driving License :</div>
            <div class="text-secondary"><?php echo $values['driving_license']; ?></div>
          </div>

          <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
            <div>View :</div>

            <div>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-primary btn-sm" onclick="viewdriver(<?php echo $values['id_driver']; ?>)">
                <i class="fa-solid fa-eye"></i>
              </button>

            </div>
          </div>

          <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
            <div>Edit :</div>
            <div>
              <?php if (!in_array($values['status'], [1, 3, 6])) : ?>
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
            <div class="text-secondary"><?php echo ($values['status'] == 4 ? 'Request Send' : ($values['status'] == 5 ? 'Request Canceled' : '')); ?></div>
          </div>

          <div class="container border-bottom align-items-center p-2 d-flex justify-content-between">
            <div>Active Status</div>
            <div class="text-secondary"><?php echo ($values['status'] == 3 ? 'Request Send' : ($values['status'] == 6 ? 'Request Canceled' : '')); ?></div>
          </div>

          <div class="container align-items-center p-2 d-flex justify-content-between">
            <div>Status :</div>
            <div class="text-secondary"><?php echo ($values['driving_license'] == "" ? 'Incomplete' : 'Completed'); ?></div>
          </div>
        </div>
      <?php } ?>
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