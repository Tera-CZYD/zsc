<?php if (hasAccess('attendance to counseling/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW ATTENDANCE TO COUNSELING</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.AttendanceCounseling.code">
              </div>
            </div>
            <div class="col-md-4" >
              <div class="form-group">
                <label> COUNSELING APPOINTMENT <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.AttendanceCounseling.counseling_appointment_id" ng-options="opt.id as opt.value for opt in counseling_appointments" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.AttendanceCounseling.date" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-4">  
              <div class="form-group">
                <label> TIME </label><i class="required">*</i>
                <div class="input-group clockpicker">
                  <input type="text" autocomplete = "false" class="form-control uppercase" ng-model="data.AttendanceCounseling.time" id="time">
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label> LOCATION <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.AttendanceCounseling.location" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label> RECOMMENDATION <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.AttendanceCounseling.recommendation" data-validation-engine="validate[required]"></textarea>
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
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>