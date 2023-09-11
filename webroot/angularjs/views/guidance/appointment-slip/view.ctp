<?php if (hasAccess('appointment slip/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW APPOINTMENT SLIP INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.AppointmentSlip.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.AppointmentSlip.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.AppointmentSlip.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TIME : </th>
                  <td class="italic">{{ data.AppointmentSlip.time }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PURPOSE : </th>
                  <td class="italic" ng-show="data.AppointmentSlip.purpose != 'Others, please specify'">{{ data.AppointmentSlip.purpose }}</td>
                  <td class="italic" ng-show="data.AppointmentSlip.purpose == 'Others, please specify'">{{ data.AppointmentSlip.others }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('appointment slip/edit', $currentUser)): ?>
                <a href="#/guidance/appointment-slip/edit/{{ data.AppointmentSlip.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('appointment slip/print appointment slip form', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.AppointmentSlip.id )"><i class="fa fa-print"></i> PRINT APPOINTMENT SLIP </button>
              <?php endif ?>
              <?php if (hasAccess('appointment slip/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.AppointmentSlip)"><i class="fa fa-trash"></i> DELETE </button>
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
