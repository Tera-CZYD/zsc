<?php if (hasAccess('student clearance/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">STUDENT CLEARANCE INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.StudentClearance.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.StudentClearance.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MAJOR : </th>
                  <td class="italic">{{ data.StudentClearance.major }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR LEVEL - SEMESTER : </th>
                  <td class="italic">{{ data.YearLevelTerm.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SCHOOL YEAR : </th>
                  <td class="italic">{{ data.StudentClearance.school_year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SA NUMBER : </th>
                  <td class="italic">{{ data.StudentClearance.sa_number }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('studnet clearance/edit', $currentUser)): ?>
                <a href="#/faculty/student-clearance/edit/{{ data.StudentClearance.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('student clearance/print student clearance', $currentUser)): ?>
                <button type="button" class="btn btn-info  btn-min" ng-click="print(data.StudentClearance.id )"><i class="fa fa-print"></i> PRINT STUDENT CLEARANCE FORM </button>
              <?php endif ?>
              <?php if (hasAccess('student clearance/delete', $currentUser)): ?>
                <button class="btn btn-danger btn-min" ng-click="remove(data.StudentClearance)"><i class="fa fa-trash"></i> DELETE </button>
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