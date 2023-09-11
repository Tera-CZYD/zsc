<?php if (hasAccess('admin management/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW ADMIN</div>
        <div class="clearfix"></div><hr>
       	 <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> EMPLOYEE NO. <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Admin.employee_no" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> FIRST NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Admin.first_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> MIDDLE NAME </label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Admin.middle_name">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> LAST NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Admin.last_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DEPARTMENT </label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Admin.department">
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
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>


          

