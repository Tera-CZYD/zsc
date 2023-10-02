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
  handleAccess('pageView', 'requested form payment/view', currentUser);
  handleAccess('pageDelete', 'requested form payment/delete', currentUser);
  handleAccess('pageApprove', 'requested form payment/approve', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW REQUESTED FORM PAYMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.RequestedFormPayment.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.RequestedFormPayment.program }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.RequestedFormPayment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.RequestedFormPayment.email }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.RequestedFormPayment.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REQUEST : </th>
                  <td class="italic">{{ data.RequestedFormPayment.request }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <div class="row">
            <div class="col" ng-if="data.RequestedFormPaymentSub">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bg-info">
                  <th colspan="5">FORMS</th>
                </tr>
                <tr>
                  <th class="w30px text-center">#</th>
                  <th class="text-center">NAME</th>
                  <th class="text-center">AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="datax in data.RequestedFormPaymentSub">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center">{{ datax.name}}</td>
                  <td class="text-center">{{ datax.amount }}</td>
                </tr>
              </tbody>
              <tbody ng-if="data.RequestedFormPaymentSub == ''">
                <td colspan="6" class="text-center">No data available</td>
              </tbody>
            </table>
          </div>

        <div class="col-md-4" style="display: flex; justify-content: center;" ng-if="data.RequestForm.claim == 1">

                <a href="uploads/request-form/{{data.RequestForm.id}}/{{ data.RequestForm.image }}"><img src="uploads/request-form/{{data.RequestForm.id}}/{{ data.RequestForm.image }}" class="img-responsive" style="max-height: 50vh; max-width: 70%;" /></a>

          </div>
        </div>

          <div class="row">
          <div class="col" ng-if="data.AffidavitOfLoss">
            <div class="header-title">AFFIDAVIT OF LOSS INFORMATION</div>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.AffidavitOfLoss.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FORMS : </th>
                  <td class="italic">{{ data.AffidavitOfLoss.form }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.AffidavitOfLoss.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AMOUNT : </th>
                  <td class="italic">{{ data.AffidavitOfLoss.amount }}</td>
                </tr> 
                <tr>
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic"><input class="form-control" ng-if="data.RequestedFormPayment.remarks == null" type="text" ng-model="data.remarks">{{ data.RequestedFormPayment.remarks }}</td>

                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-4" style="display: flex; justify-content: center;" ng-if="data.AffidavitOfLoss.claim == 1">

                <a href="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}"><img src="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}" class="img-responsive" style="max-height: 50vh; max-width: 70%;" /></a>

          </div>
        </div>

          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <button id="pageApprove" id="pageApprove" href="javascript:void(0)" ng-click="approve(data.RequestedFormPayment,data.remarks)" ng-disabled="data.RequestedFormPayment.approve == 1" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.RequestedFormPayment)"><i class="fa fa-trash"></i> DELETE </button>
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
