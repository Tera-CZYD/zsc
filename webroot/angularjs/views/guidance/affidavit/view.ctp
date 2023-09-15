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
  handleAccess('pageView', 'affidavit for lost id/view', currentUser);
  handleAccess('pageEdit', 'affidavit for lost id/edit', currentUser);
  handleAccess('pageDelete', 'affidavit for lost id/delete', currentUser);
  handleAccess('pagePrintForm', 'affidavit for lost id/print affidavit for lost id form', currentUser);

</script>



<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW AFFIDAVIT FOR LOST ID/PASSBOOK INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Affidavit.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Affidavit.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.Affidavit.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.Affidavit.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.Affidavit.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.Affidavit.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> OR NO. : </th>
                  <td class="italic">{{ data.Affidavit.or_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AMOUNT : </th>
                  <td class="italic">{{ data.Affidavit.amount | number : 2 }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              
                <a id="pageEdit" href="#/guidance/affidavit/edit/{{ data.Affidavit.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              
              
              <button id="pagePrintForm" type="button" class="btn btn-info  btn-min" ng-click="print(data.Affidavit.id )"><i class="fa fa-print"></i> PRINT AFFIDAVIT FOR LOST ID/PASSBOOK </button>
              
              
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Affidavit)"><i class="fa fa-trash"></i> DELETE </button>
              
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
