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
  handleAccess('pageView', 'medical certificate request/view', currentUser);
  handleAccess('pageEdit', 'medical certificate request/edit', currentUser);
  handleAccess('pageDelete', 'medical certificate request/delete', currentUser);
  handleAccess('pagePrintMedicalCert', 'medical certificate request/print medical certificate', currentUser);
  handleAccess('pageApprove', 'medical certificate request/appr', currentUser);
  handleAccess('pageDisapprove', 'medical certificate request/disappr', currentUser);

</script>

<div class="row" id="pageView">
<div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">MEDICAL CERTIFICATE INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.MedicalCertificate.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic" ng-show="data.MedicalCertificate.classification == 'Student'">{{ data.Student.last_name }}, {{ data.Student.first_name }} {{ data.Student.middle_name }}</td>
                  <td class="italic" ng-show="data.MedicalCertificate.classification == 'Employee'">{{ data.Employee.employee_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.MedicalCertificate.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th> 
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.YearLevelTerm.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.MedicalCertificate.description }}</td>
                </tr>
                  <tr>
                  <th class="text-right"> REMARKS : </th>
                  
                 
                  <td class="italic" ><form id="form"><input type="text" ng-disabled="data.MedicalCertificate.status == 3" class="form-control" placeholder="ADD REMARKS BEFORE APPROVING" autocomplete="false" ng-model="data.MedicalCertificate.remarks" data-validation-engine="validate[required]"></form></td>
                 
                  
                 
                  <!-- <td class="italic" ng-if="data.MedicalCertificate.status == 3">{{ data.MedicalCertificate.remarks }}</td> -->
                  
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="text-right">

            

                <button id="pageApprove" href="javascript:void(0)" ng-click="appr(data.MedicalCertificate)" ng-disabled=" data.MedicalCertificate.status == 3 || data.MedicalCertificate.status == 1 || data.MedicalCertificate.status == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
                <button id="pageDisapprove" href="javascript:void(0)" ng-click="disappr(data.MedicalCertificate)" ng-disabled="data.MedicalCertificate.status == 1 || data.MedicalCertificate.status == 2 || data.MedicalCertificate.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>

              <a id="pageEdit" href="#/medical-services/medical-certificate/edit/{{ data.MedicalCertificate.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button id="pagePrintMedicalCert" type="button" class="btn btn-info  btn-min" ng-click="print(data.MedicalCertificate.id )"><i class="fa fa-print"></i> PRINT MEDICAL CERTIFICATE </button>
              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.MedicalCertificate)"><i class="fa fa-trash"></i> DELETE </button>
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