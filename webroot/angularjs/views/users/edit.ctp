<?php if (hasAccess('user management/edit', $currentUser)){ ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT USER</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-10">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Last Name <i class="required">*</i></label>
                    <input type="text" class="form-control" ng-model="data.User.last_name" data-validation-engine="validate[required]"/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>First Name <i class="required">*</i></label>
                    <input type="text" class="form-control" ng-model="data.User.first_name" data-validation-engine="validate[required]"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Username <i class="required">*</i></label>
                    <input type="text" class="form-control"  ng-model="data.User.username" data-validation-engine="validate[required]"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Password </label>
                    <input type="password" class="form-control"  ng-model="data.User.password"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Re-type Password </label>
                    <input type="password" class="form-control"  ng-model="confirmPassword"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Role <i class="required">*</i></label>
                    <select class="form-control" ng-model="data.User.roleId" ng-options="opt.id as opt.value for opt in roles" ng-change="getEmployee(data.User.roleId)" data-validation-engine="validate[required]">
                    <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Active <i class="required">*</i></label>
                    <select class="form-control" ng-model="data.User.active" ng-options="opt.id as opt.value for opt in bool" data-validation-engine="validate[required]">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Verified <i class="required">*</i></label>
                    <select class="form-control" ng-model="data.User.verified" ng-options="opt.id as opt.value for opt in bool" data-validation-engine="validate[required]">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <?php if (session('developer')) { ?>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Developer <i class="required">*</i></label>
                      <select class="form-control" ng-model="data.User.developer" ng-options="opt.id as opt.value for opt in bool" data-validation-engine="validate[required]">
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                <?php } ?>
                <div class="col-md-4" ng-show="role == 'Office Admin'">
                  <div class="form-group">
                    <label> OFFICE <i class="required">*</i></label>
                    <select class="form-control" ng-model="data.User.officeId" ng-options="opt.id as opt.value for opt in offices" data-validation-engine="validate[required]">
                    <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4" ng-show="role == 'Faculty'">
                  <div class="form-group">
                    <label> SEARCH FACULTY </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                    <input type="text" class="form-control search uppercase" placeholder="TYPE FACULTY HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })"/>
                  </div>
                </div>
                <div class="col-md-4" ng-show="role == 'Faculty'">
                  <div class="form-group">
                    <label> FACULTY <i class="required">*</i></label>
                    <table class="table table-bordered">
                      <tr>
                        <td style="{{ data.User.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.User.employee_name }}</td>
                        <td style="{{ data.User.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.User.employee_name == undefined">
                          <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.User.employee_name = null; data.User.employee_id = null;" ng-init="data.User.employee_id = null"><i class="fa fa-times"></i></button>
                        </td>
                      </tr>  
                    </table>  
                  </div>
                </div>
                <div class="col-md-4" ng-show="role == 'Student'">
                  <div class="form-group">
                    <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                    <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxtStudent" ng-enter="searchStudent({ search: searchTxtStudent })"/>
                  </div>
                </div>
                <div class="col-md-4" ng-show="role == 'Student'">
                  <div class="form-group">
                    <label> STUDENT <i class="required">*</i></label>
                    <table class="table table-bordered">
                      <tr>
                        <td style="{{ data.User.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.User.student_name }}</td>
                        <td style="{{ data.User.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.User.student_name == undefined">
                          <button type="button" class="btn btn-xs btn-sm  btn-danger" ng-click="data.User.student_name = null; data.User.student_id = null;" ng-init="data.User.student_id = null"><i class="fa fa-times"></i></button>
                        </td>
                      </tr>  
                    </table>  
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div>
                <img src="{{ data.User.imageSrc }}" width="130" height="127" class="UserImage"/>
              </div>
              <ul class="list-group">
                <li class="list-group-item" style="padding: 0px">
                  <span class="btn btn-primary btn-block btn-min btn-file no-border-radius">
                    CHOOSE IMAGE
                    <input id="fileImage" onchange="readURL(this)" type="file" accept="image/gif, image/jpeg, image/png" ng-file/>
                  </span>
                </li>
                <li class="list-group-item">
                  {{ (data.User.image.file.name.length > 10)?  ((data.User.image.file.name | limitTo:10) + '...') : data.User.image.file.name }}
                </li>
              </ul>
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
<?php } ?> 

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
                  <th class="text-center">EMPLOYEE NO.</th>
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
                    <input icheck type="radio" ng-init="employee.selected = false" ng-model="employee.selected" name="iCheck" ng-selected="employee.selected = true" ng-change="selected(employee)"/>
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
                            <a class="page-link" href="javascript:void(0)" ng-click="searchEmployee({ page: 1 ,search: searchTxt})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchEmployee({ page: 1 ,search: searchTxt})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchEmployee({ page: 1 ,search: searchTxt})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchEmployee({ page: 1 ,search: searchTxt})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchEmployee({ page: 1 ,search: searchTxt})"><sub>&raquo;&raquo;</sub> </a>
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
                    <input icheck type="radio" ng-init="student.selected = false" ng-model="student.selected" name="iCheck" ng-selected="student.selected = true" ng-change="selectedStudent(student)"/>
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

<script>

  $('#form').validationEngine('attach');

  function readURL(input) {

    if (input.files && input.files[0]) {

      var reader = new FileReader();

      reader.onload = function (e) {

        $('.userImage')

        .attr('src', e.target.result)

        .width(147)

        .height(127)

        .css("border-radius"," 3px")

        .css("margin-bottom"," 5px");

      };

      reader.readAsDataURL(input.files[0]);

    }

  }

</script>