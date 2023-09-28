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
  handleAccess('pageView', 'room management/view', currentUser);
  handleAccess('pageEdit', 'room management/edit', currentUser);
  handleAccess('pageDelete', 'room management/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW ROOM INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CODE : </th>
                  <td class="italic">{{ data.Room.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> NAME : </th>
                  <td class="italic">{{ data.Room.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> BUILDING : </th>
                  <td class="italic">{{ data.Building.name }}</td>
                </tr>
								<tr>
                  <th class="text-right"> ROOM TYPE : </th>
                  <td class="italic">{{ data.RoomType.room_type }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SIZE : </th>
                  <td class="italic">{{ data.Room.size }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.code }} - {{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CAPACITY : </th>
                  <td class="italic">{{ data.Room.capacity }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/room/edit/{{ data.Room.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Room)"><i class="fa fa-trash"></i> DELETE </button>
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
