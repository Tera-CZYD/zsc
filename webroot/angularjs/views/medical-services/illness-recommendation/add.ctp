<?php if (hasAccess('illness and recommendation/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW ILLNESS & RECOMMENDATION</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> AILMENT <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.IllnessRecommendation.ailment" data-validation-engine="validate[required]" autocomplete="off">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DESCRIPTION <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.IllnessRecommendation.description" data-validation-engine="validate[required]" autocomplete="off">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <h5 class="table-top-title mb-2"> PRESCRIPTIONS </h5>
            </div>
            <div class="col-md-12" style="margin-bottom: 5px">
              <button class="btn btn-min btn-primary" ng-click="addPrescription()"><i class="fa fa-plus"></i>&nbsp;ADD PRESCRIPTION</button>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th style="width: 15px;">#</th>
                      <th class="text-center"> PRESCRIPTION </th>
                      <th class="text-center"> DESCRIPTION </th>
                      <th style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="subs in data.IllnessRecommendationSub">
                      <td style="width: 15px;"> {{ $index + 1 }} </td>
                      <td class="text-left uppercase">{{ subs.prescription }}</td>
                      <td class="text-left uppercase">{{ subs.description }}</td>
                      <td class="w90px text-center">
                        <div class="btn-group btn-group-xs"></div>
                        <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editPrescription($index, subs)"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removePrescription($index)"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <tr ng-if="data.IllnessRecommendationSub == ''">
                      <td class="text-center" colspan="4">No data available.</td>
                    </tr>
                  </tbody>
                </table>
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

<div class="modal fade" id="add-prescription-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD PRESCRIPTION </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="prescription_form">  
          <div class="col-md-12">
            <div class="form-group">
              <label> PRESCRIPTION <i class="required">*</i></label>
              <select selectize ng-model="sub.prescription_id" ng-options="opt.id as opt.value for opt in prescriptions" data-validation-engine="validate[required]" ng-change="getPrescription(sub.prescription_id)">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> DESCRIPTION <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="sub.description" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="savePrescription(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-prescription-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-edit"></i> EDIT PROGRAM </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_prescription_form"> 
          <div class="col-md-12">
            <div class="form-group">
              <label> PRESCRIPTION <i class="required">*</i></label>
              <select selectize ng-model="sub.prescription_id" ng-options="opt.id as opt.value for opt in prescriptions" data-validation-engine="validate[required]" ng-change="getPrescription(sub.prescription_id)">
                  <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> DESCRIPTION <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="sub.description" data-validation-engine="validate[required]" autocomplete="off">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updatePrescription(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>
          

