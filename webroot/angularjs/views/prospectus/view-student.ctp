<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">STUDENT INFORMATION</div>
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
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.YearLevelTerm.year }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.YearLevelTerm.semester }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-12">
            <!-- <button type="button" class="btn btn-info  btn-min" ng-click="print(data.Student.id )"><i class="fa fa-print"></i> PRINT PROSPECTUS </button> -->
             <button type="button" class="btn btn-info  btn-min" ng-click="printCor(data.Student.id )"><i class="fa fa-print"></i> PRINT CERTIFICATE OF REGISTRATION </button>
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
                    <th style="width: 15px;" rowspan="2">#</th>
                    <th class="text-center" rowspan="2"> GRADES </th>
                    <th class="text-center" rowspan="2"> SUBJECT NUMBER </th>
                    <th class="text-center" rowspan="2"> COURSE DESCRIPTION </th>
                    <th class="text-center"> LECTURE </th>
                    <th class="text-center"> LARBORATORY </th>
                    <th class="text-center" rowspan="2"> CREDIT UNITS </th>
                    <th class="text-center" rowspan="2"> PRE-REQUISITES </th>
                  </tr>
                  <tr class="bg-info">
                    <th class="text-center">(HRS)</th>
                    <th class="text-center">(HRS)</th>
                  </tr>
                </thead>
                <tbody ng-repeat="sub in prospectus">
                  <tr>
                    <th class="text-center uppercase" ng-if="sub.semester == '1st Semester'" colspan="8">{{ sub.year }}</th>
                  </tr>
                  <tr>
                    <td class="text-center uppercase" colspan="8">{{ sub.semester }}</td>
                  </tr>
                  <tr ng-repeat="subs in sub.subs">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-center uppercase">{{ subs.final }}</td>
                    <td class="text-center uppercase">{{ subs.course_code }}</td>
                    <td class="text-center uppercase">{{ subs.course }}</td>
                    <td class="text-center uppercase">{{ subs.lecture_hours }}</td>
                    <td class="text-center uppercase">{{ subs.laboratory_hours }}</td>
                    <td class="text-center uppercase">{{ subs.credit_unit }}</td>
                    <td class="text-center uppercase">
                      <div ng-repeat="pre_prequisite in subs.course_prerequisites">{{ pre_prequisite.course }}</div>
                    </td>
                  </tr>
                  <tr ng-if="sub.subs == ''">
                    <td class="text-center" colspan="8">No data available.</td>
                  </tr>
                </tbody>
                <tbody>
                  <tr ng-if="prospectus == ''">
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
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>
