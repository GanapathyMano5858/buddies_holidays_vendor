<?php
include "header.php";
?>
<script type="text/javascript">
  $(function() {
    $('#mobile').keyup(function() {
      var val = $(this).val();
      val = val.replace(/[^0-9]+/, '');
      $(this).val(val);
    });
    $('#firstname').keyup(function() {
      var val = $(this).val();
      val = val.replace(/[^\w\s]/gi, '');
      $(this).val(val);
    });
    $('#lastname').keyup(function() {
      var val = $(this).val();
      val = val.replace(/[^\w\s]/gi, '');
      $(this).val(val);
    });
  });

  function validateform(e) {
    //e.preventDefault();
    var errorMsg = '';
    if (!$("#firstname").val()) {
      errorMsg += 'Please Enter Firstname<br>';
    }
    if (!$("#email").val()) {
      errorMsg += 'Please Enter Email Address<br>';
    }
    if (!$("#mobile").val()) {
      errorMsg += 'Please Enter Contact No<br>';
    }
    if (!$("#password").val()) {
      errorMsg += 'Please Enter Change Password<br>';
    }
    if (!$("#confirm_password").val()) {
      errorMsg += 'Please Enter Confirm Password<br>';
    }
    if ($("#password").val() !== $("#confirm_password").val()) {
      errorMsg += 'Change Password and Confirm Password Doesn\'t Match<br>';
    }
    if (errorMsg !== '') {
      $.alert(errorMsg);
      return false;
    } else {
      return true;
    }

  }
</script>
<div class="container-lg container-fluid pt-4">
      <p style="font-size: 13px;" class="page-head m-0 pb-2"><ul class="breadcrumb page-breadcrumb">
    <li class="breadcrumb-container">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=GetCount">Buddies Holidays&nbsp;&nbsp;
    </a>
    </li>
    <li class="breadcrumb-current">
    <a class="text-decoration-none text-dark" href="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-profile">/&nbsp;&nbsp;My Account 
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
  <div class="p-4 border rounded-4">
    <div class="row align-items-center">
      <div class="col-3 text-nowrap">
        <span> <i class="fa-solid fa-user text-danger"></i></span>
        &nbsp;
        <span>Profile Update</span>
      </div>

    </div>
    <div class="border rounded-4 p-3 mt-3">
      <form class="p-0 w-100" method="post" action="<?php echo _ROOT_DIRECTORY_; ?>index.php?action=update-profile" onsubmit="return validateform(event);">
        <div class="row row-gap-3">
          <input type="hidden" name="id_employee" value="<?php echo (isset($response['id_employee']) ? $response['id_employee'] : '') ?>">
          <div class="col-lg-4 col-md-6 mb-md-3 mb-lg-0">
            <label for="inputState" class="form-label">First Name</label><span class="text-danger"> *</span>
            <input type="text" id="firstname" name="firstname" class="form-control me-3" placeholder="Enter Your First Name" value="<?php echo (isset($response['firstname']) ? $response['firstname'] : '') ?>" />
          </div>

          <div class="col-lg-4 col-md-6 mb-md-3 mb-lg-0">
            <label for="inputState" class="form-label">Last Name</label>
            <input type="text" id="lastname" name="lastname" class="form-control me-3" placeholder="Enter Your Last Name" value="<?php echo (isset($response['lastname']) ? $response['lastname'] : '') ?>" />
          </div>

          <div class="col-lg-4 col-md-6 mb-md-3 mb-lg-0">
            <label for="inputState" class="form-label">Contact Number</label><span class="text-danger"> *</span>

            <div class="input">
              <input maxlength="10" id="mobile" type="number" name="mobile" class="form-control me-3" placeholder="Enter Your Contact Number" value="<?php echo (isset($response['mobile']) ? $response['mobile'] : '') ?>" />
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-md-3 mb-lg-0">
            <label for="inputState" class="form-label">Email Address</label><span class="text-danger"> *</span>
            <input type="email" name="email" id="email" class="form-control me-3" placeholder="Enter Your Email Address" value="<?php echo (isset($response['email']) ? $response['email'] : '') ?>" />
          </div>

          <div class="col-lg-4 col-md-6 mb-md-3 mb-lg-0">
            <label for="inputState" class="form-label">Change Password</label><span class="text-danger"> *</span>

            <div class="input">
              <input name="password" id="password" type="text" class="form-control me-3" placeholder="Enter New Password" value="<?php echo (isset($response['password_custom']) ? base64_decode($response['password_custom']) : '') ?>" />
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-md-3 mb-lg-0">
            <label for="inputState" class="form-label">Confirm Password</label><span class="text-danger"> *</span>

            <div class="input">
              <input type="password" id="confirm_password" name="confirm_password" class="form-control me-3" value="<?php echo (isset($response['password_custom']) ? base64_decode($response['password_custom']) : '') ?>" />
            </div>
          </div>
        </div>

        <div class="row justify-content-around mt-3">
          <div class="col-3 text-nowrap">
            <button type="button" onclick="window.location.href='<?php echo _ROOT_DIRECTORY_;?>index.php?action=GetCount'" class="btn btn-outline-danger me-5">
              <i class="fa-regular fa-circle-xmark"></i>
              &nbsp; CANCEL
            </button>
          </div>
          <div class="col-3 text-nowrap">
            <button type="submit" class="btn btn-outline-success">
              <i class="fa-solid fa-paper-plane"></i>
              &nbsp; SUBMIT
            </button>
          </div>
        </div>
    </div>
    </form>
  </div>
</div>
</div>
</body>

</html>