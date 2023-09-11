<?php if (hasAccess('learning resource member/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT MEMBER</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.LearningResourceMember.code">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> LIBRARY ID NUMBER <i class="required">*</i></label>
                <input type="text"class="form-control"  ng-model="data.LearningResourceMember.library_id_number" autocomplete="off" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> PATRON TYPE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.LearningResourceMember.classification" data-validation-engine="validate[required]" ng-change="clearData(data.LearningResourceMember.classification)">
                  <option value=""></option>
                  <option value="STUDENT">STUDENT</option>
                  <option value="FACULTY">FACULTY</option>
                  <option value="ADMIN">ADMIN STAFF</option>
               </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.LearningResourceMember.classification == 'STUDENT'">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.LearningResourceMember.classification == 'STUDENT'">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.LearningResourceMember.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.LearningResourceMember.student_name }}</td>
                    <td style="{{ data.LearningResourceMember.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.LearningResourceMember.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.LearningResourceMember.student_name = null; data.LearningResourceMember.student_id = null;" ng-init="data.LearningResourceMember.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-6" ng-show="data.LearningResourceMember.classification == 'FACULTY'">
              <div class="form-group">
                <label> SEARCH FACULTY </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE FACULTY HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.LearningResourceMember.classification == 'FACULTY'">
              <div class="form-group">
                <label> FACULTY <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.LearningResourceMember.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.LearningResourceMember.employee_name }}</td>
                    <td style="{{ data.LearningResourceMember.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.LearningResourceMember.employee_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.LearningResourceMember.employee_name = null; data.LearningResourceMember.employee_id = null;" ng-init="data.LearningResourceMember.employee_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-6" ng-show="data.LearningResourceMember.classification == 'ADMIN'">
              <div class="form-group">
                <label> SEARCH ADMIN </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE ADMIN HERE" ng-model="searchTxt" ng-enter="searchAdmin({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.LearningResourceMember.classification == 'ADMIN'">
              <div class="form-group">
                <label> ADMIN <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.LearningResourceMember.admin_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.LearningResourceMember.admin_name }}</td>
                    <td style="{{ data.LearningResourceMember.admin_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.LearningResourceMember.admin_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.LearningResourceMember.admin_name = null; data.LearningResourceMember.admin_id = null;" ng-init="data.LearningResourceMember.admin_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-3" ng-show="data.LearningResourceMember.classification == 'STUDENT' || data.LearningResourceMember.classification == 'FACULTY'">
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select selectize ng-model="data.LearningResourceMember.college_id" ng-options="opt.id as opt.value for opt in colleges" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM/DEPARTMENT <i class="required">*</i></label>
                <select selectize ng-model="data.LearningResourceMember.program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-3" ng-show="data.LearningResourceMember.classification == 'STUDENT'">
              <div class="form-group">
                <label> YEAR TERM LEVEL <i class="required">*</i></label>
                <select selectize ng-model="data.LearningResourceMember.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change="getYearTerm(data.LearningResourceMember.year_term_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-3" ng-show="data.LearningResourceMember.classification == 'FACULTY'">
              <div class="form-group">
                <label> FACULTY STATUS <i class="required">*</i></label>
                <select class="form-control" ng-model="data.LearningResourceMember.faculty_status" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                  <option value=""></option>
                  <option value="PERMANENT">PERMANENT</option>
                  <option value="VISITING LECTURE">VISITING LECTURE</option>
                  <option value="CASUAL">CASUAL</option>
                  <option value="JOB ORDER">JOB ORDER</option>
                </select>
              </div>
            </div>

            <div class="col-md-3" ng-show="data.LearningResourceMember.classification == 'FACULTY'">
              <div class="form-group">
                <label> OFFICE </label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.LearningResourceMember.office">
              </div>
            </div>

            <div class="col-md-{{ data.LearningResourceMember.classification == 'FACULTY' ? 3 : 6 }}">
              <div class="form-group">
                <label> EMAIL </label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.LearningResourceMember.email">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> MEMBERSHIP DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="off" ng-model="data.LearningResourceMember.date" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> CONTACT NO. </label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.LearningResourceMember.contact_no">
              </div>
            </div>
            <div class="col-md-{{ (data.LearningResourceMember.classification == 'FACULTY' || data.LearningResourceMember.classification == 'STUDENT') ? 12 : 6 }}">
              <div class="form-group">
                <label> ADDRESS </label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.LearningResourceMember.address">
              </div>
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

<div class="modal fade" id="searched-admin-modal">
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
                <tr ng-repeat="admin in admins">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ admin.code }}</td>
                  <td class="uppercase text-center">{{ admin.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="admin.selected = false" ng-model="admin.selected" name="iCheck" ng-selected="admin.selected = true" ng-change="selectedAdmin(admin)">
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
                            <a class="page-link" href="javascript:void(0)" ng-click="searchAdmin({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchAdmin({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchAdmin({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchAdmin({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchAdmin({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
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
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="adminData(admin.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
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