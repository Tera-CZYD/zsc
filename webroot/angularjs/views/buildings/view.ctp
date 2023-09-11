<?php if (hasAccess('building management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW BUILDING INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CODE : </th>
                  <td class="italic">{{ data.Building.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> NAME : </th>
                  <td class="italic">{{ data.Building.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> LOCATION : </th>
                  <td class="italic">{{ data.Building.location }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.Building.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FLOORS : </th>
                  <td class="italic">{{ data.Building.floors }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('building management/edit', $currentUser)): ?>
                <a href="#/building/edit/{{ data.Building.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('building management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Building)"><i class="fa fa-trash"></i> DELETE </button>
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
