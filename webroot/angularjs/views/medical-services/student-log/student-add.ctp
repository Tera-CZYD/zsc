<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW STUDENT LOG</div>
        <div class="clearfix"></div><hr>
       	 <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CLASSIFICATION <i class="required">*</i></label>
                <select class="form-control" autocomplete="false" ng-model="data.StudentLog.classification" ng-change="getMember(data.StudentLog.classification)" ng-init="data.StudentLog.classification = 'Student'" data-validation-engine="validate[required]">
                  <option value="Student">Student</option>
                  <option value="Employee">Employee</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.StudentLog.classification == 'Student'">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.StudentLog.classification == 'Student'">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.StudentLog.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.StudentLog.student_name }}</td>
                    <td style="{{ data.StudentLog.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.StudentLog.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.StudentLog.student_name = null; data.StudentLog.student_id = null;" ng-init="data.StudentLog.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.StudentLog.classification == 'Employee'">
              <div class="form-group">
                <label> SEARCH EMPLOYEE </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.StudentLog.classification == 'Employee'">
              <div class="form-group">
                <label> EMPLOYEE <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.StudentLog.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.StudentLog.employee_name }}</td>
                    <td style="{{ data.StudentLog.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.StudentLog.employee_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.StudentLog.employee_name = null; data.StudentLog.employee_id = null;" ng-init="data.StudentLog.employee_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.StudentLog.date"  data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> TIME <i class="required">*</i></label>
                <div class="input-group clockpicker">
                <input type="text" autocomplete = "false" class="form-control uppercase" ng-model="data.StudentLog.time" id="time">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-time"></span>
                </span>
             	 </div>
            	</div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> CONCERN <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.StudentLog.concern" data-validation-engine="validate[required]">
              </div>
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
<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php echo $this->element('modals/search/searched-employee-modal') ?>

<script>
$('#form').validationEngine('attach');
</script>


          

