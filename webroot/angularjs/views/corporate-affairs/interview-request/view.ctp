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
  handleAccess('pageView', 'interview request/view', currentUser);
  handleAccess('pageEdit', 'interview request/edit', currentUser);
  handleAccess('pageDelete', 'interview request/delete', currentUser);
  handleAccess('pageApprove', 'interview request/approve', currentUser);
  handleAccess('pageDisapprove', 'interview request/disapprove', currentUser);


</script>


<div class="row" id="pageView">
<div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW INTERVIEW REQUEST INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.InterviewRequest.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.InterviewRequest.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.InterviewRequest.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th> 
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.InterviewRequest.year }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="text-right">

                <button id="pageApprove" href="javascript:void(0)" ng-click="approve(data.InterviewRequest)" ng-disabled="data.InterviewRequest.approve == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>

                <button id="pageDisapprove" href="javascript:void(0)" ng-click="disapprove(data.InterviewRequest)" ng-disabled="data.MedicalInterviewRequestCertificate.approve == 1 || data.InterviewRequest.approve == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>

              <a id="pageEdit" href="#/corporate-affairs/interview-request/edit/{{ data.InterviewRequest.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>

              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.InterviewRequest)"><i class="fa fa-trash"></i> DELETE </button>

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