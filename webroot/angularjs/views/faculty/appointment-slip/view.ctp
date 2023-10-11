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
  handleAccess('pageView', 'referral slip/view', currentUser);
  handleAccess('pageEdit', 'referral slip/edit', currentUser);
  handleAccess('pageDelete', 'referral slip/delete', currentUser);
  handleAccess('pagePrintReferral', 'referral slip/print referral slip form', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW APPOINTMENT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right"> SERIAL NUMBER : </th>
                  <td class="italic">{{ data.AppointmentSlip.serial_number }}</td>
                </tr>
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
                <!-- <tr>
                  <th class="text-right"> COLLEGE PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.AppointmentSlip.year }}</td>
                </tr>
 -->                <tr>
                  <th class="text-right"> PURPOSE : </th>
                  <td class="italic" ng-show="data.AppointmentSlip.reason != 'Others, please specify'">{{ data.AppointmentSlip.purpose }}</td>
                  <td class="italic" ng-show="data.AppointmentSlip.reason == 'Others, please specify'">{{ data.AppointmentSlip.others }}</td>
                </tr>
                <tr ng-show="data.AppointmentSlip.reason == 'ABSENTEEISM'">
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic">{{ data.AppointmentSlip.remarks }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <a id="pageEdit" href="#/guidance/referral-slip/edit/{{ data.AppointmentSlip.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button id="pagePrintReferral" type="button" class="btn btn-info  btn-min" ng-click="print(data.AppointmentSlip.id )"><i class="fa fa-print"></i> PRINT REFERRAL SLIP </button>
              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.AppointmentSlip)"><i class="fa fa-trash"></i> DELETE </button>
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
