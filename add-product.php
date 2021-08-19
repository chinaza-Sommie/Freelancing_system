<?php
require 'header.php';
require 'sidebar.php';

if (!isset($_SESSION['counter']) || isset($_SESSION['counter']) && $_SESSION['counter'] == '0') {
  $url="upload_item.php";$opt="disabled";
  $option="";
}
if (isset($_SESSION['counter']) && $_SESSION['counter']==1) {
  $url="upload_item2.php";$opt="disabled";
  $option="";
}
if (isset($_SESSION['counter']) && $_SESSION['counter']==2) {
  $url="upload_item3.php";$opt="disabled";
  $option="";
}
if (isset($_SESSION['counter']) && $_SESSION['counter']==3) {
  $opt="";
  $option="disabled";
  $display="none";
  $status="";$stat="show active";
}else {
  $display="";
  $status="show active";$stat="";
}
if(isset($_GET['deleteImg'])){
  if ($_GET['deleteImg'] == 1) {
    if ($_SESSION['counter'] == 1) {
      $_SESSION['counter']=0;
      unlink('../../img/products/'.$_SESSION['img0']);
      unset($_SESSION['img0']);
      echo "<script>window.location = 'add-product.php'; </script>";
    }elseif ($_SESSION['counter'] == 2) {
      $_SESSION['img0'] = $_SESSION['img1'];
      $_SESSION['counter']=1;
      unlink('../../img/products/'.$_SESSION['img1']);
      unset($_SESSION['img1']);
      echo "<script>window.location = 'add-product.php'; </script>";
    }else {
      $_SESSION['img0'] = $_SESSION['img1'];
      $_SESSION['img1'] = $_SESSION['img2'];
      $_SESSION['counter']=2;
      unlink('../../img/products/'.$_SESSION['img2']);
      unset($_SESSION['img2']);
      echo "<script>window.location = 'add-product.php'; </script>";
    }
  }elseif ($_GET['deleteImg'] == 2) {
    if ($_SESSION['counter'] == 2) {
      $_SESSION['counter']=1;
      unlink('../../img/products/'.$_SESSION['img1']);
      unset($_SESSION['img1']);
      echo "<script>window.location = 'add-product.php'; </script>";
    }else {
      $_SESSION['img1'] = $_SESSION['img2'];
      $_SESSION['counter']=2;
      unlink('../../img/products/'.$_SESSION['img2']);
      unset($_SESSION['img2']);
      echo "<script>window.location = 'add-product.php'; </script>";
    }
  }else {
    $_SESSION['counter']=2;
    unlink('../../img/products/'.$_SESSION['img2']);
    unset($_SESSION['img2']);
    echo "<script>window.location = 'add-product.php'; </script>";
  }
}
?>
<!-- Load TinyMCE -->
<script src="<?php echo $hompage; ?>/js/tinymce-dist-master/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">
tinymce.init({
selector:'.tinymce',

plugins: 'lists link image code',
toolbar: 'undo redo | styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | link image | code',
theme: 'silver',
mobile: {
theme: 'mobile',
plugins: 'autosave lists autolink',
toolbar: 'undo bold italic styleselect'
},
lists_indent_on_tab: false
});
</script>
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <h4 class="page-title">Add Product</h4>
                    </div>
                </div>
                <center>
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link <?php echo $status ?>" id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true">STEP 1</a>
                      <a class="nav-item nav-link <?php echo $stat ?> <?php echo $opt ?>" id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="false">STEP 2</a>

                    </div>
                  </nav>
                </center>

<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade <?php echo $status ?>" id="step1" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
    <div class="form-group">
        <label>Product Images</label>
        <div>
          <a class="btn btn-rounded img-upload <?php echo $option ?>" data-toggle="modal" href="#change" style="background: url(../../img/1.jpg);
          background-size: cover;">
              <span class="btn-text">Upload image</span>
          </a>
            <small class="form-text text-muted">Max. file size: 50 MB. Allowed images: jpg, gif, png. Maximum 3 images only. you have <b>
              <?php if (isset($_SESSION['counter'])) {
              echo $_SESSION['counter'];
            }else {
               echo "0";
            } ?> images</b> </small>
        </div>
        <div class="row" id="review">
          <?php if (isset($_SESSION['img0'])): ?>
            <div class="col-md-3 col-sm-3 col-4 col-lg-3 col-xl-2">
              <?php $img0 = $_SESSION['img0']; ?>
                <div class="product-thumbnail">
  <img src="../../img/products/<?php echo $img0 ?>" class="img-thumbnail img-fluid" alt="">
                    <a onclick="Lobibox.confirm({title:'Delete Image',msg: 'Are you sure to delete?',callback: function($this, type, ev){ if(type == 'yes'){ window.location = '?deleteImg=1';}}});" href="javascript:void(0);"><span class="product-remove" title="remove"><i class="fa fa-close"></i></span></a>
                </div>
            </div>
          <?php endif; ?>
          <?php if (isset($_SESSION['img1'])): ?>
            <div class="col-md-3 col-sm-3 col-4 col-lg-3 col-xl-2">
              <?php $img1 = $_SESSION['img1']; ?>
                <div class="product-thumbnail">
  <img src="../../img/products/<?php echo $img1 ?>" class="img-thumbnail img-fluid" alt="">
                    <a onclick="Lobibox.confirm({title:'Delete Image',msg: 'Are you sure to delete?',callback: function($this, type, ev){ if(type == 'yes'){ window.location = '?deleteImg=2';}}});" href="javascript:void(0);"><span class="product-remove" title="remove"><i class="fa fa-close"></i></span></a>
                </div>
            </div>
          <?php endif; ?>
          <?php if (isset($_SESSION['img2'])): ?>
            <div class="col-md-3 col-sm-3 col-4 col-lg-3 col-xl-2">
              <?php $img2 = $_SESSION['img2']; ?>
                <div class="product-thumbnail">
  <img src="../../img/products/<?php echo $img2 ?>" class="img-thumbnail img-fluid" alt="">
                    <a onclick="Lobibox.confirm({title:'Delete Image',msg: 'Are you sure to delete?',callback: function($this, type, ev){ if(type == 'yes'){ window.location = '?deleteImg=3';}}});" href="javascript:void(0);"><span class="product-remove" title="remove"><i class="fa fa-close"></i></span></a>
                </div>
            </div>
          <?php endif; ?>
    </div>
  </div>
