<?php if (hasAccess('property & equipment/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PROPERTY & EQUIPMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> PROPERTY NAME : </th>
                  <td class="italic">{{ data.PropertyLog.property_name }}</td>
                </tr>

                <tr>
                  <th class="text-right"> PROPERTY TYPE : </th>
                  <td class="italic">{{ data.PropertyLog.type }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE ADDED : </th>
                  <td class="italic">{{ data.PropertyLog.date }}</td>
                </tr>
                 <tr>
                  <th class="text-right"> MANUFACTURING DATE : </th>
                  <td class="italic">{{ data.PropertyLog.manufacturing_date }}</td>
                </tr>
                 <tr>
                  <th class="text-right"> EXPIRATION DATE : </th>
                  <td class="italic">{{ data.PropertyLog.expiration_date }}</td>
                </tr>
                 <tr>
                  <th class="text-right"> BATCH NUMBER : </th>
                  <td class="italic">{{ data.PropertyLog.batch_no }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
              <h5 class="table-top-title mb-2"> INVENTORY </h5>
            </div>
            <div class="col-md-12" style="margin-bottom: 5px">
              <button class="btn btn-min btn-primary" ng-click="addInventory()"><i class="fa fa-plus"></i>&nbsp;ADD INVENTORY</button>
            </div>
          <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th style="width: 15px;">#</th>
                      <th class="text-center"> EXPIRY DATE </th>
                      <th class="text-center"> STOCKS </th>
                      <th class="text-center"> REMARK </th>
                      <th style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="subs in data.InventoryProperty" ng-if="subs.visible != 0">
                      <td style="width: 15px;"> {{ $index + 1 }} </td>
                      <td class="text-center uppercase">{{ subs.expiry_date}}</td>
                      <td class="text-center uppercase">{{ subs.stocks }}</td>
                      <td class="text-center uppercase">{{ subs.remarks }}</td>
                      <td class="w90px text-center">
                        <div class="btn-group btn-group-xs"></div>
                        <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editInventory($index, subs)"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeInventory(subs)"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <tr ng-if="data.InventoryProperty == '' || data.InventoryProperty == null">
                      <td class="text-center" colspan="6">No data available.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('property & equipment/edit', $currentUser)): ?>
                <a href="#/medical-services/property-log/edit/{{ data.PropertyLog.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('property & equipment/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.PropertyLog)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
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
<script>
$('#form').validationEngine('attach');
</script>


<div class="modal fade" id="add-inventory-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD INVENTORY </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="inventory_form">
          <div class="col-md-12">
            <div class="form-group">
              <label> EXPIRY DATE <i class="required">*</i></label>
              <input type="text" class="form-control datepicker" ng-model="adata.expiry_date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> STOCKS <i class="required">*</i></label>
              <input type="text" number="true" class="form-control" ng-model="adata.stocks" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> REMARKS <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="adata.remarks" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveInventory(adata)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-inventory-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-edit"></i> EDIT INVENTORY </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_inventory_form">
          <div class="col-md-12">
            <div class="form-group">
              <label> EXPIRY DATE <i class="required">*</i></label>
              <input type="text" class="form-control datepicker" ng-model="adata.expiry_date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> STOCKS <i class="required">*</i></label>
              <input type="text" number="true" class="form-control" ng-model="adata.stocks" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> REMARKS <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="adata.remarks" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateInventory(adata)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>
