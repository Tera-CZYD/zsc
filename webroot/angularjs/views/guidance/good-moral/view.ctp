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
  handleAccess('pageView', 'good moral certificate/view', currentUser);
  handleAccess('pageEdit', 'good moral certificate/edit', currentUser);
  handleAccess('pageDelete', 'good moral certificate/delete', currentUser);
  // handleAccess('pagePrintForm', 'good moral certificate/print good moral certificate', currentUser);


</script>


<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW GOOD MORAL CERTIFICATE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.GoodMoral.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.GoodMoral.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.GoodMoral.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic">{{ data.GoodMoral.remarks }}</td>
                </tr>
                <tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              
                <a id="pageEdit" href="#/guidance/good-moral/edit/{{ data.GoodMoral.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              
              
              <!-- <button id="pagePrintForm" type="button" class="btn btn-info  btn-min" ng-click="print(data.GoodMoral.id )"><i class="fa fa-print"></i> PRINT GOOD MORAL CERTIFICATE </button> -->
              
              
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.GoodMoral)"><i class="fa fa-trash"></i> DELETE </button>
              
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
