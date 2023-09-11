<?php if (hasAccess('item issuance/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW ITEM ISSUANCE</div>
        <div class="clearfix"></div>
        <hr>
        <form id="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.ItemIssuance.code">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> TYPE <i class="required">*</i></label>
                <select class="form-control" autocomplete="false" ng-model="data.ItemIssuance.type" data-validation-engine="validate[required]">
                  <option value=""></option>
                  <option value="Dental">Dental</option>
                  <option value="Consultation">Consultation</option>
                </select>
              </div>
            </div>
        
            <div class="col-md-6" ng-show="data.ItemIssuance.type == 'Dental'">
              <div class="form-group">
                <label> DENTAL <i class="required">*</i></label>
                <select selectize ng-model="data.ItemIssuance.dental_id" ng-options="opt.id as opt.value for opt in dentals" data-validation-engine="validate[required]" ng-change="getDental(data.ItemIssuance.dental_id)">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6" ng-show="data.ItemIssuance.type == 'Consultation'">
              <div class="form-group">
                <label> CONSULTATION <i class="required">*</i></label>
                <select selectize ng-model="data.ItemIssuance.consultation_id" ng-options="opt.id as opt.value for opt in consultations" data-validation-engine="validate[required]" ng-change="getConsultation(data.ItemIssuance.consultation_id)">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="off" ng-model="data.ItemIssuance.date" data-validation-engine="validate[required]">
              </div>
            </div>
            
          </div>
          <div class="clearfix"></div>
          <hr>
          <div class="col-md-3 pull-left">
            <a class="btn btn-warning btn-sm btn-block" id="save" ng-click="addItem()">ADD ITEM </a><br />
          </div>

          <div class="clearfix"></div>

          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="w30px text-center">#</th>
                  <th class="text-center">ITEM TYPE</th>
                  <th class="text-center">ITEM</th>
                  <th class="text-center">QUANTITY</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="datax in data.ItemIssuanceSub">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center">{{ datax.item_type }}</td>
                  <td class="text-center">{{ datax.item }}</td>
                  <td class="text-center">{{ datax.quantity }}</td>
                  <td class="w90px">
                    <div class="btn-group btn-group-xs">
                      <a href="javascript:void(0)" ng-click="editItem($index,datax)" class="btn btn-success" title="EDIT"><i class="fa fa-edit"></i></a>
                      <a href="javascript:void(0)" ng-click="removeItem($index)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                    </div>
                  </td>
                </tr>
              </tbody>

              <tbody ng-if="data.ItemIssuanceSub == ''">
                <td colspan="5" class="text-center">No data available</td>
              </tbody>
            </table>
          </div>

        </div>
      </form>
      <div class="clearfix"></div>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <div class="pull-right">
            <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php echo $this->element('modals/search/searched-student-modal') ?>
<?php echo $this->element('modals/search/searched-employee-modal') ?>

<?php endif ?>
<style type="text/css">
th {
    white-space: nowrap;
}

td {
    white-space: nowrap;
}
</style>

<div class="modal fade add-item-modal" id="add-item-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADD ITEM INFORMATION</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="add_item">

          <div class="col-md-12">
            <div class="form-group">
              <label> ITEM TYPE <i class="required">*</i></label>
              <select class="form-control" autocomplete="false" ng-model="adata.item_type" ng-change="getItemType(adata.item_type)" data-validation-engine="validate[required]">
                <option value=""></option>
                <option value="EQUIPMENT">EQUIPMENT</option>
                <option value="MEDICINE">MEDICINE</option>
                <option value="MEDICINE KIT">MEDICINE KIT</option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> ITEM <i class="required">*</i></label>
              <select selectize ng-model="adata.item_id" ng-options="opt.id as opt.value for opt in items" data-validation-engine="validate[required]" ng-change="getItem(adata.item_id)">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> QUANTITY <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="adata.quantity" data-validation-engine="validate[required]">
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveItem(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade add-item-modal" id="edit-item-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">EDIT ITEM INFORMATION</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_item">

          <div class="col-md-12">
            <div class="form-group">
              <label> ITEM TYPE <i class="required">*</i></label>
              <select class="form-control" autocomplete="false" ng-model="adata.item_type" ng-change="getItemType(adata.item_type)" data-validation-engine="validate[required]">
                <option value=""></option>
                <option value="EQUIPMENT">EQUIPMENT</option>
                <option value="MEDICINE">MEDICINE</option>
                <option value="MEDICINE KIT">MEDICINE KIT</option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> ITEM <i class="required">*</i></label>
              <select selectize ng-model="adata.item_id" ng-options="opt.id as opt.value for opt in items" data-validation-engine="validate[required]" ng-change="getItem(adata.item_id)">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label> QUANTITY <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="adata.quantity" data-validation-engine="validate[required]">
            </div>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateItem(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>