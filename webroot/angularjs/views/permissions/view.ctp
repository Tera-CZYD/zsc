<?php if (hasAccess('permission management/view', $currentUser)): ?>
<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> PERMISSION</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <dl class="dl-horizontal dl-data dl-bordered">
          <dt>Module:</dt>
          <dd>{{ data.Permission.module }}</dd>

          <dt>Name:</dt>
          <dd class="uppercase">{{ data.Permission.name }}</dd>

          <dt>Action:</dt>
          <dd>{{ data.Permission.action }}</dd>
        </dl>
      </div>

      <div class="clearfix"></div>
      <hr>

      <div class="col-md-3 pull-right">
        <button class="btn btn-danger btn-sm btn-block" ng-click="remove(data.Permission)"><i class="fa fa-trash"></i> DELETE</button>
      </div>

      <div class="col-md-3 pull-right">
        <a href="#/settings/permission-management/edit/{{ data.Permission.id }}" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i> EDIT</a>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
