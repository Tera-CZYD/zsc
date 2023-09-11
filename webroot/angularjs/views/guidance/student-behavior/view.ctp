<?php if (hasAccess('student behavior/view', $currentUser)): ?>
<div class="row">
<div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">STUDENT BEHAVIOR INFORMATION</div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.StudentBehavior.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.StudentBehavior.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COURSE : </th> 
                  <td class="italic">{{ data.CollegeProgram.code }} - {{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.StudentBehavior.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT BEHAVIOR : </th>
                  <td class="italic">{{ data.StudentBehavior.behavior }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="text-right">
             <?php if (hasAccess('student behavior/edit', $currentUser)): ?>
              <a href="#/registrar/student-behavior/edit/{{ data.StudentBehavior.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('student behavior/print student behavior', $currentUser)): ?>
              <!-- <button type="button" class="btn btn-info  btn-min" ng-click="print(data.StudentBehavior.id )"><i class="fa fa-print"></i> PRINT STUDENT BEHAVIOR </button> -->
              <?php endif ?>
              <?php if (hasAccess('student behavior/delete', $currentUser)): ?>
              <button class="btn btn-danger btn-min" ng-click="remove(data.StudentBehavior)"><i class="fa fa-trash"></i> DELETE </button>
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