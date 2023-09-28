<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW MEMORANDUM</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">

            <div class="clearfix"></div>
            

            <div class="col-md-12">
              <div class="form-group">
                <label> Title <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Memorandum.title" data-validation-engine="validate[required]">
              </div>
            </div>
            <h6> Display to:  <i class="required">*</i></h6>
            <div class="col-md-12">
              
              <div class="form-group col-md-3" ng-repeat="role in roles"  ng-if="role.id!=1">
                  <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Memorandum.receiver[$index]"><span class="font-weight-normal"> {{role.value}}</span>
              </div>
            </div>            

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-12">
              <ul class="list-group mb-2">
                <div class="col-md-12">
                  <span class="btn btn-primary btn-min btn-file">
                    <i class="fa fa-upload"></i>UPLOAD FILE
                    <input ng-file-model="files" id="memorandumImage" multiple="multiple" name="picture" class="form-control" type="file">
                  </span>
                </div>
              </ul>
            <div class="clearfix"></div>
            <div id="upload_prev"></div> 
            
          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="saveImages(files);save();"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
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

<style type="text/css">
  .myRadio{
    height:20px; 
    width:20px;
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
    width:50%;  
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
    font-size:13px;
  }

  p.close {
    cursor: pointer;
  }

</style>

<script>
  $(document).on('click','#close',function(){
    $(this).parents('span').remove();

  })

  document.getElementById('memorandumImage').onchange = uploadOnChange;

  function uploadOnChange() {

    var filename = this.value;

    var lastIndex = filename.lastIndexOf("\\");

    if (lastIndex >= 0) {

      filename = filename.substring(lastIndex + 1);

    }

    var files = $('#memorandumImage')[0].files;

    for (var i = 0; i < files.length; i++) {

      $("#upload_prev").append('<span><u>'+'<div class="filenameupload">'+files[i].name+'</u></div>'+'<p id = "close" class="btn btn-danger xbutton fa fa-times" style "background-color :red !important"></p></span>');
    
    }
  }
  
</script>