<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT MEMORANDUM</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label> Title <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Memorandum.title" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.Memorandum.date" data-validation-engine="validate[required]">
              </div>
            </div>
            <h6> Display to:  <i class="required">*</i></h6>
            <div class="col-md-12">
              
              <div class="form-group col-md-3" ng-repeat="role in roles"  ng-if="role.id!=1">
                  <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Memorandum.receiver[$index]"><span class="font-weight-normal"> {{role.value}}</span>
              </div>
            </div> 
            <div class="col-md-12 mb-2">
              <button class="btn btn-primary btn-min btn-file" ng-click="addImage()"><i class="fa fa-upload"></i> UPLOAD FILE </button>
            </div>
            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-left" colspan="4">UPLOADED FILES</th>
                    </tr>
                    <tr>
                      <th class="w30px text-center">#</th>
                      <th class="text-center">FILE NAME</th>
                      <th class="text-center" style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="data in memorandumImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left"> <a href="{{ data.imageSrc }}">{{ data.name }}</a></td>
                      <td class="uppercase text-center">
                        <button class="btn btn-danger modal-form no-border-radius" ng-click="removeImage(data)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                    <tr ng-if = "memorandumImage == ''">
                      <td class="text-center" colspan="3">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> 
            
          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
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
<style>
  .imagewrap {display:inline-block;position:relative;}
</style>

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
                <i class="fa fa-upload"></i> UPLOAD FILE
                <input ng-file-model="files" id="memorandumImage" multiple="multiple" name="picture" class="form-control" type="file">
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