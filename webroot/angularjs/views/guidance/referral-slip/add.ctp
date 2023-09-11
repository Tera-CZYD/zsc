<?php if (hasAccess('referral slip/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">ADD NEW REFERRAL SLIP </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
          	<div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. <i class="required">*</i></label>
                <input disabled type="text" class="form-control" ng-model="data.ReferralSlip.code" data-validation-engine="validate[required]">
              </div>
            </div>

          	<div class="col-md-6">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.ReferralSlip.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.ReferralSlip.student_name }}</td>
                    <td style="{{ data.ReferralSlip.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.ReferralSlip.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.ReferralSlip.student_name = null; data.ReferralSlip.student_id = null;" ng-init="data.ReferralSlip.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.ReferralSlip.date" data-validation-engine="validate[required]">
              </div>
            </div>

           <!--  <div class="col-md-12">
              <div class="form-group">
                <label> COURSE <i class="required">*</i></label>
                <select class="form-control"  ng-model="data.ReferralSlip.course_id" ng-options="opt.id as opt.value for opt in course" ng-change="getCourse(data.ReferralSlip.course_id)"
                data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div> -->

            <div class="col-md-12">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-options="opt.id as opt.value for opt in college_program" ng-model="data.ReferralSlip.course_id" ng-change="getCourse(data.ReferralSlip.course_id)" data-validation-engine="validate[required]">
                <option value=""></option></select>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <label> YEAR LEVEL <i class="required">*</i></label>
                <select class="form-control" ng-model="data.ReferralSlip.year" data-validation-engine="validate[required]">
                  <option value=""></option>
                  <option value="First Year">First Year</option>
                  <option value="Second Year">Second Year</option></option>
                  <option value="Third Year">Third Year</option>
                  <option value="Fourth Year">Fourth Year</option>
               </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> REASON <i class="required">*</i></label>
                <select class="form-control" ng-model="data.ReferralSlip.reason" data-validation-engine="validate[required]">
                 <option value=""></option>
                 <option value="Absenteeism">Absenteeism</option>
                 <option value="Tardiness">Tardiness</option></option>
                 <option value="Cutting Classes">Cutting Classes</option>
                 <option value="Incomplete Grades">Incomplete Grades</option>
                 <option value="Failing Grades">Failing Grades</option>
                 <option value="Family Problem">Family Problem</option>
                 <option value="Smoking">Smoking</option>
                 <option value="Forgery">Forgery</option>
                 <option value="Fist Fighting">Fist Fighting</option>
                 <option value="Slandering">Slandering</option>
                 <option value="Stealing">Stealing</option>
                 <option value="Dating">Dating</option>
                 <option value="Cheating">Cheating</option>
                 <option value="Vandalism">Vandalism</option>
                 <option value="Others, please specify">Others, please specify</option>
               </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group" ng-show = "data.ReferralSlip.reason == 'Others, please specify' ">
                <label> OTHERS <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.ReferralSlip.others" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group" ng-show = "data.ReferralSlip.reason == 'Absenteeism' ">
                <label> REMARKS <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.ReferralSlip.remarks" data-validation-engine="validate[required]">
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
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>


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


          

