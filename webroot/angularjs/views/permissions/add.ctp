<?php if (hasAccess('permission management/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title"> NEW PERMISSION </div>
        <div class="clearfix"></div><hr>
        <form id="form">  
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label> Module <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.Permission.module" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> Action <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.Permission.action" data-validation-engine="validate[required]">
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