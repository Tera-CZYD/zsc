<?php if (hasAccess('calendar of activities/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT CALENDAR OF ACTIVITIES</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.CalendarActivity.code">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> TITLE </label>
                <input type="text" autocomplete="false" class="form-control" ng-model="data.CalendarActivity.title">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> START DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.CalendarActivity.startDate" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> END DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.CalendarActivity.endDate" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> REMARKS <i class="required">*</i></label>
                <textarea class="form-control" autocomplete="false" ng-model="data.CalendarActivity.remarks" data-validation-engine="validate[required]"></textarea>
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

<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>