<?php if (hasAccess('referral recommendation/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT REFERRAL RECOMMENDATION</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.ReferralRecommendation.code"> 
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label> CLASSIFICATION <i class="required">*</i></label>
                <select class="form-control" autocomplete="false" ng-model="data.ReferralRecommendation.classification" ng-change="getMember(data.ReferralRecommendation.classification)" ng-init="data.ReferralRecommendation.classification = 'Student'" data-validation-engine="validate[required]">
                  <option value="Student">Student</option>
                  <option value="Employee">Employee</option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ReferralRecommendation.classification == 'Student'">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.ReferralRecommendation.classification == 'Student'">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.ReferralRecommendation.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.ReferralRecommendation.student_name }}</td>
                    <td style="{{ data.ReferralRecommendation.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.ReferralRecommendation.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.ReferralRecommendation.student_name = null; data.ReferralRecommendation.student_id = null;" ng-init="data.ReferralRecommendation.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ReferralRecommendation.classification == 'Employee'">
              <div class="form-group">
                <label> SEARCH EMPLOYEE </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.ReferralRecommendation.classification == 'Employee'">
              <div class="form-group">
                <label> EMPLOYEE <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.ReferralRecommendation.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.ReferralRecommendation.employee_name }}</td>
                    <td style="{{ data.ReferralRecommendation.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.ReferralRecommendation.employee_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.ReferralRecommendation.employee_name = null; data.ReferralRecommendation.employee_id = null;" ng-init="data.ReferralRecommendation.employee_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>
            
            
            <div class="col-md-12">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.ReferralRecommendation.date" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> COMPLAINTS <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.ReferralRecommendation.complaints" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> RECOMMENDATION/S <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.ReferralRecommendation.recommendations" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> ATTENDED BY <i class="required">*</i></label>
                <select selectize ng-model="data.ReferralRecommendation.attended_by_id" ng-options="opt.id as opt.value for opt in nurse" ng-change="getCourse(data.ReferralRecommendation.attended_by_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
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
<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php echo $this->element('modals/search/searched-employee-modal') ?>
<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>