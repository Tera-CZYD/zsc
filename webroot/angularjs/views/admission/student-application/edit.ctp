<?php if (hasAccess('student application/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW STUDENT APPLICATION</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> STUDENT ID NUMBER <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.student_no" data-validation-engine="validate[required]" disabled>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> FIRST NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.first_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> MIDDLE NAME </label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.middle_name">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> LAST NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.last_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> AUXILLIARY NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.auxilliary_name" >
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> DATE OF BIRTH <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.StudentApplication.birth_date" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> PLACE OF BIRTH <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.birth_place" data-validation-engine="validate[required]">
              </div>
            </div>
              <div class="col-md-3">
              <div class="form-group">
                <label> NATIONALITY <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.nationality" data-validation-engine="validate[required]">
              </div>
            </div>
              <div class="col-md-3">
              <div class="form-group">
                <label> ETHNIC GROUP <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.ethnic_group" >
              </div>
            </div>
              <div class="col-md-3">
              <div class="form-group">
                <label> RELIGION <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.religion" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> EMAIL <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.email" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.address" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> CONTACT NO. <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.contact_no" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> GENDER <i class="required">*</i></label>
                <select class="form-control" ng-model="data.StudentApplication.gender" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> CIVIL STATUS <i class="required">*</i></label>
                <select class="form-control" ng-model="data.StudentApplication.civil_status" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Maried">Maried</option>
                  <option value="Single">Single</option>
                </select>
              </div>
            </div>
          <div class="col-md-6">
              <div class="form-group">
                <label> NAME OF PARENTS OR GUARDIAN <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> RELATIONSHIP <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_relationship" data-validation-engine="validate[required]">
              </div>
            </div>
          <div class="col-md-3">
              <div class="form-group">
                <label> CONTACT NO. PARENTS/GUARDIAN <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_contact" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> OCCUPATION OF PARENTS/GUARDIAN <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_occupation" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> COMPLETE ADDRESS OF PARENTS/GUARDIAN <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.guardian_address" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select id="college" class="form-control" ng-model="data.StudentApplication.college_id" ng-options="opt.id as opt.value for opt in colleges" data-validation-engine="validate[required]" ng-change="getProgram(data.StudentApplication.college_id)">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> PREFERRED PROGRAM <i class="required">*</i></label>
                <select id="college" class="form-control" ng-model="data.StudentApplication.preferred_program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> SECONDARY PROGRAM <i class="required">*</i></label>
                <select id="college" class="form-control" ng-model="data.StudentApplication.secondary_program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> LAST SCHOOL ATTENDED <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.last_school" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> LAST SCHOOL ATTENDED ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.last_school_address" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> 1ST SEMESTER GRADE OR GWA <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.grade" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> TYPE OF STUDENT <i class="required">*</i></label>
                <select class="form-control" ng-model="data.StudentApplication.student_type" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="New">New</option>
                  <option value="Transferee">Transferee</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> HIGHSCHOOL CURRICULUMN  <i class="required">*</i></label>
                <select class="form-control" ng-model="data.StudentApplication.curriculumn" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="ALS">ALS</option>
                  <option value="BEC">BEC</option>
                  <option value="K-12">K-12</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> YEAR GRADUATED <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.year_graduated" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SCHOOL TYPE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.school_type" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> MEMBERSHIP SCHOOL CLUBS, ORGANIZATIONS OR FRATERNITIES <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.StudentApplication.frat" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-12 mb-2">
              <button class="btn btn-primary btn-min btn-file" ng-click="addImage()"><i class="fa fa-upload"></i> UPLOAD FILE </button>
            </div>
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
                    <tr ng-repeat="data in applicationImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left"> <a href="{{ data.imageSrc }}">{{ data.name }}</a></td>
                      <td class="uppercase text-center">
                        <button class="btn btn-danger modal-form no-border-radius" ng-click="removeImage(data)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                    <tr ng-if = "applicationImage == ''">
                      <td class="text-center" colspan="3">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
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

  $(document).on('click','#close',function(){

    $(this).parents('span').remove();

  })

  document.getElementById('applicationImage').onchange = uploadOnChange;
  function uploadOnChange() {
    // document.getElementById("uploadFile").value = this.value;
    var filename = this.value;
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    var files = $('#applicationImage')[0].files;
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
                <input ng-file-model="files" id="applicationImage" multiple="multiple" name="picture" class="form-control" type="file">
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