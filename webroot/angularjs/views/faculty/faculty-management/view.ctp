<?php if (hasAccess('faculty management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW FACULTY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> FACULTY NO. : </th>
                  <td class="italic">{{ data.Employee.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FAMILY NAME : </th>
                  <td class="italic">{{ data.Employee.family_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GIVEN NAME : </th>
                  <td class="italic">{{ data.Employee.given_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MIDDLE NAME : </th>
                  <td class="italic">{{ data.Employee.middle_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.code }} - {{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.Employee.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> BIRTH DATE : </th>
                  <td class="italic">{{ data.Employee.birthdate }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ACADEMIC RANK : </th>
                  <td class="italic">{{ data.Employee.academic_rank }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SPECIALIZATION : </th>
                  <td class="italic">{{ data.Specialization.name }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <div class="pull-right">
              <?php if (hasAccess('faculty management/edit', $currentUser)): ?>
                <a href="#/faculty/faculty-management/edit/{{ data.Employee.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('faculty management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Employee)"><i class="fa fa-trash"></i> DELETE </button>
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
