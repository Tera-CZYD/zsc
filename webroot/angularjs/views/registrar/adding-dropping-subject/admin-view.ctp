<?php if (hasAccess('adding dropping subject/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW SUBJECT INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-left" style="width:15%"> STUDENT NO : </th>
                  <td class="italic">{{ data.AddingDroppingSubject.student_no }}</td>
                </tr>
                <tr>
                  <th class="text-left"> STUDENT NAME : </th>
                  <td class="italic">{{ data.AddingDroppingSubject.student_name }}</td>
                </tr>
                 <tr>
                  <th class="text-left"> COLLEGE : </th>
                  <td class="italic">{{ data.AddingDroppingSubject.college }}</td>
                </tr>
                <tr>
                  <th class="text-left"> PROGRAM : </th>
                  <td class="italic">{{ data.AddingDroppingSubject.program }}</td>
                </tr>
                <tr>
                  <th class="text-left"> DATE : </th>
                  <td class="italic">{{ data.AddingDroppingSubject.date }}</td>
                </tr>

                 <tr>
                  <th class="text-left"> REASON/S : </th>
                  <td class="italic">{{ data.AddingDroppingSubject.reason }}</td>
                </tr>

              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bg-info">
                  <th colspan="5">ADDED/DROPPED SUBJECT INFORMATION</th>
                </tr>
                <tr>
                  <th class="w30px text-center">#</th>
                  <th class="text-center">INTRUCTOR</th>
                  <th class="text-center">SUBJECT/S</th>
                  <th class="text-center">STATUS</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="datax in data.AddingDroppingSubjectSub" ng-class="{'bg-danger text-white': datax.status === 'DROP','bg-success text-white': datax.status === 'ADD'}">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td class="text-center">{{ datax.faculty_name }}</td>
                  <td class="text-center">{{ datax.course_title }}</td>
                  <td class="text-center">{{ datax.status }}</td>
                </tr>
              </tbody>
              <tbody ng-if="data.AddingDroppingSubjectSub == '' || data.AddingDroppingSubjectSub == null">
                <td colspan="6" class="text-center">No data available</td>
              </tbody>
            </table>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

           <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('adding dropping subject/approve', $currentUser)): ?>
              <button href="javascript:void(0)" ng-click="approve(data.AddingDroppingSubject)" ng-disabled="data.AddingDroppingSubject.approve == 1 || data.AddingDroppingSubject.approve == 2" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>

              <?php if (hasAccess('adding dropping subject/disapprove', $currentUser)): ?>
              <button href="javascript:void(0)" ng-click="disapprove(data.AddingDroppingSubject)" ng-disabled="data.AddingDroppingSubject.approve == 1 || data.AddingDroppingSubject.approve == 2" class="btn btn-warning  btn-min" ><i class="fa fa-check"></i> DISAPPROVE </button>
              <?php endif ?>
              
            </div> 
          </div>

          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('adding dropping subject/edit', $currentUser)): ?>
              <a href="#/registrar/admin-adding-dropping-subject/edit/{{ data.AddingDroppingSubject.id }}" ng-disabled="data.AddingDroppingSubject.approve == 1 || data.AddingDroppingSubject.approve == 2" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>

              <?php if (hasAccess('adding dropping subject/print adding dropping form', $currentUser)): ?>
                <button type="button" class="btn btn-info  btn-min" ng-click="print(data.AddingDroppingSubject.id )"><i class="fa fa-print"></i> PRINT ADDING/DROPPING SUBJECT FORM </button>
                <?php endif ?>

              <?php if (hasAccess('adding dropping subject/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.AddingDroppingSubject)"><i class="fa fa-trash"></i> DELETE </button>
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
