<?php include "header.php";

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

  function limitNumberLength4(input) {
    // Remove any non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, "");

    // Limit the length to 2 digits
    if (input.value.length > 4) {
      input.value = input.value.slice(0, 2);
    }
  }

  function limitDigits(input, maxDigits) {
    // Use a regular expression to keep only the first maxDigits digits
    var value = input.value.replace(/\D/g, ""); // Remove non-digit characters
    input.value = value.substring(0, Math.min(value.length, maxDigits));
  }


  // Mano End



  //   $(function(){ 
  // $('#vehicle_year').keyup(function() {
  //     var val = $(this).val();
  //     val = val.replace(/[^0-9]+/, '');
  //     $(this).val(val);
  // });
  // });
  // $(function(){ 
  // $('#vehicle_no,#vehicle_no3').keyup(function() {
  //     var val = $(this).val();
  //     val = val.replace(/[^A-Z]+/, '');
  //     $(this).val(val);
  // });
  // });
  // $(function(){ 
  // $('#vehicle_no2,#vehicle_no4').keyup(function() {
  //     var val = $(this).val();
  //     val = val.replace(/[^0-9]+/, '');
  //     $(this).val(val);
  // });
  // });
  function validateform(e) {
    e.preventDefault();
    var errorMsg = '';
    if (!$("#vehicle_type").val()) {
      errorMsg += 'Please select vehicle type<br>';
    }
    if (!$('#vehicle_no').val() || !$('#vehicle_no2').val() || !$('#vehicle_no3').val() || !$('#vehicle_no4').val()) {
      errorMsg += 'Enter Vehicle No<br>';
    }
    if (!$("#vehicle_year").val()) {
      errorMsg += 'Please Enter vehicle Manufactured Year<br>';
    }

    if (errorMsg !== '') {
      $.alert(errorMsg);
      return false;
    } else {
      var val = $('#vehicle_no').val() + $('#vehicle_no2').val() + $('#vehicle_no3').val() + $('#vehicle_no4').val();
      var no = val.replace(/\s/g, '');
      var id = $('#v_id').val();
      var transporter_id = $('#transporter_id').val();
      $.ajax({
        url: "<?php echo _ROOT_DIRECTORY_; ?>index.php?action=CheckalreadyVehicle",
        data: {
          no: no,
          transporter_id: transporter_id,
          id: id
        },
        type: 'POST',
        async: false,
        success: function(res) {
          if (res == 2) {
            $.alert('Transporter Can\'t add more than one vehicle');
            return false;
          } else if (res == 1) {
            $.alert('This Vehicle already Exists');
            return false;
          } else {
            $('#submitvehicle').css('disabled', true);
            document.getElementsByName("vehicle_form")[0].submit();

          }


        }

      });
    }

  }
</script>
<div class="container-sm pt-4 hg250">
  <p class="m-0" style="font-size: 14px;">Transport / Add Vehicle / Add New Vehicle</p>
  <?php if (isset($_GET['v_id']) && $_GET['v_id']) {
    $action = 'addVehicle-update';
  } else {
    $action = 'addVehicle-submit';
  }
  ?>
  <div class="p-4 border rounded-4">
    <div class="row align-items-center">
      <div class="col-lg-2">
        <p>Vehicle Details</p>
      </div>
    </div>
    <form method="post" action="<?php echo _ROOT_DIRECTORY_ . 'index.php?action=' . $action; ?>" onsubmit="return validateform(event);" name="vehicle_form" style="display: block; width: auto">
      <input type="hidden" name="v_id" id="v_id" value="<?php echo (isset($response['vehicleList']['v_id']) ? $response['vehicleList']['v_id'] : ''); ?>">

      <input type="hidden" name="transporter_id" id="transporter_id" value="<?php echo (isset($response['vehicleList']['transporter_id']) ? $response['vehicleList']['transporter_id'] : $_SESSION['trans_vendor_id']); ?>">

      <div class="row">
        <div class="col-lg-3 mb-3 mb-lg-0">
          <label for="vehicle_type" class="form-label">Vehicle Type</label>
          <span class="text-danger"> *</span>
          <select id="vehicle_type" class="form-select" name="vehicle_type">
            <option value="">Select vehicle Type</option>
            <?php foreach ($response['vehicleType'] as $type) {
              echo '<option value="' . $type['vt_id'] . '" ' . (isset($response['vehicleList']['vehicle_type_name']) && $response['vehicleList']['vehicle_type_name'] == $type['vehicle_type_name'] ? 'selected' : '') . '
                    >' . $type['vehicle_type_name'] . '</option>';
            } ?>
          </select>
        </div>
        <?php
        if (isset($response['vehicleList']['vehicle_no'])) {
          $ve = explode(' ', $response['vehicleList']['vehicle_no']);
        }
        ?>
        <div class="col-lg-5 mb-2 mb-lg-0">
          <label class="form-label">Vehicle No. </label>
          <span class="text-danger"> *</span>
          <div class="input-group mb-3">
            <input type="text" class="text-uppercase form-control me-3" placeholder="TN" maxlength="2" name="vehicle_no" id="vehicle_no" oninput="validateText(this)" />
            <input type="number" class="text-uppercase form-control me-3" placeholder="44" maxlength="2" name="vehicle_no2" id="vehicle_no2" oninput="limitNumberLength(this)" />
            <input type="text" class="text-uppercase form-control me-3" placeholder="EN" maxlength="2" id="vehicle_no3" name="vehicle_no3" oninput="validateText(this)" />
            <input type="text" class="form-control me-3 text-uppercase" placeholder="4487" maxlength="4" id="vehicle_no4" name="vehicle_no4" oninput="limitNumberLength4(this)" />
          </div>
          <!-- <div class="clearfix"> </div>
          <em class="emnoteclass">Only Capital Letters and numbers allowed</em> -->
        </div>

        <div class="col-lg-4 mb-2 mb-lg-0">
          <label for="vehicle_year" class="form-label">Year of Vehicle Manufactured </label>
          <span class="text-danger"> *</span>
          <div class="input">
            <input type="text" class="form-control me-3" placeholder="Enter Manufactured Year" id="vehicle_year" name="vehicle_year" maxlength="4" oninput="limitNumberLength4(this)" />
          </div>
        </div>
      </div>

      <div class="row mt-2 mt-lg-5 justify-content-evenly">
        <div class="col-lg-2 mb-3 mb-lg-0">
          <div class="input">
            <button type="button" class="form-control btn btn-outline-danger" onclick="window.location.href='<?php echo _ROOT_DIRECTORY_; ?>index.php?action=get-vehicleList'">
              <i class="fa-solid fa-circle-xmark"></i>
              &nbsp; CANCEL
            </button>
          </div>
        </div>
        <div class="col-lg-2">
          <div class="input">
            <button type="submit" id="submitvehicle" class="form-control btn btn-success ">
              <i class="fa-regular fa-paper-plane"></i>
              &nbsp; SUBMIT
            </button>
          </div>
        </div>
      </div>

  </div>
  </form>
</div>


</body>

</html>