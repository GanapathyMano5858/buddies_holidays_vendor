<?php include 'header.php'; ?>
<style type="text/css">
  .view_bill:hover {
    cursor: pointer;

  }

  a.disabled {
    pointer-events: none;
    cursor: default;
  }

  .slideshow-container {
    max-width: 1000px;
    position: relative;
    margin: auto;
  }

  .adminpurchaserate label {
    margin-top: 5px;
  }

  .filedrf input[type="file"] {
    visibility: hidden;
  }

  .adminpurchaserate .filedrf input[type="file" i]:disabled {
    opacity: -0.6;
  }

  table.dataTable tbody tr.green,
  .bootstrap .table tbody>tr.green>td {
    background-color: #a5ffa5;
  }

  table.dataTable tbody tr.blue,
  .bootstrap .table tbody>tr.blue>td {
    background-color: #e3dae7;
  }

  table.dataTable tbody tr.orange,
  .bootstrap .table tbody>tr.orange>td {
    background-color: #ffdfa4;
  }

  table.dataTable tbody tr.yellow,
  .bootstrap .table tbody>tr.yellow>td {
    background-color: #fbfbcb;
  }

  .green {
    background-color: #a5ffa5 !important;
  }

  .blue {
    background-color: #e3dae7 !important;
  }

  .yellow {
    background-color: #fbfbcb !important;
  }


  .adminpurchaserate .filedrf label {
    padding: 5px 20px 5px 5px;
    color: #0f81dc;
    border-radius: 2px;
    text-align: center;
    float: left;
    cursor: pointer;
  }

  .adminpurchaserate .filedrf label i {
    font-size: 12px;
    position: absolute;
    right: 3px;
    top: 9px;
    content: "\F019 ";
  }

  .filedrf {
    /* display: inline-block; */
    width: 100px;
  }

  .filedrf label {
    position: absolute;
  }

  .prev,
  .nextt {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
  }

  .nextt {
    right: 0;
    border-radius: 3px 0 0 3px;
  }

  .prev:hover,
  .nextt:hover {
    background-color: rgba(0, 0, 0, 0.8);
  }

  .textt {
    color: black;
    font-size: 15px;
    padding: 8px 12px;
    background-color: white;
    bottom: 8px;
    width: 100%;
    text-align: center;
  }

  .dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
  }

  .active,
  .dot:hover {
    background-color: #717171;
  }

  /* Fading animation */
  .mySlides.fade {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
    opacity: 1 !important;
  }


  .quantity::-webkit-inner-spin-button,
  .quantity::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .shohi .raz {
    display: none;
  }

  .shohi .text {
    padding: 2px 14px;
    background-color: #0e7d13;
    color: #fff;
  }

  .shohi .text:hover,
  .shohi .raz:hover {
    cursor: pointer;
  }

  .print-clean {
    border: none;
    background: transparent;
    box-shadow: none !important;
    text-align: center;
    float: right;
  }

  .colmanagecar textarea {
    float: left;
    text-align: left;
  }

  .print-clean1 {
    border: 0;
    background: transparent;
    box-shadow: none !important;
    border-top: 1px solid black;
    max-width: 30px !important;
  }

  .jconfirm-box {
    width: 400px;
  }

  .show_query {
    position: relative;
    text-decoration: none !important;
    color: #555555 !important;
    font-weight: bold;

  }

  .show_query:hover .show_me {
    display: block;
    position: absolute;
    background-color: #515050;
    color: white;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    width: 200px;
    min-height: 50px;
    left: 10px;
    z-index: 1;
    padding: 10px 10px;
    word-break: break-all;
  }

  .show_me {
    display: none;
  }

  .show_query:hover .show_me::after {
    content: "";
    position: absolute;
    top: -9px;
    left: 11px !important;
    border-width: 5px;
    border-style: solid;
    border-color: transparent #ffffff00 #515050 transparent;
  }

  .raz {
    width: 60px;
    padding: 2px 8px;
  }

  button.buttons-html5 {
    border: none !important;
    padding: 0;
  }

  div.dt-button-background {
    background: none;
  }

  button.buttons-excel {
    padding: 0;
  }

  .buttons-excel {
    right: 60px;
  }

  .buttons-page-length {
    right: 100px;
  }

  .cancel td {
    background: #e4b7d8 !important;
  }

  .adminpurchaserate table input {
    width: 60px !important;
  }

  .adminpurchaserate table td textarea {
    width: 110px !important;
  }

  .adminpurchaserate tr tr td {
    min-width: 80px !important;
    padding: 6px 7px;
  }

  .adminpurchaserate tr tr th {
    min-width: 80px !important;
    padding: 6px 7px;
  }

  .adminpurchaserate table th {

    text-align: left !important;
  }

  .adminpurchaserate table td {
    text-align: left !important;
  }

  .redc {
    background-color: red !important;
    border: 1px solid red !important;

  }

  .greenc {
    background-color: green !important;
    border: 1px solid green !important;

  }

  .orangec {
    background-color: orange !important;
    border: 1px solid orange !important;
  }

  .color_field {
    position: relative;
    top: 20px;

  }

  .cvb {
    padding: 0 6px !important;
  }

  .sho {
    position: fixed;
    right: 50%;
    padding: 2px;
    color: #fff;
    top: 60%;
    text-align: center;
    width: 50px;
    z-index: 9999;
    display: none;
  }

  .table-word td {
    /* width: 8% !important; */
    word-break: inherit;
    ;
  }

  .container1 {
    resize: auto;
    padding: 3px 4px;
    margin-left: 16% !important;
  }


  .thumbnail {
    border: none !important;
    width: 40px;
    /* margin: 0px 10px;*/
    color: #040404;
    background: transparent !important;
    display: inline-block !important;
  }

  .noaction {
    opacity: .6;
    cursor: not-allowed !important;
    color: #7d7676 !important;
  }

  .removeFile {
    background: #93969e94;
    border-radius: 50%;
    padding: 0px 5px;
    color: #ffffff !important;
    font-weight: 600;
    position: relative;
    top: 3px;
    float: right;
  }

  .bootstrap output {
    display: table;
  }

  .uploadfilee {
    /*display: inline-block;*/
    margin: 5px 0px;
  }

  @media(width:320px) {
    .trname {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 100px !important;
    }
  }

  @media(max-width:699px) {
    .jconfirm-box {
      width: 285px;
    }

    .trname {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      width: 130px;
    }

    .ui-datepicker {
      z-index: 999 !important;
    }

    .raz {
      margin: 12px 0px;
    }

    .bot_button {
      text-align: right;
    }
  }

  @media (max-width:1024px) {
    .thumbnail {
      border: none !important;
      width: 100px;
      margin: 0px 10px;
      color: #040404;
    }

    .removeFile {
      background: #93969e94;
      border-radius: 50%;
      padding: 5px 10px;
      color: #ffffff !important;
      font-weight: 600;
      position: relative;
      top: 3px;
    }

    .adminpurchaserate output {
      display: inline-block;
    }

    .asr {
      color: #500606;
      float: left;
    }

    .cllr input[type="text"] {
      width: auto !important;
    }

    .cllr {
      color: #7d7d7d;
      float: right;
      font-size: 11px;
      clear: both;
    }

    .trname {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .sdf {
      clear: both;
      width: 100% !important;
    }

    .end-date {
      margin: 0px 2px;
    }

    .redc,
    .greenc {
      margin: 12px 0px;
    }

  }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $("input[name=type]").click(function() {
      $("#purchaseratebill").submit();
    });
    $(document).on('click', '.close', function() {
      // Find the closest modal and hide it
      $(this).closest('.modal').modal('hide');
    });
    $("#searchclient").click(function() {
      $("#purchaseratebill").submit();

    });

    $('#datatables').DataTable({});

  });

  function checkalphabetandnumber(value, id) {
    value = value.replace(/[^0-9]/g, "");
    $(id).val(value);
  }

  function showhide(dataid) {
    $(".parentdiv-" + dataid + ' .text').hide();
    $(".parentdiv-" + dataid + ' .raz').show();
    $(".parentdiv-" + dataid + ' button').attr("disabled", false);
    $(".disabled" + dataid).removeClass("disabled");
    $("#cal" + dataid + ", #remarks" + dataid + ", #bal_amount" + dataid + ",#total_km" + dataid + "#img_bil" + dataid + ", #img_feed" + dataid).removeClass('print-clean');
    $("#cal" + dataid + ", #remarks" + dataid + ", #bal_amount" + dataid + ",#total_km" + dataid).removeAttr('readonly');
    $(".img_bil" + dataid + ", .img_feed" + dataid).removeClass('noaction');
    $("#img_bil" + dataid + ", #img_feed" + dataid).removeAttr('disabled');

    $("#remarks" + dataid + ", #cal" + dataid + "#img_bil" + dataid + ", #img_feed" + dataid).removeClass('container2');
  }

  function dispalyImage(i, path_name, imageARRR) {

    if (imageARRR) {
      //var length_images=imageARRR.length;
      var length_images = Object.keys(imageARRR).length;

      $cont = "";
      var j = 0;

      $(".slideshow-container").html("");

      $(".imageModal").modal('show');


      $.each(imageARRR, function(name, imagess) {

        $cont += '<div class="mySlides fade image_slider hide" id="image_slider' + j + '" data-slide="' + j + '" style="width:100%;"><img src="https://admin.buddiesholidays.in/img/uploads/' + path_name + '/' + imagess + '" draggable=false style="width:100%;"><div class="textt" style="bottom: -29px;word-break: break-all;">' + ((typeof name == 'string') ? name : imagess) + '</div></div>';
        if (j == 0 && length_images > 1) {
          $cont += '<a class="prev" id="Previous" >&#10094;</a><a class="nextt" id="Nextt">&#10095;</a></div><br>';
        }
        $cont += '<div style="text-align:center"></div>';

        j++;

      });


      $(".slideshow-container").append($cont);
      // setTimeout(function(){   console.log("#image_slider"+i);
      var divItems = $('.imageModal .image_slider').length;

      $(".imageModal #image_slider" + i).removeClass('hide');
      $(".imageModal #image_slider" + i).addClass('active');
      $(".imageModal[data-dot='" + i + "']").addClass('active');
      if (i == 0) {
        $(".imageModal #Previous").addClass('hide');
      } else if (i == (divItems - 1)) {
        $(".imageModal #Nextt").addClass('hide');
        $(".imageModal #Previous").removeClass('hide');
      }

      //},500);
      $(".imageModal .dot").click(function() {
        var dotno = parseInt($(this).data("dot"));
        $(".image_slider").addClass('hide');
        $(".imageModal #image_slider" + dotno).removeClass('hide');
        $(".imageModal #image_slider" + dotno).addClass('active');

      });

      $(".imageModal #Nextt").click(function() {

        $(".image_slider").each(function() {
          if ($(this).hasClass('active')) {
            var divno = parseInt($(this).data("slide"));
            divno++;
            if (divno == 0) {
              $(".imageModal #Previous").addClass('hide');
            } else if (divno == (divItems - 1)) {
              $(".imageModal #Nextt").addClass('hide');
              $(".imageModal #Previous").removeClass('hide');
            } else {

              $(".imageModal #Previous").removeClass('hide');

            }

            $(".image_slider").removeClass('active');
            $(".imageModal .dot").removeClass('active');
            $(".image_slider").addClass('hide');
            $(".imageModal #image_slider" + divno).removeClass('hide');
            $(".imageModal #image_slider" + divno).addClass('active');
            $(".imageModal[data-dot='" + divno + "']").addClass('active');
            return false;

          }
        });
      });

      $(".imageModal #Previous").click(function() {

        $(".image_slider").each(function() {
          if ($(this).hasClass('active')) {
            var divno = parseInt($(this).data("slide"));
            divno--;
            if (divno == 0) {
              $(".imageModal #Previous").addClass('hide');
              $(".imageModal #Nextt").removeClass('hide');
            } else if (divno == (divItems - 1)) {
              $(".imageModal #Nextt").addClass('hide');
              $(".imageModal #Previous").removeClass('hide');
            } else {
              $(".imageModal #Nextt").removeClass('hide');
              $(".imageModal #Previous").removeClass('hide');

            }

            $(".image_slider").removeClass('active');
            $(".imageModal[data-dot='" + divno + "']").removeClass('active');
            $(".image_slider").addClass('hide');
            $(".imageModal #image_slider" + divno).removeClass('hide');
            $(".imageModal #image_slider" + divno).addClass('active');
            $(".imageModal[data-dot='" + divno + "']").addClass('active');
            return false;

          }
        });
      });


    }
  }
  $(document).ready(function() {
    if ($("input[name='type']:checked").val() != 5) {
      $('#date_div').css('display', 'block');

    } else {
      $('#date_div').css('display', 'none');
    }
    $("input[name='type']").change(function() {
      if ($(this).val() != 5) {
        $('#date_div').css('display', 'block');

      } else {
        $('#date_div').css('display', 'none');
      }
    });

    $(document).on("click", ".removeFile", function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
    });
    $("#min-date").datepicker({
      changeMonth: true,
      changeYear: true,
      //yearRange:"-1:+1",
      dateFormat: 'dd/mm/yy',
      onSelect: function(dateText, inst) {
        $("#max-date").datepicker("option", "minDate",
          $("#min-date").datepicker("getDate"));
      }

    });

    $('#max-date').datepicker({
      changeMonth: true,
      changeYear: true,
      // yearRange:"-1:+1",
      dateFormat: 'dd/mm/yy'
    });
  });
  $(document).ready(function() {
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    console.log(width);
    //if(width<1440){
    if (width < 1366) {
      var searchTemplate = '<div class="input-group" style="padding:10px;"><span class="input-group-addon"><i class="fas fa-search"></i></span><input type="text" class="form-control"></div>';
      $(".datagrid").sieve({
        itemSelector: "li",
        searchTemplate: searchTemplate
      });
    }
    setTimeout(function() {
      $('.view_bill').click(function() {
        var data = $(this).attr('data');
        $('.img' + data).trigger('click');
      });
      initializeViewer();
    }, 1000);
    $("#datatables").on("click", ".view_bill", function() {
      var data = $(this).attr('data');
      $('.img' + data).trigger('click');
      initializeViewer();
    });


  });


  function Add(va_id, id_client, type, trip_went_not) {

    var bill_amount = $("#bal_amount" + id_client + va_id).val();
    var total_km = $("#total_km" + id_client + va_id).val();
    var cal = $("#cal" + id_client + va_id).val();
    var bill_img = $("#img_bil" + id_client + va_id).val();
    var feed_img = $("#img_feed" + id_client + va_id).val();
    var arrcont_bill = [];
    $("#result" + id_client + va_id + " p").each(function() {

      arrcont_bill.push($(this).html());
    });
    var arrcont_feed = [];
    $("#result_feed" + id_client + va_id + " p").each(function() {
      // if($(this).html()!= '')
      //   {
      //     var extension_f='';
      //     var image_content_f=$(this).html();
      //         extension_f = image_content_f.split('.').pop().toLowerCase();
      //     if(jQuery.inArray(extension_f, ['gif','png','jpg','jpeg']) == -1)
      //  {
      //   $.alert("Invalid Feedback Image File");
      //   return false;
      //  }
      //  }
      arrcont_feed.push($(this).html());
    });

    if (bill_amount.trim() === "" || cal.trim() === "" || total_km.trim() === "") {

      $.alert("Fill Out the Fields");
    } else if ((bill_img == '' && type == 'add' && trip_went_not != 2) || (arrcont_bill == '' && trip_went_not != 2)) {
      $.alert("Upload Bill");
    } else if ((feed_img == '' && type == 'add' && trip_went_not != 2) || (arrcont_feed == '' && trip_went_not != 2)) {
      $.alert("Upload Feedback");
    } else {
      var formData = new FormData();
      var files_bill = $("#img_bil" + id_client + va_id)[0].files;
      for (var i = 0; i < files_bill.length; i++) {
        console.log(files_bill[i]);
        formData.append('img_bil[]', files_bill[i]);
      }

      var files_feed = $("#img_feed" + id_client + va_id)[0].files;
      for (var i = 0; i < files_feed.length; i++) {
        console.log(files_feed[i]);
        formData.append('img_feed[]', files_feed[i]);
      }
      formData.append("bill_amount", bill_amount);
      formData.append("total_km", total_km);
      formData.append("va_id", va_id);
      formData.append("id_client", id_client);
      formData.append("cal", cal);
      formData.append("type", type);
      for (var key of formData.entries()) {
        console.log(key[0] + ', ' + key[1]);
      }

      $.ajax({
        url: '<?php echo _ROOT_DIRECTORY_; ?>index.php?&action=PurchaseRateAdd',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          console.log(response);
          $.alert(response);
          //window.location.reload();
        },
        error: function(xhr, status, error) {
          console.error("Error:", status, error);
          $.alert(error);
        }
      });

      // /

    }

  }
