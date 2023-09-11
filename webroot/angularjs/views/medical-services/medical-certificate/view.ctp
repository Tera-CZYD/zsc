<?php if (hasAccess('medical certificate request/view', $currentUser)): ?>
<div class="row">
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

            

            <?php if (hasAccess('medical_certificate/appr', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="appr(data.MedicalCertificate)" ng-disabled=" data.MedicalCertificate.status == 3 || data.MedicalCertificate.status == 1 || data.MedicalCertificate.status == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('medical_certificate/disappr', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disappr(data.MedicalCertificate)" ng-disabled="data.MedicalCertificate.status == 1 || data.MedicalCertificate.status == 2 || data.MedicalCertificate.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>
              <?php endif ?>



              <?php if (hasAccess('medical certificate request/edit', $currentUser)): ?>
              <a href="#/medical-services/medical-certificate/edit/{{ data.MedicalCertificate.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('medical certificate request/print medical certificate', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.MedicalCertificate.id )"><i class="fa fa-print"></i> PRINT MEDICAL CERTIFICATE </button>
              <?php endif ?>
              <?php if (hasAccess('medical certificate request/delete', $currentUser)): ?>
              <button class="btn btn-danger btn-min" ng-click="remove(data.MedicalCertificate)"><i class="fa fa-trash"></i> DELETE </button>
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