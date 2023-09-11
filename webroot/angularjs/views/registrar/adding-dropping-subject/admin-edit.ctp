<?php if (hasAccess('adding dropping subject/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT COURSE SUBJECT</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.AddingDroppingSubject.code"> 
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
                    <td style="{{ data.AddingDroppingSubject.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.AddingDroppingSubject.student_name }}</td>
                    <td style="{{ data.AddingDroppingSubject.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.AddingDroppingSubject.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.AddingDroppingSubject.student_name = null; data.AddingDroppingSubject.student_id = null;" ng-init="data.AddingDroppingSubject.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>

            <div class="col-md-6" >
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.AddingDroppingSubject.college_id" autocomplete="off" ng-options="opt.id as opt.value for opt in colleges" ng-change="getCollegeProgram(data.AddingDroppingSubject.college_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            
            <div class="col-md-6" >
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.AddingDroppingSubject.program_id" autocomplete="off" ng-options="opt.id as opt.value for opt in programs" ng-change="getProgram(data.AddingDroppingSubject.program_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="off" ng-model="data.AddingDroppingSubject.date"  data-validation-engine="validate[required]">
              </div>
            </div>

             <div class="col-md-12">
              <div class="form-group">
                <label> REASON/S <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="off" ng-model="data.AddingDroppingSubject.reason" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>
          </div>

          <div class="clearfix"></div><hr>
          <div class="col-md-3 pull-left">
            <a class="btn btn-warning btn-sm btn-block" id="save" ng-click="addDropSubs()"><i class="fa fa-plus"></i>&nbsp; ADD/DROP SUBJECT</a><br />
          </div>

          <div class="clearfix"></div>

          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="w30px text-center">#</th>
                  <th class="text-center">INSTRUCTOR</th>
                  <th class="text-center">SUBJECT</th>
                  <th class="text-center">STATUS</th>                                 
                </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="datax in data.AddingDroppingSubjectSub" ng-if="datax.visible != 0">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ datax.faculty_name}}</td>
                    <td class="text-center">{{ datax.course_title }}</td>
                    <td class="text-center">{{ datax.status }}</td>
                    <td class="text-center">
                      <div class="btn-group btn-group-xs">
                        <a href="javascript:void(0)" ng-click="editSubs($index,datax)" class="btn btn-success" title="EDIT"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" ng-click="removeSubs($index)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tbody ng-if="data.AddingDroppingSubjectSub == '' || data.AddingDroppingSubjectSub == null">
                  <td colspan="6" class="text-center">No data available</td>
                </tbody>
              </table>
           </div>

          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<?php echo $this->element('modals/search/searched-student-modal') ?>

<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>


<div class="modal fade add-beneficiary-modal" id="add-subs-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADDING / DROPPING SUBJECT</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="add_subs">
          <div class="col-md-12">
            <div class="form-group">
              <label> SEARCH INSTRUCTOR </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
              <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxtCounselor" ng-enter="searchEmployee({ search: searchTxtCounselor })">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> INSTRUCTOR <i class="required">*</i></label>
              <table class="table table-bordered">
                <tr>
                  <td style="{{ adata.faculty_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ adata.faculty_name }}</td>
                  <td style="{{ adata.faculty_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="adata.faculty_name == undefined">
                    <button class="btn btn-xs btn-sm  btn-danger" ng-click="adata.faculty_name = null; data.AddingDroppingSubjectSub.faculty_id = null;" ng-init="adata.faculty_id = null"><i class="fa fa-times"></i></button>
                  </td>
                </tr>  
              </table>  
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize ng-model="adata.course_title" ng-options="opt.value as opt.value for opt in course" ng-change="getCourse(adata.AddingDroppingSubjectSub.course_title)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>STATUS<i class="required">*</i></label>
              <select class="form-control" ng-model="adata.status" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                <option value=""></option>
                <option value="ADD">ADD</option>
                <option value="DROP">DROP</option>
              </select>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveSubs(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade add-beneficiary-modal" id="edit-subs-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">EDIT SUB INFORMATION</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_subs">
          <div class="col-md-12">
            <div class="form-group">
              <label> SEARCH INSTRUCTOR </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
              <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxtCounselor" ng-enter="searchEmployee({ search: searchTxtCounselor })">
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> INSTRUCTOR <i class="required">*</i></label>
              <table class="table table-bordered">
                <tr>
                  <td style="{{ adata.faculty_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ adata.faculty_name }}</td>
                  <td style="{{ adata.faculty_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="adata.faculty_name == undefined">
                    <button class="btn btn-xs btn-sm  btn-danger" ng-click="adata.faculty_name = null; data.AddingDroppingSubjectSub.faculty_id = null;" ng-init="adata.faculty_id = null"><i class="fa fa-times"></i></button>
                  </td>
                </tr>  
              </table>  
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize ng-model="adata.course_title" ng-options="opt.value as opt.value for opt in course" ng-change="getCourse(adata.AddingDroppingSubjectSub.course_title)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>STATUS<i class="required">*</i></label>
              <select class="form-control" ng-model="adata.status" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                <option value=""></option>
                <option value="ADD">ADD</option>
                <option value="DROP">DROP</option>
              </select>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateSubs(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade add-beneficiary-modal" id="edit-subs-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">EDIT SUB INFORMATION</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_subs">

          <div class="col-md-12">
            <div class="form-group">
              <label> DATE <i class="required">*</i></label>
              <input type="text" class="form-control datepicker" autocomplete="off" ng-model="adata.date" data-validation-engine="validate[required]">
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> CHIEF COMPLAINTS <i class="required">*</i></label>
              <textarea type="text" class="form-control" ng-model="adata.chief_complaints" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> TREATMENTS <i class="required">*</i></label>
              <textarea type="text" class="form-control" ng-model="adata.treatments" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> REMARKS <i class="required">*</i></label>
              <textarea type="text" class="form-control" ng-model="adata.remarks" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateSubs(adata)">SAVE</button>
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