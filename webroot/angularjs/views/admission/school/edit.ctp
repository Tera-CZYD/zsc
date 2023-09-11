<?php if (hasAccess('school graduated/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">ADD NEW SCHOOL GRADUATED MANAGEMENT</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            
            <div class="col-md-6">
              <div class="form-group">
                <label> SCHOOL NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.School.school_name" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> SCHOOL ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.School.school_address" data-validation-engine="validate[required]">
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