</script>

<body>
  <div class="">
    <form id="purchaseratebill" method="post" action="">
      <p class="m-0">Transport &nbsp; / &nbsp; Add Purchase Bill</p>
      <div class="notification" id="notification" style="display:none;">
        <?php echo (isset($_GET['error']) ? $_GET['error'] : ''); ?>
      </div>
      <div class="alert alert-success" id="notification_success" style="display:none;">
        <?php echo (isset($_GET['success']) ? $_GET['success'] : ''); ?>
      </div>

      <div class="p-3 border rounded">
        <!-- <div class="row justify-content-end mb-4">
          <div class="col-lg-1">
            <a href="AddPurchaseBill.html">
              <button type="button" class="btn btn-secondary">
                <i class="fa-solid fa-rotate"></i>
              </button>
            </a>
          </div>
        </div> -->

        <div class="row justify-content-between  align-items-center">
          <div class="btn-group col-lg-2" role="group" aria-label="Basic radio toggle button group">
           
          <input class="btn-check" type="radio" id="btnradio1" name="type" value="5" checked />
            <label class="btn btn-outline-danger" for="btnradio1">Add</label>

            <input type="radio" class="btn-check" id="btnradio2" name="type" value="3" <?php echo (isset($response['searchType']) && $response['searchType'] == 3) ? 'checked' : ''; ?> />
            <label class="btn btn-outline-danger" for="btnradio2">Added</label>
          </div>
          <div id="date_div" style="display: none;" class="col-lg-8 flex-row ">
          <div class="col-lg-1">
            <label for="min-date" class="form-label text-nowrap ">Start Date:</label>
          </div>
            <div class="col-lg-3">
              <input type="text" class="form-control" id="min-date" name="min-date" autocomplete="off" value="<?php echo isset($response['searchFrom']) ? $response['searchFrom'] : ''; ?>" autocomplete="off" />
            </div>
            <div class="col-lg-1">
              <label for="max-date" class="form-label text-nowrap ">End Date:</label>
            </div>
            <div class="col-lg-3">
              <input type="text" class="form-control" id="max-date" name="max-date" autocomplete="off" value="<?php echo isset($response['searchTo']) ? $response['searchTo'] : ''; ?>" autocomplete="" />
            </div>
          </div>

          <div class="col-lg-2 custom-btn">
            <input type="button" class="form-control btn btn-outline-danger mt-md-4 mb-md-3" id="searchclient" name="searchclient" value="Search" />
          </div>
        </div>

        <?php if ($response['mobile'] == 0) { ?>

          <!-- table Start -->
          <div class="table-responsive table">
            <table class="table table-striped table-hover table-borderless " id="datatables">
              <thead class="text-center ">
                <tr>
                  <th style="display:none;">S.no</th>
                  <th>S.no</th>
                  <th>BH Ref No</th>
                  <th class="text-nowrap ">Client Name</th>

                  <th>
                    <table class="w-100" style="margin-bottom:0 !important" ;>
                      <thead id="scroll" class="text-center ">
                        <tr>


                          <th>Trip Date</th>
                          <th >Vehicle Remark</th>

                          <th style="width: 85px;">
                            <table class="w-100" style="margin-bottom:0 !important;">
                              <thead id="scroll">
                                <tr>
                                  <th class="text-nowrap " >Trip Advance</th>

                                </tr>
                              </thead>
                            </table>
                          </th>

                          <th class="text-nowrap">Bill Amount </th>
                          <th class="text-nowrap">Calculation</th>
                          <th class="text-nowrap">Upload Bill</th>
                          <th class="text-nowrap">Upload Feedback</th>
                          <th class="text-nowrap">Added Date</th>
                          <th class="text-nowrap">Rejected Remark</th>
                          <th class="text-nowrap">Images</th>
                          <th class="text-nowrap">Action</th>
                          <th class="text-nowrap">Total KM </th>

                        </tr>
                      </thead>
                    </table>
                  </th>
                </tr>
              </thead>
              <tbody id="tablecontent">
                <?php echo $response['content']; ?>


              </tbody>
            </table>
          </div>
        <?php } ?>
        <!-- table End -->
        <?php if ($response['mobile'] == 1) { ?>

          <!-- Grid Start -->
          <div class="grid-responsive clearfix">
            <ul class="datagrid row list-unstyled">
              <?php echo $response['content']; ?>

            </ul>

          </div>
        <?php } ?>
        <!-- Grid End -->

      </div>
    </form>
  </div>
  <div class="overlayss __web-inspector-hide-shortcut__">
    <div class="loader-box">
      <div id="loader-2">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <div class="loading" data-name="Loading">Please Wait....</div>
      </div>
    </div>
  </div>

  <div class="modal fade imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="width: 80%; margin:0 auto;">
        <div class="modal-header">
          <button type="button" class="close clst" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title text-center" id="myModalLabel">Image Slider</h4>
        </div>
        <div class="modal-body">
          <div class="slideshow-container">

          </div>
        </div>
      </div>
    </div>

    <script>
      // Initialize date picker
      //   $("#datepicker").datepicker();

      // Function to toggle date picker visibility


      var textarea = document.querySelector('textarea');

      textarea.addEventListener('keydown', autosize);

      function autosize() {
        var el = this;
        setTimeout(function() {
          el.style.cssText = 'height:auto; padding:0';
          // for box-sizing other than "content-box" use:
          // el.style.cssText = '-moz-box-sizing:content-box';
          el.style.cssText = 'height:' + el.scrollHeight + 'px';
        }, 0);
      }

      function removePic(input, label) {
        var inputNames = $(input).attr("id");
        if (label == 'result') {
          var split_str = "img_bil";

        } else {
          var split_str = "img_feed";
        }
        var splitfunc = inputNames.split(split_str);

        $('#' + label + splitfunc[1]).html('');

        $('#' + inputNames).val("");
      }

      function showPreview(input, label) {
        if (window.File && window.FileList && window.FileReader) {

          var filesInput = input;
          var inputName = $(input).attr("id");
          if (label == 'result') {
            var split_str = "img_bil";
          } else {
            var split_str = "img_feed";
          }
          var splitfunc = inputName.split(split_str);

          //var files = event.target.files; //FileList object
          var files = filesInput.files;

          var output = document.getElementById(label + splitfunc[1]);
          // $('#result'+splitfunc[1]).html('');
          for (var i = 0; i < files.length; i++) {

            var file = files[i];
            console.log(file);
            //Only pics
            if (!file.type.match('image')) {
              $.alert("Invalid Image File");
              return false;
            } else if (file.size > 20000000) {
              $.alert("File size is greater then 20 MB");
              return false;

            }
            //     continue;
            // <img class="thumbnail" src="'+ e.target.result +'" title="'+ files[j].name +'" style="width:50%;">
            (function(j) {
              var reader = new FileReader()
              reader.onload = function(e) {
                var div = document.createElement('div');
                div.classList.add('uploadfilee');
                div.innerHTML = '<a class="removeFile" href="javascript:void(0);" data-fileid=' + j + ' >X</a><p style="display:none;">' + files[j].name + ' </p><span class="thumbnail"> ' + files[j].name.substring(0, 5) + '... </span>';

                output.insertBefore(div, null);
              }
              reader.readAsDataURL(files[j])
            })(i);
          }

        } else {
          console.log('Your browser does not support File API');
        }

      }
    </script>
</body>

</html>