<?php if (hasAccess('faculty management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PROGRAM ADVISER INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> FACULTY NO. : </th>
                  <td class="italic">{{ data.ProgramAdviser.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.ProgramAdviser.program }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.ProgramAdviser.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.ProgramAdviser.email }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.ProgramAdviser.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.ProgramAdviser.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE  : </th>
                  <td class="italic">{{ data.ProgramAdviser.date }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('counseling appointment/approve', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="approve(data.ProgramAdviser)" ng-disabled="data.ProgramAdviser.approve == 1 || data.ProgramAdviser.approve == 2 " class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('counseling appointment/disapprove', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disapprove(data.ProgramAdviser)" ng-disabled="data.ProgramAdviser.approve == 1 || data.ProgramAdviser.approve == 2" class="btn btn-danger  btn-min" ><i class="fa fa-close"></i> DISAPPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('faculty management/edit', $currentUser)): ?>
                <a href="#/faculty/program-adviser/edit/{{ data.ProgramAdviser.id }}" class="btn btn-primary btn-min" ng-disabled="data.ProgramAdviser.approve == 1 || data.ProgramAdviser.approve == 2"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('faculty management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.ProgramAdviser)" ng-disabled="data.ProgramAdviser.approve == 1 || data.ProgramAdviser.approve == 2"><i class="fa fa-trash"></i> DELETE </button>
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
