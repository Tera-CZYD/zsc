<?php if (hasAccess('room management/view', $currentUser)): ?>
<div class="row">
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
              <?php if (hasAccess('room management/edit', $currentUser)): ?>
                <a href="#/room/edit/{{ data.Room.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('room management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Room)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>
