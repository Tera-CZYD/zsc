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
  handleAccess('pageView', 'referral recommendation/view', currentUser);
  handleAccess('pageEdit', 'referral recommendation/edit', currentUser);
  handleAccess('pageDelete', 'referral recommendation/delete', currentUser);
  handleAccess('pagePrintReferralRecom', 'referral slip/print referral recommendation', currentUser);
  handleAccess('pageApprove', 'referral recommendation/appr', currentUser);
  handleAccess('pageDisapprove', 'referral recommendation/disappr', currentUser);

</script>

<div class="row" id="pageView">
<div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">REFERRAL RECOMMENDATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right"> SERIAL NUMBER : </th>
                  <td class="italic">{{ data.ReferralRecommendation.serial_number }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.ReferralRecommendation.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic" ng-show="data.ReferralRecommendation.classification == 'Student'">{{ data.ReferralRecommendation.student_name }}</td>
                  <td class="italic" ng-show="data.ReferralRecommendation.classification == 'Employee'">{{ data.ReferralRecommendation.employee_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.ReferralRecommendation.date }}</td>
                </tr>

                <tr>
                  <th class="text-right"> COMPLAINTS : </th>
                  <td class="italic">{{ data.ReferralRecommendation.complaints }}</td>
                </tr>
                <tr>
                  <th class="text-right"> RECOMMENDATION : </th>
                  <td class="italic">{{ data.ReferralRecommendation.recommendations }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ATTENDED BY : </th>
                  <td class="italic">{{ data.NurseProfile.name }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="text-right">

              <button id="pageApprove" href="javascript:void(0)" ng-click="appr(data.ReferralRecommendation)" ng-disabled=" data.ReferralRecommendation.status == 3 || data.ReferralRecommendation.status == 1 || data.ReferralRecommendation.status == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <button id="pageDisapprove" href="javascript:void(0)" ng-click="disappr(data.ReferralRecommendation)" ng-disabled="data.ReferralRecommendation.status == 1 || data.ReferralRecommendation.status == 2 || data.ReferralRecommendation.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>
              <a id="pageEdit" href="#/medical-services/referral-recommendation/edit/{{ data.ReferralRecommendation.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button id="pagePrintReferralRecom" type="button" class="btn btn-info  btn-min" ng-click="print(data.ReferralRecommendation.id )"><i class="fa fa-print"></i> PRINT REFERRAL RECOMMENDATION </button>
              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.ReferralRecommendation)"><i class="fa fa-trash"></i> DELETE </button>
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