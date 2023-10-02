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
  handleAccess('pageView', 'affidavit of loss/view', currentUser);
  handleAccess('pageEdit', 'affidavit of loss/edit', currentUser);
  handleAccess('pageDelete', 'affidavit of loss/delete', currentUser);
  handleAccess('pageApprove', 'affidavit of loss/approve', currentUser);
  handleAccess('pageDisapprove', 'affidavit of loss/disapprove', currentUser);

</script>

  <div class="row" id="pageView">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">AFFIDAVIT OF LOSS INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tr>
                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.code }}</td>
                  </tr>
                  <tr>
                    <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.student_name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> COLLEGE PROGRAM : </th>
                    <td class="italic">{{ data.CollegeProgram.name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DATE : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.date }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> FORM : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.form }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DESCRIPTION : </th>
                    <td class="italic">{{ data.AffidavitOfLoss.description }}</td>
                  </tr>
                  <tr>
                      <th class="text-right"> REQUESTOR : </th>
                      <td class="italic">{{ data.AffidavitOfLoss.claim == 0 ? 'CLAIM' : (data.AffidavitOfLoss.claim == 1 ? 'AUTHORIZED PERSON' : '') }}</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="col-md-4" style="display: flex; justify-content: center;" ng-show="data.AffidavitOfLoss.claim == 1">

                <a href="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}"><img src="uploads/affidavit-of-loss/{{data.AffidavitOfLoss.id}}/{{ data.AffidavitOfLoss.image }}" class="img-responsive" style="max-height: 50vh; max-width: 70%;" /></a>

            </div>

            <div class="clearfix"></div>
            


              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
            </div>
            <div class="col-md-12">
              <div class="pull-right">
                  <a id="pageEdit" href="#/registrar/admin-affidavit-of-loss/edit/{{ data.AffidavitOfLoss.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageApprove" href="javascript:void(0)" ng-click="approve(data.AffidavitOfLoss)" ng-disabled="data.AffidavitOfLoss.approve > 0" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
                <button id="pageDisapprove" href="javascript:void(0)" ng-click="disapprove(data.AffidavitOfLoss)" ng-disabled="data.AffidavitOfLoss.approve > 0 " class="btn btn-warning  btn-min" ><i class="fa fa-times"></i> DISAPPROVE </button>
                  <!-- <button type="button" class="btn btn-info  btn-min" ng-click="print(data.RequestForm.id )"><i class="fa fa-print"></i> PRINT REQUEST FORM </button> -->
                  <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.AffidavitOfLoss)"><i class="fa fa-trash"></i> DELETE </button>
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