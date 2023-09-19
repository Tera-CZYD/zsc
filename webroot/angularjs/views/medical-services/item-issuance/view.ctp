<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.add('d-none'); // Add Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageView', 'item issuance/view', currentUser);
  handleAccess('pageEdit', 'item issuance/edit', currentUser);
  handleAccess('pageDelete', 'item issuance/delete', currentUser);
  handleAccess('pageApprove', 'item issuance/approve', currentUser);

</script>

<div class="row" id="pageView">
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
              <button id="pageApprove" href="javascript:void(0)" ng-click="approve(data.ItemIssuance)" ng-disabled="data.ItemIssuance.status == 1 || data.ItemIssuance.status == 2" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <a id="pageEdit" href="#/medical-services/item-issuance/edit/{{ data.ItemIssuance.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.ItemIssuance)"><i class="fa fa-trash"></i> DELETE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
th {
    white-space: nowrap;
}

td {
    white-space: nowrap;
}
</style>