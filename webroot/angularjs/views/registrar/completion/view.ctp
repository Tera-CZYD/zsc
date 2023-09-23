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
  handleAccess('pageView', 'completion form/view', currentUser);
  handleAccess('pageEdit', 'completion form/edit', currentUser);
  handleAccess('pageDelete', 'completion form/delete', currentUser);
  handleAccess('pagePrint', 'completion form/print', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">COURSE COMPLETION FORM INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> SERIAL NUMBER : </th>
                  <td class="italic">{{ data.Completion.serial_number }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Completion.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Completion.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.Completion.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REQUIREMENT : </th>
                  <td class="italic">{{ data.Completion.requirement }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.Completion.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> INSTRUCTOR : </th>
                  <td class="italic">{{ data.Completion.instructor }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SEMESTER : </th>
                  <td class="italic">{{ data.Completion.semester }}</td>
                </tr>
                <tr>
                  <th class="text-right"> OR NUMBER : </th>
                  <td class="italic">{{ data.Completion.or_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SCHOOL YEAR : </th>
                  <td class="italic">{{ data.Completion.school_year }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <a id="pageEdit" href="#/registrar/completion/edit/{{ data.Completion.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button id="pagePrint" type="button" class="btn btn-info  btn-min" ng-click="print(data.Completion.id )"><i class="fa fa-print"></i> PRINT COMPLETION FORM </button>
              <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Completion)"><i class="fa fa-trash"></i> DELETE </button>
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