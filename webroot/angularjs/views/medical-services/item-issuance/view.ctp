<?php if (hasAccess('item issuance/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">ITEM ISSUANCE INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.ItemIssuance.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> TYPE : </th>
                  <td class="italic">{{ data.ItemIssuance.type }}</td>
                </tr>
                <tr ng-show="data.ItemIssuance.type == 'Dental'">
                  <th class="text-right"> DENTAL : </th>
                  <td class="italic">{{ data.ItemIssuance.dental }}</td>
                </tr>
                <tr ng-show="data.ItemIssuance.type == 'ItemIssuance'">
                  <th class="text-right"> ItemIssuance : </th>
                  <td class="italic">{{ data.ItemIssuance.ItemIssuance }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.ItemIssuance.date }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bg-info">
                  <th colspan="5">ITEM INFORMATION</th>
                </tr>
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
                </tr>
              </tbody>
              <tbody ng-if="data.ItemIssuanceSub == ''">
                <td colspan="6" class="text-center">No data available</td>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('item issuance/approve', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="approve(data.ItemIssuance)" ng-disabled="data.ItemIssuance.status == 1 || data.ItemIssuance.status == 2" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('item issuance/edit', $currentUser)): ?>
              <a href="#/medical-services/item-issuance/edit/{{ data.ItemIssuance.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('item issuance/delete', $currentUser)): ?>
              <button class="btn btn-danger btn-min" ng-click="remove(data.ItemIssuance)"><i class="fa fa-trash"></i> DELETE </button>
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