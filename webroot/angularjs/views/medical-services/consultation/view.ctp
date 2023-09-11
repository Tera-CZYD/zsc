<?php if (hasAccess('consultation/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">CONSULTATION INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Consultation.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic" ng-show="data.Consultation.classification == 'Student'">{{ data.Consultation.student_name }}</td>
                  <td class="italic" ng-show="data.Consultation.classification == 'Employee'">{{ data.Consultation.employee_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.Consultation.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AGE : </th>
                  <td class="italic">{{ data.Consultation.age }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SEX : </th>
                  <td class="italic">{{ data.Consultation.sex }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.Consultation.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> HEIGHT : </th>
                  <td class="italic">{{ data.Consultation.height }}</td>
                </tr>
                <tr>
                  <th class="text-right"> WEIGHT : </th>
                  <td class="italic">{{ data.Consultation.weight }}</td>
                </tr>
                <tr>
                  <th class="text-right"> NURSE NAME : </th>
                  <td class="italic">{{ data.Consultation.nurse_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> NURSE REMARK : </th>
                  <td class="italic">{{ data.Consultation.nurse_remarks }}</td>
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
                  <th colspan="5">SUB INFORMATION</th>
                </tr>
                <tr>
                  <th class="w30px text-center">#</th>
                  <th class="text-center">DATE</th>
                  <th class="text-center">CHIEF COMPLAINTS</th>
                  <th class="text-center">TREATMENTS</th>
                  <th class="text-center">REMARKS</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="datax in data.ConsultationSub">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center">{{ datax.date | date: 'MM/dd/yyyy'}}</td>
                  <td class="text-center">{{ datax.chief_complaints }}</td>
                  <td class="text-center">{{ datax.treatments }}</td>
                  <td class="text-center">{{ datax.remarks }}</td>
                </tr>
              </tbody>
              <tbody ng-if="data.ConsultationSub == ''">
                <td colspan="6" class="text-center">No data available</td>
              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <div class="text-right">


              <?php if (hasAccess('consultation/appr', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="appr(data.Consultation)" ng-disabled=" data.Consultation.status == 3 || data.Consultation.status == 1 || data.Consultation.status == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              
              <?php if (hasAccess('consultation/disappr', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disappr(data.Consultation)" ng-disabled="data.Consultation.status == 1 || data.Consultation.status == 2 || data.Consultation.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>
              <?php endif ?>
           
              <?php if (hasAccess('consultation/treat', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="treat(data.Consultation)" ng-disabled=" data.Consultation.status == 0 || data.Consultation.status == 1 || data.Consultation.status == 2 || data.Consultation.status == 4" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> TREAT </button>
              <?php endif ?>
              <br>
              <?php if (hasAccess('consultation/refer', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="refer(data.Consultation)" ng-disabled=" data.Consultation.status == 0 ||  data.Consultation.status == 1 || data.Consultation.status == 2 || data.Consultation.status == 4" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> REFER </button>
              <?php endif ?>
              <?php if (hasAccess('consultation/edit', $currentUser)): ?>
              <a href="#/medical-services/consultation/edit/{{ data.Consultation.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('consultation/print', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.Consultation.id )"><i class="fa fa-print"></i> PRINT CONSULTATION </button>
              <?php endif ?>
              <?php if (hasAccess('consultation/delete', $currentUser)): ?>
              <button class="btn btn-danger btn-min" ng-click="remove(data.Consultation)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
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