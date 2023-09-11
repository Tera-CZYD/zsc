<?php if (hasAccess('admin management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW ADMIN INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> EMPLOYEE NO. : </th>
                  <td class="italic uppercase">{{ data.Admin.employee_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FIRST NAME : </th>
                  <td class="italic">{{ data.Admin.first_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MIDDLE NAME : </th>
                  <td class="italic">{{ data.Admin.middle_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> LAST NAME : </th>
                  <td class="italic">{{ data.Admin.last_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DEPARTMENT : </th>
                  <td class="italic">{{ data.Admin.department }}</td>
                </tr>

              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('admin management/edit', $currentUser)): ?>
                <a href="#/settings/admin-management/edit/{{ data.Admin.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('admin management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Admin)"><i class="fa fa-trash"></i> DELETE </button>
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
