
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW MEDICAL CERTIFICATE REQUEST</div>
        <div class="clearfix"></div>
        <hr>
        <form id="form">
          <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.MedicalCertificate.code">
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-center" colspan="2">STUDENT INFORMATION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-left" style="width: 15%"> STUDENT NUMBER </th>
                      <td class="text-left uppercase">{{ data.MedicalCertificate.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th>
                      <td class="text-left uppercase">{{ data.MedicalCertificate.student_name }}</td>   
                    </tr>
                  </tbody>
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
              <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
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