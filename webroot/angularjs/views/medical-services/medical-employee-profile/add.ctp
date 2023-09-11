<?php if (hasAccess('student log/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW MEDICAL EMPLOYEE PROFILE</div>
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
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.color_perception">
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

            <div class="col-md-3">
              <div class="form-group">
                <label> SITTING </label>
                <input type="text" class="form-control" ng-model="data.MedicalEmployeeProfile.sitting">
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
                      <th>A recent physical exam</th>

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
              <ul class="list-group mb-2">
                <div class="col-md-12">
                  <span class="btn btn-primary btn-min btn-file">
                    <i class="fa fa-upload"></i>UPLOAD FILE
                    <input ng-file-model="files" id="applicationImage" multiple="multiple" name="picture" class="form-control" type="file">
                  </span>
                </div>
              </ul>
            <div class="clearfix"></div>
            <div id="upload_prev"></div> 
            
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
          </div>

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
<div class="modal fade" id="searched-employee-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered vcenter table-striped table-condensed">
              <thead>
                <tr>
                  <th class="w30px">#</th>
                  <th class="text-center">EMPLOYEE NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="employee in employees">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ employee.code }}</td>
                  <td class="uppercase text-center">{{ employee.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="employee.selected = false" ng-model="employee.selected" name="iCheck" ng-selected="employee.selected = true" ng-change="selectedEmployee(employee)">
                  </td>
                </tr>
              </tbody>
              <tfoot ng-show="paginator.pageCount > 0">
                <tr>
                  <td colspan="4" class="text-center">
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center" ng-show="paginator.pageCount > 0">
                          <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>  
      </div> 

      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="employeeData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>

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

  document.getElementById('applicationImage').onchange = uploadOnChange;

  function uploadOnChange() {

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

          

