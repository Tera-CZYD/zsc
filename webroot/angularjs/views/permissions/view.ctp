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
  handleAccess('pageView', 'permission management/view', currentUser);
  handleAccess('pageEdit', 'permission management/edit', currentUser);
  handleAccess('pageDelete', 'permission management/delete', currentUser);

</script>

<div class="panel panel-primary" id="pageView">
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
        <button id="pageDelete" class="btn btn-danger btn-sm btn-block" ng-click="remove(data.Permission)"><i class="fa fa-trash"></i> DELETE</button>
      </div>
      <div class="col-md-3 pull-right">
        <a id="pageEdit" href="#/settings/permission-management/edit/{{ data.Permission.id }}" class="btn btn-primary btn-sm btn-block"><i class="fa fa-pencil"></i> EDIT</a>
      </div>
    </div>
  </div>
</div>
