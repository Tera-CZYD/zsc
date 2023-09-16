<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.add('d-none'); // Add Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageEdit', 'medical employee profile/edit', currentUser);

</script>

<div class="row" id="pageEdit">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT MEDICAL EMPLOYEE PROFILE</div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.code">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> SEARCH EMPLOYEE </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> EMPLOYEE <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.MedicalEmployeeProfile.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.MedicalEmployeeProfile.employee_name }}</td>
                    <td style="{{ data.MedicalEmployeeProfile.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.MedicalEmployeeProfile.employee_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.MedicalEmployeeProfile.employee_name = null; data.MedicalEmployeeProfile.employee_id = null;" ng-init="data.MedicalEmployeeProfile.employee_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.address" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select selectize ng-options="opt.id as opt.value for opt in college" ng-model="data.MedicalEmployeeProfile.college_id" data-validation-engine="validate[required]" disabled>
                <option value=""></option></select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> GENDER <i class="required">*</i></label>
                <select class="form-control" ng-model="data.MedicalEmployeeProfile.gender" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> CIVIL STATUS <i class="required">*</i></label>
                <select class="form-control" ng-model="data.MedicalEmployeeProfile.civil_status" style="height: 45px" data-validation-engine="validate[required]" autocomplete="false">
                  <option></option>
                  <option value="Maried">Married</option>
                  <option value="Single">Single</option>
                </select>
              </div>
            </div>

            <!-- <div class="col-md-3 pull-right">
              <div class="form-group">
                <label> YEAR <i class="required">*</i></label>
                <select selectize ng-model="data.MedicalEmployeeProfile.year" data-validation-engine="validate[required]">
                  <option></option>
                  <option>First Year</option>
                  <option>Second Year</option>
                  <option>Third Year</option>
                  <option>Fourth Year</option>
                </select>
              </div>
            </div> -->

            <div class="col-md-3">
              <div class="form-group">
                <label> AGE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.age" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> HEIGHT <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.height" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> WEIGHT <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.weight" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div class="form-group">
                <label> RESPIRATORY SYSTEM </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.respiratory_system">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> FLOUROGRAPHY </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.flourography">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> LUNGS </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.lungs">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> HEART </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.heart">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> EYES </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.eyes">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> COLOR PRECEPTION </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.color_preception">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> VISION </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.vision">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> FAR RIGHT </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.far_right">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> LEFT </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.far_left">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div class="form-group">
                <label> BLOOD PRESSURE </label>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SYSTOLIC </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.systolic">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> DIASTOLIC </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.diastolic">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> PULSE </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.pulse">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> AGILITY TEST </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.agility_test">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> EARS </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.ears">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> HEARING </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.hearing">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> NOSE </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.nose">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> THROAT </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.throat">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> IMMUNIZATION </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.immunization">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> URINALYSIS </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.urinalysis">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SKIN </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.skin">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> NERVOUS SYSTEM </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.nervous_system">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> LOCOMOTION SYSTEM </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.locomotion_system">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> DIGESTIVE SYSTEM </label>
                <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.digestive_system"></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> GENITO-URINARY SYSTEM</label>
                <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.genito_urinary_system"></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> RECOMMENDATION </label>
                <textareA class="form-control" ng-model="data.MedicalEmployeeProfile.recommendation"></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> REMARKS </label>
                <textareA class="form-control" ng-model="data.MedicalEmployeeProfile.remarks"></textareA>
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <div class="form-group">
                <div class="header-title">MEDICAL HISTORY</div>
              <div class="clearfix"></div><hr>
              </div>
            </div>            

            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label>HAVE YOU HAD : </label>
                <div class="table-responsive px-5">

                  <table class="table">
                    <h6>Please Check each box if the answer is YES, leave blank if NO.</h6>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[0]">
                      </th>
                      <th>A recent physical exan</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[1]">
                      </th>
                      <th>Any heart problem</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[2]">
                      </th>
                      <th>High Blood pressure</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[3]">
                      </th>
                      <th>Low Blood pressure</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[4]">
                      </th>
                      <th>Circulatory Problems</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[5]">
                      </th>
                      <th>Nervous Problems </th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[6]">
                      </th>
                      <th>Radioation Treatments</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[7]">
                      </th>
                      <th>Excessive Bleeding</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[8]">
                      </th>
                      <th>Anemia</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[9]">
                      </th>
                      <th>Sinustis</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[10]">
                      </th>
                      <th>Diabetes</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[11]">
                      </th>
                      <th>Epilepsy</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[13]">
                      </th>
                      <th>Malignancies</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[14]">
                      </th>
                      <th>Rheumaic Fever</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[15]">
                      </th>
                      <th>Thyroid</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[16]">
                      </th>
                      <th>Tuberculosis</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[17]">
                      </th>
                      <th>Hepatitis</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.MedicalEmployeeProfile.have[18]">
                      </th>
                      <th>Venereal Disease</th>
                    </tr>
                    
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label> On previous visits : </label>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Have you had any outward reaction during or after other procedure? </h6>
                    <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.reaction_procedure"></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Were X-ray given? </h6>
                    <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.x_ray"></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Were there any special problems? </h6>
                    <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.special_problem"></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> ALLERGY TO: <br> Penicilin <br> Local Anesthetics(Novocain, Procaine, etc.) <br> Any other, specify </h6>
                    <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.allergy"></textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <h6> Please describe any current medical treatment, including drugs, impending operationsm pregnancies, or other <br> information regarding your present health health that the doctor should be aware of it  </h6>
                    <textarea class="form-control" ng-model="data.MedicalEmployeeProfile.current_medical_treatment"></textarea>
                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
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
                    <tr ng-repeat="data in applicationImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left"> <a href="{{ data.imageSrc }}">{{ data.name }}</a></td>
                      <td class="uppercase text-center">
                        <button class="btn btn-danger modal-form no-border-radius" ng-click="removeImage($index,data)"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                    <tr ng-if = "applicationImage == ''">
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
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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


          

