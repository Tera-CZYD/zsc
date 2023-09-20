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
  handleAccess('pageView', 'prescription/view', currentUser);
  handleAccess('pageEdit', 'prescription/edit', currentUser);
  handleAccess('pageDelete', 'prescription/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PRESCRIPTION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                 <tr>
                  <th class="text-right" style="width:15%"> NAME : </th>
                  <td class="italic">{{ data.Prescription.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE ADDED: </th>
                  <td class="italic">{{ data.Prescription.date }}</td>
                </tr>
            
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/medical-services/prescription/edit/{{ data.Prescription.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a> 
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Prescription)"><i class="fa fa-trash"></i> DELETE </button>
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
