<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
define('_ROOT_DIRECTORY__login', 'http://localhost/buddies_holidays_vendor/');
// define('_ROOT_DIRECTORY__login', 'https://vendor.buddiesholidays.in/');
define('_ASSETS_DIR_login', _ROOT_DIRECTORY__login . 'assets/');
?>
<!DOCTYPE html>
<!-- Website - www.codingnepalweb.com -->
<html lang="en">

<head>
  <title>Buddies Holidays</title>
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_login; ?>css/jquery-confirm.min.css">
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_login; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_login; ?>css/jquery-ui.css">
  <link rel="icon" type="image/x-icon" href="<?php echo _ASSETS_DIR_login; ?>favicon.png" />
  <link rel="stylesheet" href="<?php echo _ASSETS_DIR_login; ?>css/bootstrap.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
</head>

<body>

  <div class="notification" id="notification">
    <?php echo (isset($error) ? $error : ''); ?>
  </div>

  <div class="container-fluid h-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col col-md-4 d-flex flex-column col-lg-6 col-xl-6 align-items-center gap-3 pt-5">
        <form method="post" action="<?php echo _ROOT_DIRECTORY__login; ?>index.php?action=login" class="login-form">
          <div class="logoImage">
            <img src="<?php echo _ROOT_DIRECTORY__login ?>assets/buddies_holidays_logo.png" alt="logo" />
          </div>

          <div class="form-group email">
            <label for="email" class="label">Email Address</label>
            <input type="text" id="email" class="inputemail" name="email" placeholder="Enter your email address" />
          </div>
          <div class="form-group password">
            <label for="password" class="label">Password</label>
            <input type="password" id="password" placeholder="Enter your password" name="passwd" class="inputPassword" />
            <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
          </div>

          <div class="flex-row justify-content-between">
            <div class="check-box">
              <input type="checkbox" />
              &nbsp;
              <label>Remember me </label>
            </div>
            <span class="span" data-bs-toggle="modal" data-bs-target="#exampleModal">Forgot password?</span>
            <!--        Modal  -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title text-danger fs-5" id="exampleModalLabel">
                      Forgot your password?
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <label for="inputState" class="form-label">Enter Your Email ID *
                    </label>
                    <h6 class="h6 mt-1 mb-4 text-danger-emphasis">
                      In order to receive your access code by email, please enter
                      the address you provided during the registration process.
                    </h6>

                    <div class="input">
                      <input type="email" class="form-control me-3" placeholder="Enter Your Email ID" name="email_forgot" id="email_forgot" />
                      <small class="error-text d-none" id="forgot-error">Enter a valid email address</small>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger send_email" data-loading-text="Loading..." onclick="forgot_password();">
                      Send
                    </button>
                    <img src="<?php echo _ASSETS_DIR_login; ?>load_search.gif" class="loading_email" style="width:35px;display:none;" alt="">

                  </div>
                </div>
              </div>
            </div>
            <!-- Modal End -->
          </div>

          <div class="form-group submit-btn">
            <button type="submit" class="btn">SUBMIT</button>
          </div>
        </form>

        <div class="text-md-justify text-center">
          ©Buddies Holidays™ 2017-2023 - All rights reserved
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo _ASSETS_DIR_login; ?>js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo _ASSETS_DIR_login; ?>js/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="<?php echo _ASSETS_DIR_login; ?>js/jquery-ui.js"></script>
  <script type="text/javascript" src="<?php echo _ASSETS_DIR_login; ?>js/jquery-confirm.min.js"></script>
  <script type="text/javascript" src="<?php echo _ASSETS_DIR_login; ?>js/script.js"></script>
  <script type="text/javascript" src="<?php echo _ASSETS_DIR_login; ?>js/fontawesome.js"></script>

  <script type="text/javascript">
    function forgot_password() {
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      var email = $('#email_forgot').val();
      if (!emailPattern.test(email)) {
        $('#forgot-error').removeClass('d-none');
        return false;
      } else {
        $('#forgot-error').addClass('d-none');
        $.ajax({
          url: '<?php echo _ROOT_DIRECTORY__login; ?>index.php?&action=forgot-password',
          type: 'POST',
          data: {
            email: email
          },
          beforeSend: function() {
            $(".send_email").text("Sending..").attr("disabled", "disabled");
            $(".loading_email").show();

          },
          success: function(response) {
            $(".loading_email").hide();
            $(".send_email").text("Send").removeAttr("disabled");
            var confirmation = $.confirm(response);

            if (confirmation) {
              $("#exampleModal").modal("hide");
            }
            console.log(response);
            //window.location.reload();
          },
          error: function(xhr, status, error) {
            console.error("Error:", status, error);
            $.alert(error);
          }
        });
      }
    }
  </script>

</body>

</html>