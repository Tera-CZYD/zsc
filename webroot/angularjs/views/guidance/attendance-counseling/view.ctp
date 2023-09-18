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
  handleAccess('pageView', 'attendance to counseling/view', currentUser);
  handleAccess('pageEdit', 'attendance to counseling/edit', currentUser);
  handleAccess('pageDelete', 'attendance to counseling/delete', currentUser);
  handleAccess('pagePrintForm', 'attendance to counseling/print attendance to counseling form', currentUser);

</script>


<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW ATTENDANCE TO COUNSELING INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width: 20%"> SERIAL NUMBER : </th>
                  <td class="italic">{{ data.AttendanceCounseling.serial_number }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width: 20%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.AttendanceCounseling.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TYPE : </th>
                  <td class="uppercase italic">{{ data.CounselingAppointment.CounselingType.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="uppercase italic">{{ data.CounselingAppointment.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.AttendanceCounseling.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TIME : </th>
                  <td class="italic">{{ data.AttendanceCounseling.time }}</td>
                </tr>
                <tr>
                  <th class="text-right"> LOCATION : </th>
                  <td class="italic">{{ data.AttendanceCounseling.location }}</td>
                </tr>
                <tr>
                  <th class="text-right"> RECOMMENDATION : </th>
                  <td class="italic">{{ data.AttendanceCounseling.recommendation }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              
                <a id="pageEdit" href="#/guidance/attendance-counseling/edit/{{ data.AttendanceCounseling.id }}" class="btn btn-primary  btn-min"><i class="fa fa-edit"></i> EDIT</a> 
              
              
              <button id="pagePrintForm" type="button" class="btn btn-info  btn-min" ng-click="print(data.AttendanceCounseling.id )"><i class="fa fa-print"></i> PRINT ATTENDANCE TO COUNSELING </button>
              
              
              <button id="pageDelete" type="button" class="btn btn-danger  btn-min" ng-click="remove(data.AttendanceCounseling)"><i class="fa fa-trash"></i> DELETE </button>
              
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>