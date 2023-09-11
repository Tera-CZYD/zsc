<?php if (hasAccess('visitors alumni management/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW VISITOR'S/ALUMNI</div>
        <div class="clearfix"></div><hr>
       	 <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> VISITOR/ALUMNI NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.VisitorsAlumni.name" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> NAME OF SCHOOL <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.VisitorsAlumni.name_of_school" data-validation-engine="validate[required]">
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


          

