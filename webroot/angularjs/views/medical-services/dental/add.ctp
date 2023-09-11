<?php if (hasAccess('dental/add', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">NEW DENTAL </div>  
          <div class="clearfix"></div>
          <hr>
          <form id="form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label> CONTROL NO. </label>
                  <input disabled type="text" class="form-control" ng-model="data.Dental.code"> 
                </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                <label> CLASSIFICATION <i class="required">*</i></label>
                <select class="form-control" autocomplete="false" ng-model="data.Dental.classification" ng-change="getMember(data.Dental.classification)" ng-init="data.Dental.classification = 'Student'" data-validation-engine="validate[required]">
                  <option value="Student">Student</option>
                  <option value="Employee">Employee</option>
                </select>
              </div>
            </div>
              <div class="col-md-6" ng-show="data.Dental.classification == 'Student'">
                <div class="form-group">
                  <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                  <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
                </div>
              </div>
              <div class="col-md-6" ng-show="data.Dental.classification == 'Student'">
                <div class="form-group">
                  <label> STUDENT <i class="required">*</i></label>
                  <table class="table table-bordered">
                    <tr>
                      <td style="{{ data.Dental.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.Dental.student_name }}</td>
                      <td style="{{ data.Dental.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.Dental.student_name == undefined">
                        <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.Dental.student_name = null; data.Dental.student_id = null;" ng-init="data.Dental.student_id = null"><i class="fa fa-times"></i></button>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>

            <div class="col-md-6" ng-show="data.Dental.classification == 'Employee'">
              <div class="form-group">
                <label> SEARCH EMPLOYEE </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.Dental.classification == 'Employee'">
              <div class="form-group">
                <label> EMPLOYEE <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.Dental.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.Dental.employee_name }}</td>
                    <td style="{{ data.Dental.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.Dental.employee_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.Dental.employee_name = null; data.Dental.employee_id = null;" ng-init="data.Dental.employee_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label> PROGRAM <i class="required">*</i></label>
                  <select selectize ng-model="data.Dental.course_id" ng-options="opt.id as opt.value for opt in course" ng-change="getCourse(data.Dental.course_id)" data-validation-engine="validate[required]">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label> AGE <i class="required">*</i></label>
                  <input type="text" class="form-control" number="true" autocomplete="false" ng-model="data.Dental.age" data-validation-engine="validate[required]">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label> YEAR LEVEL <i class="required">*</i></label>
                  <select class="form-control" ng-model="data.Dental.year" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                    <option value=""></option>
                    <option value="First Year">First Year</option>
                    <option value="Second Year">Second Year</option>
                    </option>
                    <option value="Third Year">Third Year</option>
                    <option value="Fourth Year">Fourth Year</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label> DATE <i class="required">*</i></label>
                  <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.Dental.date" data-validation-engine="validate[required]">
                </div>
              </div>
              <div class="col-md-12 mt-4">
                <div class="form-group">
                  <label> Medical History <i class="required">*</i></label>
                  <!-- <input icheck type="checkbox" ng-true-value="true" ng-false-value = "false" ng-model="data.Dental.med"> -->
                  <div class="table-responsive px-5">
                    <table class="table">
                      <h6>Have you had...</h6>
                      <tr>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.exam">
                        </th>
                        <th>A recent physical exam</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.sin">
                        </th>
                        <th>Sinusitis</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.hea">
                        </th>
                        <th>Any heart problem</th>
                      </tr>
                      <tr>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.dia">
                        </th>
                        <th>Diabetes</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.high">
                        </th>
                        <th>High blood pressure</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.epi">
                        </th>
                        <th>Epilepsy</th>
                      </tr>
                      <tr>
                        <th> <input icheck type="checkbox" class="form-control" ng-value-true="true" autocomplete="false" ng-model="data.Dental.low">
                        </th>
                        <th>Low blood pressure</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.mal">
                        </th>
                        <th>Malignancies</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.cir">
                        </th>
                        <th>Circulatory Problems</th>
                      </tr>
                      <tr>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.rheu">
                        </th>
                        <th>Rheumatic fever</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.nerv">
                        </th>
                        <th>Nervous problems</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.thy">
                        </th>
                        <th>Thyroid</th>
                      </tr>
                      <tr>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.rad">
                        </th>
                        <th>Radiation Treatments</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.tb">
                        </th>
                        <th>Tuberculosis</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.ex">
                        </th>
                        <th>Excessive breathing</th>
                      </tr>
                      <tr>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.hep">
                        </th>
                        <th>Hepatitis</th>
                        <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.ane">
                        </th>
                        <th>Anemia</th>
                        <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.Dental.ven">
                        </th>
                        <th>Venerial disease</th>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          
          <div class="clearfix"></div>
          <hr>

          <!-- upload button -->
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            <div class="col-md-12">
              <ul class="list-group mb-2">
                <div class="col-md-12">
                  <span class="btn btn-primary btn-min btn-file">
                    <i class="fa fa-upload"></i>UPLOAD FILE
                    <input ng-file-model="files" id="dentalImage" multiple="multiple" name="picture" class="form-control" type="file">
                  </span>
                </div>
              </ul>
            <div class="clearfix"></div>
            <div id="upload_prev"></div> 
            
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
          </form>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-right">
                <button class="btn btn-primary btn-min" id="save" ng-click="saveImages(files);save();"><i class="fa fa-save"></i> SAVE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<div class="modal fade" id="searched-student-modal">
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
                  <th class="text-center">STUDENT NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="student in students">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ student.code }}</td>
                  <td class="uppercase text-center">{{ student.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="student.selected = false" ng-model="student.selected" name="iCheck" ng-selected="student.selected = true" ng-change="selectedStudent(student)">
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
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="studentData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
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

  document.getElementById('dentalImage').onchange = uploadOnChange;

  function uploadOnChange() {

    var filename = this.value;

    var lastIndex = filename.lastIndexOf("\\");

    if (lastIndex >= 0) {

      filename = filename.substring(lastIndex + 1);

    }

    var files = $('#dentalImage')[0].files;

    for (var i = 0; i < files.length; i++) {

      $("#upload_prev").append('<span><u>'+'<div class="filenameupload">'+files[i].name+'</u></div>'+'<p id = "close" class="btn btn-danger xbutton fa fa-times" style "background-color :red !important"></p></span>');
    
    }
  }
  
</script>