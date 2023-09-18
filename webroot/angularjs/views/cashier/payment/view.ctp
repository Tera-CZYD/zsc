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
  handleAccess('pageView', 'payment/view', currentUser); 
  handleAccess('pageDelete', 'payment/delete', currentUser);
  handleAccess('pageEdit', 'payment/edit', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PAYMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.Payment.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.Payment.program }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Payment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.Payment.email }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.Payment.contact_no }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>

            <div class="form-group">
              <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="bg-info" colspan="6">MISCELLANEOUS</th>
                </thead>
                <thead>
                  <tr>
                    <th class="w30px text-center">#</th>
                    <th class="text-center">CODE</th>
                    <th class="text-center">NAME</th>
                    <th class="text-center">UNIT</th>
                    <th class="text-center">AMOUNT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="datax in data.CashierSub">
                    <td class="w30px">{{ $index + 1 }}</td>
                    <td class="uppercase w200px">{{ datax.code }}</td>
                    <td class="uppercase">{{ datax.name }}</td>
                    <td class="uppercase"> {{ datax.unit }}</td>
                    <td class="text-right">{{ datax.amount }}</td>
                    <tr ng-if="data.CashierSub == '' || data.CashierSub == null">
                      <td class="text-center" colspan="10">No available Miscellaneous</td>
                    </tr>
                  </tr>
                </tbody>
                <tfoot ng-if="data.CashierSub != ''">
                  <tr>
                    <th class="text-left" colspan="4">TOTAL</th>
                    <th class="text-right">{{ data.Payment.total | number : 2 }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            </div>

          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/cashier/payment/edit/{{ data.Payment.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Payment)"><i class="fa fa-trash"></i> DELETE </button>
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
