<?php if (hasAccess('nurse profile/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT NURSE PROFILE</div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label> NAME <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.NurseProfile.name" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> ADDRESS <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.NurseProfile.address" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> AGE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.NurseProfile.age" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> BIRTHDATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.NurseProfile.birthdate" data-validation-engine="validate[required]">
              </div>
            </div>

          </div>
       </form>
       <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> SAVE </button>
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


          

