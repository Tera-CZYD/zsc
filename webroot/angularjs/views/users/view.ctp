<?php if (hasAccess('user management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW USER INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> NAME : </th>
                  <td class="italic">{{ data.User.first_name }} {{ data.User.last_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> USER NAME : </th>
                  <td class="italic">{{ data.User.username }}</td>
                </tr>
                <tr ng-show = "data.Role.name == 'Employee'">
                  <th class="text-right"> EMPLOYEE NAME : </th>
                  <td class="italic">{{ data.User.Employee.proper_name1 }}</td>
                </tr>
                <tr ng-show = "data.Role.name == 'Student'">
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Student.proper_name1 }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STATUS : </th>
                  <td class="italic"><span class="label label-{{ data.User.active? 'success':'danger'}}">{{ data.User.active? 'ACTIVE':'NOT ACTIVE' }}</span></td>
                </tr>
                <tr>
                  <th class="text-right"> VERIFIED : </th>
                  <td class="italic"><span class="label label-{{ data.User.verified? 'primary':'danger'}}">{{ data.User.verified? 'YES':'NO' }}</span></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12 table-wrapper">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <th class="w30px">
                    <input icheck type="checkbox" ng-init="selectAll = false" ng-disabled="data.UserPermission == ''" ng-model="selectAlldelete" ng-change="selectalldelete()">
                  </th>
                  <th class="bg-info" colspan="4">PERMISSIONS</th>
                </thead>
                <tbody>
                  <tr ng-repeat="permission in data.UserPermission">
                    <td>
                      <input icheck type="checkbox" ng-init="permission.selected = false" ng-model="permission.selected">
                    </td>
                    <td class="w30px">{{ $index + 1 }}</td>
                    <td class="uppercase w200px">{{ permission.module }}</td>
                    <td class="uppercase">{{ permission.action }}</td>
                    <td class="w30px">
                      <?php if (hasAccess('user management/delete permission', $currentUser)): ?>
                      <div class="btn-group btn-group-xs">
                        <a class="btn btn-danger no-border-radius" ng-click="removePermission(permission);" ><i class="fa fa-trash"></i></a>
                      </div>
                      <?php endif ?> 
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <?php if (hasAccess('user management/add permission', $currentUser)): ?>
            <button type="button" class="btn btn-primary btn-min" ng-click="addPermission()"><i class="fa fa-plus"></i> ADD PERMISSION</button>
            <?php endif ?> 
            <?php if (hasAccess('user management/delete permission', $currentUser)): ?>
            <button class="btn btn-danger btn-min deletePermission" ng-click="removeselected()"><i class="fa fa-trash"></i> DELETE SELECTED PERMISSION</button>
            <?php endif ?>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">

              <?php if (hasAccess('user management/edit', $currentUser)): ?>
                <a href="#/users/edit/{{data.User.id}}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT</a> 
              <?php endif ?>
              <?php if (hasAccess('user management/delete', $currentUser)): ?>
                <button class="btn btn-danger btn-min" ng-click="remove(data.User)"><i class="fa fa-trash"></i> DELETE</button>
              <?php endif ?>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>

<!-- add permission -->
<div class="modal fade" id="add-permission-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;ADD PERMISSION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12 table-wrapper">
          <div class="table-responsive">
            <table class="table table-bordered center">
              <thead>
                <th class="w30px">
                  <input icheck type="checkbox" ng-init="selectAll = false" ng-model="selectAll" ng-change="selectall()">
                </th>
                <th>MODULE</th>
                <th>PERMISSION</th>
              </thead>
              <tbody>
              <tr ng-repeat="optPermission in data.PermissionSelection">
                  <td>
                    <input icheck type="checkbox" ng-init="optPermission.selected = false" ng-model="optPermission.selected">
                  </td>
                  <td class="uppercase text-left">{{ optPermission.module }}</td>
                  <td class="uppercase text-left">{{ optPermission.action }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm btn-min" data-toggle="modal" data-target="#filter-permission-modal"> FILTER</button>
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min savePermission" ng-click="savePermission()"> <i class="fa fa-save"></i> SAVE</button>
      </div>
    </div>
  </div>
</div>
<!-- .add permission -->
<!-- add permission -->
<div class="modal fade" id="filter-permission-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">FILTER PERMISSION</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>FILTER BY</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
                  <select class="form-control input-sm" ng-model="search.filterBy">
                    <option value="module">MODULE</option>
                    <option value="action">ACTION</option>
                  </select>
                </div>
              </div>
            </div>
            <div ng-show="search.filterBy == 'module'">
              <div class="col-md-12">
                <div class="form-group">
                  <label>MODULE</label>
                  <select class="form-control uppercase" ng-model="search.module" ng-options="opt for opt in data.PermissionModules" ng-change="filterPermission(search)">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div ng-show="search.filterBy == 'action'">
              <div class="col-md-12">
                <div class="form-group">
                  <label>MODULE</label>
                  <select class="form-control uppercase" ng-model="search.action" ng-options="opt for opt in data.PermissionActions" ng-change="filterPermission(search)">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btn-min" data-dismiss="modal"> <i class="fa fa-check"></i> OK</button>
      </div>
    </div>
  </div>
</div>
<!-- .add permission -->

<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>