<?php
include "header.php";
?>
<script type="text/javascript">
  // Mano

  // Text Only
  function validateText(input) {
    // Use a regular expression to check if the input contains only letters and spaces
    var isValid = /^[A-Za-z\s]+$/.test(input.value);

    // If the input is not valid, clear the input value
    if (!isValid) {
      input.value = input.value.replace(/[^A-Za-z\s]/g, "");
    }
  }

  // Number Only
  function limitNumberLength(input) {
    // Remove any non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, "");

    // Limit the length to 2 digits
    if (input.value.length > 2) {
      input.value = input.value.slice(0, 2);
    }
  }

  function limitNumberLength10(input) {
    // Remove any non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, "");

    // Limit the length to 10 digits
    if (input.value.length > 10) {
      input.value = input.value.slice(0, 2);
    }
  }

  function limitDigits(input, maxDigits) {
    // Use a regular expression to keep only the first maxDigits digits
    var value = input.value.replace(/\D/g, ""); // Remove non-digit characters
    input.value = value.substring(0, Math.min(value.length, maxDigits));
  }


// Aadhaar Card

function limitNumberLength12(input) {
    // Remove any non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, "");

    // Limit the length to 10 digits
    if (input.value.length > 10) {
      input.value = input.value.slice(0, 2);
    }
  }


  // function addSpaces() {
  //     var input = document.getElementById('aadhaar');
  //     var value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
  //     var formattedValue = '';

  //     for (var i = 0; i < value.length; i++) {
  //       if (i > 0 && i % 4 === 0) {
  //         formattedValue += ' ';
  //       }
  //       formattedValue += value[i];
  //     }

  //     input.value = formattedValue;
  //   }


  // Mano Driving License
  // Javascript program to validate
  // License Number  using Regular Expression

  // Function to validate the
  // license_Number  
  function isValid_License_Number(license_Number) {
    // Regex to check valid
    // license_Number  
    let regex = new RegExp(/^(([A-Z]{2}[0-9]{2})( )|([A-Z]{2}-[0-9]{2}))((19|20)[0-9][0-9])[0-9]{7}$/);

    // if license_Number 
    // is empty return false
    if (license_Number == null) {
      return "false";
    }

    // Return true if the license_Number
    // matched the ReGex
    if (regex.test(license_Number) == true) {
      return "true";
    } else {
      return "false";
    }
  }

  // End driving_license



  // Mano End




  function checkalready() {
    console.log('checkalready');
    var id = $('#id_driver').val();
    var name = $('#driver_name').val();
    var no = $('#contact_no').val();
    $.ajax({
      url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?action=CheckalreadyDriver",
      data: {
        name: name,
        no: no,
        id: id
      },
      type: 'POST',
      success: function(res) {
        console.log(res);
        if (res) {
          $('#driver_status').html('ok');
          $.alert('This Driver Account already Exists');
          return false;
        } else {
          $('#driver_status').html('');

        }


      }

    });

  }

  function validateform(e) {
    e.preventDefault();
    var errorMsg = '';
    var mobile = $('#contact_no').val();
    var alternate = $('#contactalterno').val();
    var vehiclenohtml = document.getElementById("driver_status").innerHTML;

    if (!$('#driver_name').val()) {
      errorMsg = 'Please enter driver name\n';
      $.alert(errorMsg);
      return false;
    } else if (mobile.length != 10) {

      errorMsg = 'Please enter valid contact number\n';
      $.alert(errorMsg);
      return false;
    } else if (alternate.length != 10) {
      errorMsg = 'Please enter valid alternate contact number\n';
      $.alert(errorMsg);
      return false;
    } else if (alternate == mobile) {
      errorMsg = 'Contact number and alternate contact number cann\'t be same\n';
      $.alert(errorMsg);
      return false;
    } else if (!$('#driving_license').val()) {
      errorMsg = 'Please enter drivering License number\n';
      $.alert(errorMsg);
      return false;
    }

    if (vehiclenohtml == 'ok') {
      $.alert('This Driver Account already Exists');
      return false;

    } else {
      $('#submitdriver').css('disabled', true);
      document.getElementsByName("driver_form")[0].submit();
    }

  }
  $(function() {
    $('#driving_license').keyup(function() {
      var val = $(this).val();
      val = val.replace(/[^A-Z0-9]/, '');
      $(this).val(val);
    });
  });
  $(function() {
    $('#aadhaar, #contact_no, #contactalterno').on('keyup', function() {
      var val = $(this).val();
      val = val.replace(/[^0-9]+/, '');
      $(this).val(val);
    });
  });
