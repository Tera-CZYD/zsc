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
  handleAccess('pageView', 'course/view', currentUser);
  handleAccess('pageEdit', 'course/edit', currentUser);
  handleAccess('pageDelete', 'course/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW COURSE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> YEAR OF IMPLEMENTATION : </th>
                  <td class="italic">{{ data.Course.year_implementation }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> REFERENCE NUMBER : </th>
                  <td class="italic">{{ data.Course.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TITLE : </th>
                  <td class="italic">{{ data.Course.title }}</td>
                </tr>
                 <tr>
                  <th class="text-right"> CATEGORY : </th>
                  <td class="italic">{{ data.Course.category }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.Course.description }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <!-- <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <table class="table table-bordered center">
              <tr>
                <th></th>
                <th class="text-center" style="width: 10%"> HOURS </th>
                <th class="text-center" style="width: 10%"> UNITS </th>
              </tr>
              <tr>
                <th class="text-left"> LECTURE </th>
                <td class="text-center">{{ data.Course.lecture_hours | number : 2 }}</td>
                <td class="text-center">{{ data.Course.lecture_unit | number : 2 }}</td>
              </tr>
              <tr>
                <th class="text-left"> LABORATORY </th>
                <td class="text-center">{{ data.Course.laboratory_hours | number : 2 }}</td>
                <td class="text-center">{{ data.Course.laboratory_unit | number : 2 }}</td>
              </tr>
              <tr>
                <th class="text-left"> CREDIT </th>
                <td class="text-center">{{ data.Course.credit_hours | number : 2 }}</td>
                <td class="text-center">{{ data.Course.credit_unit | number : 2 }}</td>
              </tr>
            </table>
          </div> -->
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/course/edit/{{ data.Course.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Course)"><i class="fa fa-trash"></i> DELETE </button>
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
