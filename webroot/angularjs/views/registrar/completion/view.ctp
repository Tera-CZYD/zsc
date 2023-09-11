<?php if (hasAccess('completion form/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">COURSE COMPLETION FORM INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Completion.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Completion.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.Completion.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REQUIREMENT : </th>
                  <td class="italic">{{ data.Completion.requirement }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.Completion.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> INSTRUCTOR : </th>
                  <td class="italic">{{ data.Completion.instructor }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SEMESTER : </th>
                  <td class="italic">{{ data.Completion.semester }}</td>
                </tr>
                <tr>
                  <th class="text-right"> OR NUMBER : </th>
                  <td class="italic">{{ data.Completion.or_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SCHOOL YEAR : </th>
                  <td class="italic">{{ data.Completion.school_year }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('completion form/edit', $currentUser)): ?>
              <a href="#/registrar/completion/edit/{{ data.Completion.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('completion form/print', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.Completion.id )"><i class="fa fa-print"></i> PRINT COMPLETION FORM </button>
              <?php endif ?>
              <?php if (hasAccess('completion form/delete', $currentUser)): ?>
              <button class="btn btn-danger btn-min" ng-click="remove(data.Completion)"><i class="fa fa-trash"></i> DELETE </button>
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