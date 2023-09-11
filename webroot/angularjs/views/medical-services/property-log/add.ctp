<?php if (hasAccess('property & equipment/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW PROPERTY & EQUIPMENT LOG</div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">
    
            <div class="col-md-6">
              <div class="form-group">
                <label> PROPERTY NAME <i class="required">*</i></label>
                <input type="text"class="form-control"  ng-model="data.PropertyLog.property_name"  data-validation-engine="validate[required]" autocomplete="off">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROPERTY TYPE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.PropertyLog.type" data-validation-engine="validate[required]" autocomplete="off">
                  <option value=""></option>
                  <option value="MEDICAL EQUIPMENT">MEDICAL EQUIPMENT</option>
                  <option value="DENTAL EQUIPMENT">DENTAL EQUIPMENT</option>
                  <option value="MEDICAL SUPPLIES">MEDICAL SUPPLIES</option>
                  <option value="DENTAL SUPPLIES">DENTAL SUPPLIES</option>
                  <option value="MEDICINE">MEDICINE</option></option>
                  <option value="OTHERS">OTHERS</option>
               </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
              <label>   DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.PropertyLog.date"  data-validation-engine="validate[required]" autocomplete="off"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
              <label>   MANUFACTURING DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.PropertyLog.manufacturing_date"  data-validation-engine="validate[required]" autocomplete="off"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
              <label>   BATCH NUMBER <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.PropertyLog.batch_no"  data-validation-engine="validate[required]" autocomplete="off"/>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
              <label>   EXPIRATION DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.PropertyLog.expiration_date"  data-validation-engine="validate[required]" autocomplete="off"/>
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

