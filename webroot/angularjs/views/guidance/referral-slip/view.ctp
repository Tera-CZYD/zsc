<?php if (hasAccess('referral slip/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW STUDENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.ReferralSlip.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.ReferralSlip.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.ReferralSlip.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.ReferralSlip.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REASON : </th>
                  <td class="italic" ng-show="data.ReferralSlip.reason != 'Others, please specify'">{{ data.ReferralSlip.reason }}</td>
                  <td class="italic" ng-show="data.ReferralSlip.reason == 'Others, please specify'">{{ data.ReferralSlip.others }}</td>
                </tr>
                <tr ng-show="data.ReferralSlip.reason == 'ABSENTEEISM'">
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic">{{ data.ReferralSlip.remarks }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('referral slip/edit', $currentUser)): ?>
                <a href="#/guidance/referral-slip/edit/{{ data.ReferralSlip.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('referral slip/print referral slip form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.ReferralSlip.id )"><i class="fa fa-print"></i> PRINT REFERRAL SLIP </button>
              <?php endif ?>
              <?php if (hasAccess('referral slip/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.ReferralSlip)"><i class="fa fa-trash"></i> DELETE </button>
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
