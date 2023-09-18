<?php if (hasAccess('student application/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW STUDENT APPLICATION INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right"> SERIAL NUMBER : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.serial_number }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> FIRST NAME : </th>
                  <td class="italic">{{ data.StudentApplication.first_name }}</td>
                  <th class="text-right"> STUDENT ID NUMBER : </th>
                  <td class="italic">{{ data.StudentApplication.student_no }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> MIDDLE NAME : </th>
                  <td class="italic">{{ data.StudentApplication.middle_name }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> LAST NAME : </th>
                  <td class="italic">{{ data.StudentApplication.last_name }}</td>
                  <th class="text-right"> PREFERRED PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.StudentApplication.email }}</td>
                  <th class="text-right"> SECONDARY PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgramSecondary.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STATUS : </th>
                  <td class="italic" ng-if="data.StudentApplication.approve == 0" colspan="3">PENDING</td>
                  <td class="italic" ng-if="data.StudentApplication.approve == 1" colspan="3">APPROVED</td>
                  <td class="italic" ng-if="data.StudentApplication.approve == 2" colspan="3">DISAPPROVED</td>
                </tr>
                <tr ng-if="data.StudentApplication.approve == 1">
                  <th class="text-right"> APPROVED DATE : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.approved_date }}</td>
                </tr>
                <tr ng-if="data.StudentApplication.approve == 2">
                  <th class="text-right"> DISAPPROVED DATE : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.disapproved_date }}</td>
                </tr>
                <tr ng-if="data.StudentApplication.approve == 2">
                  <th class="text-right"> REASON : </th>
                  <td class="italic" colspan="3">{{ data.StudentApplication.disapproved_reason }}</td>
                </tr>
                <tr>
              </table>
            </div> 

            <div class="clearfix"></div><hr>
            <div class="col-md-6">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-left" colspan="2">UPLOADED FILES</th>
                    </tr>
                    <tr>
                      <th class="w30px text-center">#</th>
                      <th class="text-center">FILE NAME</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="image in applicationImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left">
                        <a href="{{ image.imageSrc }}">{{ image.name }}</a>
                      </td>
                    </tr>
                    <tr ng-if = "applicationImage == ''">
                      <td class="text-center" colspan="2">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-6">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-left" colspan="2">REQUIREMENT LIST</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="requirement in requirements">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left">{{ requirement.requirement }}</td>
                    </tr>
                    <tr ng-if = "requirements == ''">
                      <td class="text-center" colspan="2">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('student application/approve application', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="approve(data.StudentApplication)" ng-disabled="data.StudentApplication.approve == 1 || data.StudentApplication.approve == 2 || data.StudentApplication.approve == 3 || data.StudentApplication.approve == 4 || data.StudentApplication.approve == 5" class="btn btn-success  btn-min" ><i class="fa fa-check"></i> APPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('student application/disapprove application', $currentUser)): ?>
                <button href="javascript:void(0)" ng-click="disapprove(data.StudentApplication)" ng-disabled="data.StudentApplication.approve == 1 || data.StudentApplication.approve == 2 || data.StudentApplication.approve == 3 || data.StudentApplication.approve == 4 || data.StudentApplication.approve == 5" class="btn btn-warning  btn-min" ><i class="fa fa-close"></i> DISAPPROVE </button>
              <?php endif ?>
              <?php if (hasAccess('student application/edit', $currentUser)): ?>
                <a href="#/admission/student-application/edit/{{ data.StudentApplication.id }}" ng-disabled="data.StudentApplication.approve == 1 || data.StudentApplication.approve == 2 || data.StudentApplication.approve == 3 || data.StudentApplication.approve == 4 || data.StudentApplication.approve == 5" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('student application/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.StudentApplication)" ng-disabled="data.StudentApplication.approve == 1 || data.StudentApplication.approve == 2 || data.StudentApplication.approve == 3 || data.StudentApplication.approve == 4 || data.StudentApplication.approve == 5"><i class="fa fa-trash"></i> DELETE </button>
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
