<?php if (hasAccess('student log/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW LOG INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NO : </th>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Student'">{{ data.StudentLog.student_no }}</td>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Employee'">{{ data.StudentLog.employee_no }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Student'">{{ data.StudentLog.student_name }}</td>
                  <td class="italic" ng-show="data.StudentLog.classification == 'Employee'">{{ data.StudentLog.employee_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.StudentLog.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TIME : </th>
                  <td class="italic">{{ data.StudentLog.time }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONCERN : </th>
                  <td class="italic">{{ data.StudentLog.concern }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('student log/edit', $currentUser)): ?>
                <a href="#/medical-services/student-log/edit/{{ data.StudentLog.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('student log/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.StudentLog)"><i class="fa fa-trash"></i> DELETE </button>
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
