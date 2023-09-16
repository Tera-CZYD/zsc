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
  handleAccess('pageView', 'faculty management/view', currentUser);
  handleAccess('pageEdit', 'faculty management/edit', currentUser);
  handleAccess('pageDelete', 'faculty management/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW FACULTY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> FACULTY NO. : </th>
                  <td class="italic">{{ data.Employee.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FAMILY NAME : </th>
                  <td class="italic">{{ data.Employee.family_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GIVEN NAME : </th>
                  <td class="italic">{{ data.Employee.given_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MIDDLE NAME : </th>
                  <td class="italic">{{ data.Employee.middle_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.code }} - {{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.Employee.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> BIRTH DATE : </th>
                  <td class="italic">{{ data.Employee.birthdate }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ACADEMIC RANK : </th>
                  <td class="italic">{{ data.Employee.academic_rank }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SPECIALIZATION : </th>
                  <td class="italic">{{ data.Specialization.name }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <div class="pull-right">
                <a id="pageEdit" href="#/faculty/faculty-management/edit/{{ data.Employee.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Employee)"><i class="fa fa-trash"></i> DELETE </button>
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
