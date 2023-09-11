<?php if (hasAccess('role management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW ROLE</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-left" style="width:15%"> NAME : </th>
                  <td class="italic">{{ data.Role.name }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12 table-wrapper">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th class="text-center" colspan="3">ROLE PERMISSION</th>
                  </tr>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> MODULES </th>
                    <th class="text-center"> ACTION  </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in data.RolePermission">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left">{{ sub.module }}</td>
                    <td class="text-center">{{ sub.action }}</td>
                  </tr>
                  <tr ng-if="data.RolePermission == '' || data.RolePermission == null">
                    <td class="text-center" colspan="3">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('role management/edit', $currentUser)): ?>
                <a href="#/roles/edit/{{ data.Role.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('role management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Role)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>

<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>
