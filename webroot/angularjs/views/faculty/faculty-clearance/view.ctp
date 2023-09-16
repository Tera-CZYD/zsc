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
  handleAccess('pageView', 'faculty clearance/view', currentUser);
  handleAccess('pageEdit', 'faculty clearance/edit', currentUser);
  handleAccess('pageDelete', 'faculty clearance/delete', currentUser);
  handleAccess('pagePrintForm', 'faculty clearance/print faculty clearance', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW FACULTY CLEARANCE</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.FacultyClearance.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> FACULTY NAME : </th>
                  <td class="italic">{{ data.FacultyClearance.faculty_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.FacultyClearance.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COMPLAINTS : </th>
                  <td class="italic">{{ data.FacultyClearance.request }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/faculty/faculty-clearance/edit/{{ data.FacultyClearance.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <button id="pagePrintForm" type="button" class="btn btn-info  btn-min" ng-click="print(data.FacultyClearance.id )"><i class="fa fa-print"></i> PRINT FACULTY CLEARANCE </button>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.FacultyClearance)"><i class="fa fa-trash"></i> DELETE </button>
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
