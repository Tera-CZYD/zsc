<?php if (hasAccess('transcript of records/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW TRANSCRIPT OF RECORD INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NUMBER : </th>
                  <td class="italic">{{ data.Student.student_no }}</td>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> STUDENT NAME : </th>
                  <td class="italic">{{ data.Student.proper_name }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-12">
            <?php if (hasAccess('transcript of records/print tor', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.Student.id )"><i class="fa fa-print"></i> PRINT TOR </button>
             <?php endif ?>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> ENROLLED COURSES </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th class="text-center"> COURSE NUMBER </th>
                    <th class="text-center"> COURSE TITLE </th>
                    <th class="text-center"> FINAL <br> GRADES </th>
                    <th class="text-center"> RE-EXAM </th>
                    <th class="text-center"> UNITS OF <br> CREDIT </th>
                  </tr>
                </thead>
                <tbody ng-repeat="sub in tor">
                  <tr>
                    <th class="text-center uppercase" ng-if="sub.semester == '1st Semester'" colspan="8">{{ sub.year }}</th>
                  </tr>
                  <tr>
                    <td class="text-center uppercase" colspan="8">{{ sub.semester }}</td>
                  </tr>
                  <tr ng-repeat="subs in sub.subs">
                    <!-- <td style="width: 15px;"> {{ $index + 1 }} </td> -->
                    <td class="text-center uppercase">{{ subs.course_code }}</td>
                    <td class="text-center uppercase">{{ subs.course }}</td>
                    <td class="text-center uppercase">{{ subs.final }}</td>
                    <td class="text-center uppercase">{{ subs.re_exam }}</td>
                    <td class="text-center uppercase">{{ subs.credit_unit }}</td>
                    <!-- <td class="text-center uppercase">
                      <div ng-repeat="pre_prequisite in subs.course_prerequisites">{{ pre_prequisite.course }}</div>
                    </td> -->
                  </tr>
                  <tr ng-if="sub.subs == ''">
                    <td class="text-center" colspan="8">No data available.</td>
                  </tr>
                </tbody>
                <tbody>
                  <tr ng-if="tor == ''">
                    <td class="text-center" colspan="8">No data available.</td>
                  </tr>
                </tbody>
              </table>
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