</script>
<div class="container-sm pt-4 hg250">
  <p class="m-0" style="font-size: 14px;">Transport / Add Driver / Add New Driver</p>
  <?php if (isset($_GET['id_driver']) && $_GET['id_driver']) {
    $action = 'addDriver-update';
  } else {
    $action = 'addDriver-submit';
  }
  ?>
  <div class="p-4 border rounded-4">
    <div class="row align-items-center">
      <div class="col-5">
        <p>Driver Details</p>
      </div>
    </div>
    <form method="post" action="<?php echo _ROOT_DIRECTORY_ . 'index.php?action=' . $action; ?>" onsubmit="return validateform(event);" name="driver_form" style="display: block; width: auto">
      <span id='driver_status'></span>
      <input type="hidden" name="id_driver" id="id_driver" value="<?php echo (isset($response['driverList']['id_driver']) ? $response['driverList']['id_driver'] : ''); ?>">

      <input type="hidden" name="transporter_id" id="transporter_id" value="<?php echo (isset($response['driverList']['transporter_id']) ? $response['driverList']['transporter_id'] : $_SESSION['trans_vendor_id']); ?>">
      <div class="row">
        <div class="col-lg-4 mb-2 mb-lg-0">
          <label for="inputState" class="form-label">Driver Name</label><span class="text-danger"> *</span>
          <input type="text" class="form-control me-3 text-uppercase " placeholder="Enter Driver Name" id="driver_name" name="driver_name" oninput="validateText(this)" value="<?php echo (isset($response['driverList']['driver_name']) ? $response['driverList']['driver_name'] : ''); ?>" />
        </div>

        <div class="col-lg-4 mb-2 mb-lg-0">
          <label for="inputState" class="form-label">Driver Contact Number</label><span class="text-danger"> *</span>
          <input type="text" class="form-control me-3" placeholder="Enter Your Driver Number" id="contact_no" name="contact_no" value="<?php echo (isset($response['driverList']['contact_no']) ? $response['driverList']['contact_no'] : ''); ?>" onblur="checkalready();" maxlength="10" oninput="limitNumberLength10(this)" />
        </div>

        <div class="col-lg-4 mb-2 mb-lg-0">
          <label for="inputState" class="form-label">Alternate Contact Number </label><span class="text-danger"> *</span>

          <div class="input">
            <input maxlength="10" type="text" class="form-control me-3" placeholder="Enter Alternate Contact No" id="contactalterno" name="contactalterno" value="<?php echo (isset($response['driverList']['contactalterno']) ? $response['driverList']['contactalterno'] : ''); ?>" oninput="limitNumberLength10(this)" />
          </div>
        </div>
      </div>

      <div class="row mt-lg-3">
        <div class="col-lg-4 mb-2 mb-lg-0">
          <label for="inputState" class="form-label">Driving License</label><span class="text-danger"> *</span>
          <input type="text" class="form-control me-3" placeholder="Enter Your Driver Number" id="driving_license" name="driving_license" value="<?php echo (isset($response['driverList']['driving_license']) ? $response['driverList']['driving_license'] : ''); ?>" oninput="isValid_License_Number(this)" />
          <div class="clearfix"> </div>
          <em class="emnoteclass">Only Capital Letters and numbers allowed</em>
        </div>

        <div class="col-lg-4 mb-2 mb-lg-0">
          <label for="inputState" class="form-label">Aadhaar Number</label><span class="text-danger"> *</span>

          <div class="input">
            <input maxlength="12" type="text" class="form-control me-3" placeholder="Enter Aadhaar Number" id="aadhaar" name="aadhaar" value="<?php echo (isset($response['driverList']['aadhaar']) ? $response['driverList']['aadhaar'] : ''); ?>" oninput="limitNumberLength12(this)" />
          </div>
        </div>
      </div>

      <div class="row mt-2 mt-lg-4 justify-content-evenly">
        <div class="col-lg-2 mb-3 mb-lg-0">
          <div class="input">
            <input maxlength="10" type="button" value="CANCEL" onclick="window.location.href='<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-driverList'" class="form-control btn btn-outline-danger" />
          </div>
        </div>
        <div class="col-lg-2">
          <div class="input">
            <input maxlength="10" type="submit" value="SUBMIT" id="submitdriver" class="form-control btn btn-danger" />
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</body>

</html>