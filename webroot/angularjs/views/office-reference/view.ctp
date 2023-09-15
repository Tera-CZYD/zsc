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
  handleAccess('pageView', 'office reference/view', currentUser);
  handleAccess('pageEdit', 'office reference/edit', currentUser);
  handleAccess('pageDelete', 'office reference/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW OFFICE REFERENCE</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic uppercase">{{ data.OfficeReference.module }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> SUBMODULE : </th>
                  <td class="italic uppercase">{{ data.OfficeReference.sub_module }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REFERENCE CODE : </th>
                  <td class="italic">{{ data.OfficeReference.reference_code }}</td>
                </tr>
                <tr ng-show=" data.OfficeReference.sub_module == 'Counseling Appointment'">
                  <th class="text-right"> OTHER REFERENCE CODE : </th>
                  <td class="italic">{{ data.OfficeReference.counselee_informed_consent_reference }}</td>
                </tr>
                <tr ng-show=" data.OfficeReference.sub_module == 'Counseling Appointment'">
                  <th class="text-right">  </th>
                  <td class="italic">{{ data.OfficeReference.release_information_reference }}</td>
                </tr>
                <tr ng-show=" data.OfficeReference.sub_module == 'Medical Student Profile'">
                  <th class="text-right"> OTHER REFERENCE CODE : </th>
                  <td class="italic">{{ data.OfficeReference.medical_student_history_reference }}</td>
                </tr>
                <tr ng-show=" data.OfficeReference.sub_module == 'Medical Employee Profile'">
                  <th class="text-right"> OTHER REFERENCE CODE : </th>
                  <td class="italic">{{ data.OfficeReference.medical_employee_history_reference }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADOPTED : </th>
                  <td class="italic">{{ data.OfficeReference.adopted }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REVISION DATE : </th>
                  <td class="italic">{{ data.OfficeReference.revision_date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REVISION STATUS : </th>
                  <td class="italic">{{ data.OfficeReference.revision_status }}</td>
                </tr>

              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/settings/office-reference/edit/{{ data.OfficeReference.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.OfficeReference)"><i class="fa fa-trash"></i> DELETE </button>
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
