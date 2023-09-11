<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT MEDICAL CERTIFICATE REQUEST</div>
        <div class="clearfix"></div>
        <hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control"ng-model="data.MedicalCertificate.code">
              </div> 
            </div>

            <div class="col-md-6" ng-show="data.MedicalCertificate.classification == 'Student'">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.MedicalCertificate.classification == 'Student'">
              <div class="form-group">
                <label> STUDENT <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.MedicalCertificate.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.MedicalCertificate.student_name }}</td>
                    <td style="{{ data.MedicalCertificate.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.MedicalCertificate.student_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.MedicalCertificate.student_name = null; data.MedicalCertificate.student_id = null;" ng-init="data.MedicalCertificate.student_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.MedicalCertificate.classification == 'Employee'">
              <div class="form-group">
                <label> SEARCH EMPLOYEE </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxt" ng-enter="searchEmployee({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6" ng-show="data.MedicalCertificate.classification == 'Employee'">
              <div class="form-group">
                <label> EMPLOYEE <i class="required">*</i></label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.MedicalCertificate.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.MedicalCertificate.employee_name }}</td>
                    <td style="{{ data.MedicalCertificate.employee_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.MedicalCertificate.employee_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.MedicalCertificate.employee_name = null; data.MedicalCertificate.employee_id = null;" ng-init="data.MedicalCertificate.employee_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-model="data.MedicalCertificate.program_id" ng-options="opt.id as opt.value for opt in course" ng-change="getCourse(data.MedicalCertificate.program_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> YEAR TERM </label>
                <select selectize ng-model="data.MedicalCertificate.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getYear(data.MedicalCertificate.year_term_id)">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.MedicalCertificate.date" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DESCRIPTION <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.MedicalCertificate.description" data-validation-engine="validate[required]"></textarea>
              </div>
            </div>
          </div>
        </form>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id="save" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php echo $this->element('modals/search/searched-employee-modal') ?>
<style type="text/css">
th {
  white-space: nowrap;
}

td {
  white-space: nowrap;
}
</style>