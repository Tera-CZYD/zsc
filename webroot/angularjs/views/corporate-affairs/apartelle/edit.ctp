<?php if (hasAccess('apartelle/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT APARTELLE/DORMITORY</div>
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
                <button class="btn btn-primary btn-min btn-file" ng-click="addImage()"><i class="fa fa-upload"></i> UPLOAD IMAGE </button>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>

            <div class="col-md-12 table-wrapper">
              <div class="col-md-4" ng-repeat="image in apartelleImage">
                  <img src="{{ image.imageSrc }}" width="100%" height="100%" style="border-radius : 2px; margin-bottom : 10px; z-index: : 1; ">
                  <input ng-click="removeImage(image)" type="button" class=" btn btn-danger xbutton fa fa-times" value="X"/>
              </div>
            </div>


          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php endif ?>

<div class="modal fade" id="edit-upload-image" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus"></i>ADD FILE</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <center>
            <ul class="list-group">
              <span class="btn btn-primary btn-min btn-file">
                <i class="fa fa-upload"></i> UPLOAD IMAGE
                <input ng-file-model="files" id="apartelleImage" multiple="multiple" name="picture" class="form-control" type="file">
              </span>
            </ul>
          </center>
        </div>
        <div class="clearfix"></div>
        <div id="upload_prev"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveImages(files)">ADD</button>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>

<style>
  .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px 3px;
  }
  .fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    background-color:#fff;
    filter: alpha(opacity=0);
  }

  .filenameupload {
    width:100%;  
    overflow-y:auto;
  }

  #upload_prev {
    font-size: 
    width: 50%;
    padding:0.5em 1em 1.5em 1em;
  }

  #upload_prev span {
    display: flex;
    padding: 0 5px;
    font-size:14px;
  }

  p.close {
    cursor: pointer;
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
</script>  

<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }

  .imagewrap {display:inline-block;position:relative;}
  .xbutton {position:absolute;top:5px;right:10px;}
</style>