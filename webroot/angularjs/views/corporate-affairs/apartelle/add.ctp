<?php if (hasAccess('apartelle/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW APARTELLE/DORMITORY</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.Apartelle.code">
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label> BUILDING NO. <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Apartelle.building_no" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> ROOM NO. <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Apartelle.room_no" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> PRICE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" decimal ng-model="data.Apartelle.price" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> CAPACITY <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Apartelle.capacity" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DESCRIPTION <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.Apartelle.description" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-3">
              <center>
                <ul class="list-group">
                  <span class="btn btn-primary btn-block btn-sm btn-file">
                  <!-- onchange="readURL(this)" -->
                    UPLOAD IMAGE
                    <input id="apartelleImage" ng-file-model="files"  multiple="multiple"  name="picture" class="form-control" type="file" accept="image/gif, image/jpeg, image/png">
                  </span>
                </ul>
              </center>
            </div>

            <div class="col-md-3">
              <center>
                <ul class="list-group">
                  <span class="btn btn-primary btn-block btn-sm btn-file" ng-click="resetImages()" onclick="myFunction()">
                    RESET IMAGE 
                  
                  </span>
                </ul>
              </center>
            </div>

            <div class="clearfix"></div>
            <!-- <div class="col-md-12 table-wrapper" ng-repeat="file in files"> -->
            <div class="col-md-12 table-wrapper">
                <!-- <img src="assets/img/logo.1.png" width="481" height="300" class="img-thumbnail">
                <label>{{ file.name }}</label> -->
                <div class="gallery" id="asd"></div>
            </div>


          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();saveImages(files)"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>

<script>

  $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

      if (input.files) {
          var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
          var reader = new FileReader();

          reader.onload = function(event) {
            $($.parseHTML('<img>'))
            .attr('src', event.target.result)
            .width(200)
            .height(200)
            .css("border-radius"," 2px")
            .css("margin-bottom"," 10px")
            .css("margin-top"," 10px")
            .css("margin-left"," 10px")
            .appendTo(placeToInsertImagePreview);
          }

          reader.readAsDataURL(input.files[i]);
        }
      }

    };

    $('#apartelleImage').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
  });

  function myFunction() {
    document.getElementById("asd").innerHTML = " " ;
  }
  
</script>