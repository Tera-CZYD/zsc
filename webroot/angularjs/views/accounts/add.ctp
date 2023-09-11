<?php if (hasAccess('chart of account/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW CHART OF ACCOUNT</div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> MISCELLANEOUS CODE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Account.code" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DESCRIPTION <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Account.name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> AMOUNT <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" decimal ng-model="data.Account.amount" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> ACRONYM <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Account.acronym" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> UNIT <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.Account.unit" data-validation-engine="validate[required]">
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


          

