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
  handleAccess('pageView', 'calendar of activities/view', currentUser);
  handleAccess('pageEdit', 'calendar of activities/edit', currentUser);
  handleAccess('pageDelete', 'calendar of activities/delete', currentUser);

</script>


<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW CALENDAR OF ACTIVITY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width: 20%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.CalendarActivity.code }}</td>
                </tr>
                
                <tr>
                  <th class="text-right"> TITLE : </th>
                  <td class="uppercase italic">{{ data.CalendarActivity.title }}</td>
                </tr>
                <tr>
                  <th class="text-right"> START DATE : </th>
                  <td class="italic">{{ data.CalendarActivity.startDate }}</td>
                </tr>
                <tr>
                  <th class="text-right"> END DATE : </th>
                  <td class="italic">{{ data.CalendarActivity.endDate }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic">{{ data.CalendarActivity.remarks }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              
                <a id="pageEdit" href="#/guidance/calendar-activities/edit/{{ data.CalendarActivity.id }}" class="btn btn-primary  btn-min"><i class="fa fa-edit"></i> EDIT</a> 
              
              
              <button id="pageDelete" type="button" class="btn btn-danger  btn-min" ng-click="remove(data.CalendarActivity)"><i class="fa fa-trash"></i> DELETE </button>
              
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