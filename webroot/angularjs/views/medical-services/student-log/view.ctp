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
  handleAccess('pageView', 'student log/view', currentUser);
  handleAccess('pageEdit', 'student log/edit', currentUser);
  handleAccess('pageDelete', 'student log/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW LOG INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NO : </th>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Student'">{{ data.StudentLog.student_no }}</td>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Employee'">{{ data.StudentLog.employee_no }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Student'">{{ data.StudentLog.student_name }}</td>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Employee'">{{ data.StudentLog.employee_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.StudentLog.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TIME : </th>
                  <td class="italic">{{ data.StudentLog.time }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONCERN : </th>
                  <td class="italic">{{ data.StudentLog.concern }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <a id="pageEdit" href="#/medical-services/student-log/edit/{{ data.StudentLog.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a> 
              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.StudentLog)"><i class="fa fa-trash"></i> DELETE </button>
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
