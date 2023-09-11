<?php if (hasAccess('student club/view', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">STUDENT CLUB INFORMATION</div>
          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-striped">

                  <tr>
                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                    <td class="italic">{{ data.StudentClub.code }}</td>
                  </tr>
                  <tr>
                    <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                    <td class="italic">{{ data.StudentClub.student_name }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> DATE : </th>
                    <td class="italic">{{ data.StudentClub.date }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> POSITION : </th>
                    <td class="italic">{{ data.StudentClub.position }}</td>
                  </tr>
                  <tr>
                    <th class="text-right"> CLUB : </th>
                    <td class="italic">{{ data.Club.title }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="clearfix"></div>
            


              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div>
              <hr>
            </div>
            <div class="col-md-12">
              <div class="pull-right">
                <?php if (hasAccess('student club/edit', $currentUser)) : ?>
                  <a href="#/registrar/admin-student-club/edit/{{ data.StudentClub.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <?php endif ?>
                <?php if (hasAccess('student club/approve', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="approve(data.StudentClub)" ng-disabled="data.StudentClub.approve > 0" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
                <?php if (hasAccess('student club/disapprove', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disapprove(data.StudentClub)" ng-disabled="data.StudentClub.approve > 0 " class="btn btn-warning  btn-min" ><i class="fa fa-times"></i> DISAPPROVE </button>
              <?php endif ?>
                <!-- <?php if (hasAccess('student club/print', $currentUser)) : ?>
                  <button type="button" class="btn btn-info  btn-min" ng-click="print(data.RequestForm.id )"><i class="fa fa-print"></i> PRINT REQUEST FORM </button>
                <?php endif ?> -->
                <?php if (hasAccess('student club/delete', $currentUser)) : ?>
                  <button class="btn btn-danger btn-min" ng-click="remove(data.StudentClub)"><i class="fa fa-trash"></i> DELETE </button>
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