</div>
    </div>
  </div>
  <div class="tab-pane fade <?php echo $stat ?>" id="step2" role="tabpanel" aria-labelledby="nav-profile-tab">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <form role="form" class="was-validated" action="process-item.php" method="post">
                <div class="form-group">
                    <label>Product Name</label>
                    <input class="form-control" type="text" required="" name="proname">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Category</label>
                            <select class="select form-control" readonly>
                                <option selected>Product</option>
                            </select>
                        </div>
                    </div>
					<div class="col-md-6">
                                            <div class="form-group form-focus select-focus">
                                                <label class="focus-label">Product Status</label>
                                                <?php
                                                require 'statusSelect-options.php';
                                                 ?>
                                            </div>
                                        </div>
					<script type="text/javascript">
                                                                          var check = function() {
																			  var s_in_db = $("#category").val();
                                                                            if (s_in_db == '0') {
                                                                              $('#subCategory').html('<label>Sub Category</label><input class="form-control is-invalid" type="text" name="subCategory" placeholder="Please, type in the new category" focused style="min-width:150px"required>');
                                                                            } else {
                                                                              
                                                                              var t_in_db = $("#category").find("option:selected").text();
                                                                              $('#subCategory').html('<label>Sub Category</label><select readonly class="form-control select floating is-valid" name="subCategory" required><option value='+s_in_db+' selected>'+t_in_db+'</option></select>');

                                                                            }
                                                                          }
                                                                          </script>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Product Sub Category</label>
                            <select class="select form-control floating" required="" id="category" name="category" onkeyup="check()" onchange="check()">
                              <option value="" selected disabled>Choose category...</option>
							  <option value="0" style="background:black;color:#fff">Not in the options</option>
                              <?php
                              $query = "SELECT * FROM `product_category`";
                              $res_data = $conn->query($query);
                              if ($res_data->num_rows > 0) {
                                  // output data of each row
                                while($row = $res_data->fetch_assoc()) {
                                  $pctgy_id = $row['cty_id'];
                                  $pctgy_name = $row['cty_tittle'];
                                  $pctgy_slug = $row['cty_slug'];
                                   ?>
                                  <option value="<?php echo $pctgy_id; ?>"><?php echo $pctgy_name; ?></option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
					<div class="col-md-6">
                        <div class="form-group" id="subCategory">
                            
                        </div>
                    </div>
					<script src="../../js/jquery.stateLga.js"></script>
                            <script src="../../js/jquery.ucfirst.js"></script>
                               <div class="col-md-6">
                                   <div class="form-group form-focus">
                                       <label class="focus-label">States</label>
                                       <select class="select form-control floating" id="states"name="state"required>
                                       </select>
                                 </div>
                             </div>
                               <div class="col-md-6">
                                   <div class="form-group form-focus">
                                       <label class="focus-label">LGAs</label>
                                       <select class="select form-control floating"id="lgas" name="lga">
                                         </select>
                                   </div>
                               </div>
                </div>
				

                            <?php
                            if (!empty($state)) {
                              $s_opt=strtolower($state);
                            }else {
                              $s_opt="";
                            }
                            if (!empty($lga)) {
                              $l_opt=$lga;
                            } else {
                              $l_opt="";
                            }
                             ?>
                            <script>

                            var option = '';

                            var states=$.nigeria.states();
                            for (var i=0;i<states.length;i++){
                               option += '<option value="'+ states[i] + '">' + $.ucfirst(states[i]) + '</option>';
                            }
                            $('#states').append(option).on('change',function() {
								var s_opt = '<?php echo $s_opt; ?>';
                            var l_opt = '<?php echo $l_opt; ?>';
                            if(s_opt) {
								var option = '';
								option += '<option value="<?php echo $l_opt; ?>"><?php echo $l_opt; ?></option>';

								var lgas=eval('$.nigeria.'+this.value);

								for (var i=0;i<lgas.length;i++){
								   option += '<option value="'+ lgas[i] + '">' + $.ucfirst(lgas[i]) + '</option>';
								}

								$('#lgas').find('option')
									.remove()
									.end().append(option);

                            }else{
								var option = '';
								option += '<option value="">Local government</option>';

								var lgas=eval('$.nigeria.'+this.value);

								for (var i=0;i<lgas.length;i++){
								   option += '<option value="'+ lgas[i] + '">' + $.ucfirst(lgas[i]) + '</option>';
								}

								$('#lgas').find('option')
									.remove()
									.end().append(option);

							}
                            
                            }).trigger('change');
                            </script>
				
				
                <div class="form-group">
                    <label>Product Description</label>
                    <textarea  class="form-control tinymce" name="about"></textarea>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" placeholder="Enter the price"  class="form-control" required="" name="price">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" placeholder="Enter the Quantity"  class="form-control" required="" name="count">
                    </div>
                  </div>

                </div>

                <div class="m-t-20 text-center">
                  <input type="submit" class="btn btn-primary submit-btn" >
                </div>
            </form>
        </div>
    </div>
  </div>

</div>

            </div>
            <!-- Modal -->
            <div class="modal modal-adminpro-general modal-zoomInDown fade" id="change"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">


                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 style="color:red;"><span class="glyphicon glyphicon-lock"></span>Update Profile Image</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="panel panel-default">
                          <div class="panel-heading">Image Upload</div>
                          <div class="panel-body">


                            <div class="row">
                              <div class="col-md-12 text-center">
                              <div id="upload-demo" style="width:350px"></div>
                              </div>
                              <div class="col-md-12" style="padding-top:30px;">
                              <strong>Select Image:</strong>
                              <br/>
                              <input type="file" id="upload" class="form-control">
                              <br/>
                              <button id="upload-result" class="btn btn-success">Upload Image</button>
                              </div>
                              <div class="col-md-12" class="user-profile-img">
                              <div id="upload-demo-i" ></div>
                              </div>
                            </div>


                          </div>
                        </div>


                      <script type="text/javascript">
                      var upload_url = "<?php echo $url ?>"
                      $uploadCrop = $('#upload-demo').croppie({
                          enableExif: true,
                          viewport: {
                              width: 250,
                              height: 300,
                              type: 'square'
                          },
                          boundary: {
                              width: 400,
                              height: 400
                          }
                      });


                      $('#upload').on('change', function () {
                        var reader = new FileReader();
                          reader.onload = function (e) {
                            $uploadCrop.croppie('bind', {
                              url: e.target.result
                            }).then(function(){
                              console.log('jQuery bind complete');
                            });

                          }
                          reader.readAsDataURL(this.files[0]);
                      });


                      $('#upload-result').on('click', function (ev) {

                          var vidFileLength = $("#upload")[0].files.length;
                            if(vidFileLength === 0){
                              Lobibox.notify('warning', {position: 'top right',msg: 'No file selected.'});
                            }else{
                                $('#upload-result').addClass("disabled");
                        $uploadCrop.croppie('result', {
                          type: 'canvas',
                          size: 'viewport'
                        }).then(function (resp) {
                            $.ajax({
                              url: upload_url,
                              type: "POST",
                              data: {"image":resp},
                              success: function (data) {
                                location.reload();
                                }
                            });


                        });}
                      });


                      </script>

                    </div>


                    <div class="modal-footer">
                      <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php require 'notifications.php'; ?>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
	<script src="<?php echo $hompage; ?>/js/popper.min.js"></script>
    <script src="<?php echo $hompage; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $hompage; ?>/js/jquery.slimscroll.js"></script>
    <script src="<?php echo $hompage; ?>/js/select2.min.js"></script>
    <script src="<?php echo $hompage; ?>/js/tagsinput.js"></script>
    <script src="<?php echo $hompage; ?>/js/app.js"></script>
    <!-- notification JS
============================================ -->
<script src="<?php echo $hompage; ?>/js/Lobibox.js"></script>
<script src="<?php echo $hompage; ?>/js/notification-active.js"></script>
    <!-- bootstrap notify -->
    <script type="text/javascript" src="../js/bootstrap-notify.js"></script>
    <script type="text/javascript">


    var errcolor = "<?php echo $errtype; ?>";
      var error = "<?php echo $message; ?>";
    profilealert = {
      showNotification: function(from, align) {
        color = errcolor;

        $.notify({
          icon: "now-ui-icons fa fa-bell-o",
          message: error

        }, {
          type: color,
          timer: 8000,
          placement: {
            from: from,
            align: align
          }
        });
      }


    };
    </script>
    <script type="text/javascript">
    nowuiDashboard = {
      showNotification: function(type, error) {
        color = type;

        $.notify({
          icon: "now-ui-icons fa fa-bell-o",
          message: error

        }, {
          type: color,
          timer: 8000,
          placement: {
            from: 'top',
            align: 'center'
          }
        });
      }


    };
    </script>
</body>


<!-- add-blog23:57-->
</html>
