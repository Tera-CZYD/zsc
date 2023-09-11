<?php if (hasAccess('role management/edit', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT ROLE</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> NAME </label>
                <input type="text" class="form-control" ng-model="data.Role.name" data-validation-engine="validate[required]">
              </div>
            </div>
            
            <div class="clearfix"></div><hr>
            <div class="col-md-12 table-wrapper" id="myDiv">
              <table class="table table-bordered">
                <thead>
                  <th class="w30px">
                    <input icheck type="checkbox" ng-init="selectAll = false" ng-disabled="data.RolePermission == ''" ng-model="selectAlldelete" ng-change="selectalldelete()">
                  </th>
                  <th class="bg-info" colspan="4">PERMISSIONS</th>
                </thead>
                <tbody>
                  <tr ng-repeat="permission in data.RolePermission">
                    <td>
                      <input icheck type="checkbox" ng-init="permission.selected = false" ng-model="permission.selected">
                    </td>
                    <td class="w30px">{{ $index + 1 }}</td>
                    <td class="uppercase w200px">{{ permission.module }}</td>
                    <td class="uppercase">{{ permission.action }}</td>
                    <td class="w30px">
                      <?php if (hasAccess('user management/delete permission', $currentUser)): ?>
                      <div class="btn-group btn-group-xs">
                        <a class="btn btn-danger no-border-radius" ng-click="removePermission($index,permission);" ><i class="fa fa-trash"></i></a>
                      </div>
                      <?php endif ?> 
                    </td>
                  </tr>
                  <tr ng-if="data.RolePermission == '' || data.RolePermission == null">
                    <td class="text-center" colspan="2">No available data</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <div class="btn-group btn-group-sm btn-min">
                <button type="button" class="btn btn-primary btn-min" ng-click="addPermission()"><i class="fa fa-plus"></i> ADD PERMISSION</button>
                <button class="btn btn-danger btn-min deletePermission" ng-click="removeselected()"><i class="fa fa-trash"></i> DELETE SELECTED PERMISSION</button>
              </div>
            </div>
          </div>
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
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
        <table class="table table-bordered center">
          <thead>
            <th class="w30px">
              <input icheck type="checkbox" ng-init="selectAll = false" ng-model="selectAll" ng-change="selectall()">
            </th>
            <th>MODULE</th>
            <th>PERMISSION</th>
          </thead>
          <tbody>
          <tr ng-repeat="optPermission in permissions" ng-if="optPermission.selecteds != 1">
              <td>
                <input icheck type="checkbox" ng-init="optPermission.selected = false" ng-model="optPermission.selected">
              </td>
              <td class="uppercase text-left">{{ optPermission.module }}</td>
              <td class="uppercase text-left">{{ optPermission.action }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger  btn-min" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;CANCEL</button>
        <button type="button" class="btn btn-primary  btn-min savePermission" ng-click="savePermission()"><i class="fa fa-save"></i>&nbsp; SAVE</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">FILTER PERMISSION</h4>
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
        <button type="button" class="btn btn-primary  btn-min" data-dismiss="modal"> <i class="fa fa-check"></i> OK</button>
      </div>
    </div>
  </div>
</div>
<!-- .add permission -->
<style>
  .table-wrapper{
    width:100%;
    height:450px;
    overflow-y:auto;
  }
</style>


