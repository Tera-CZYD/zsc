<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.add('d-none'); // Add Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageView', 'registered students/view', currentUser);
  handleAccess('pagePrintCor', 'registered students/print cor', currentUser);

</script>



<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW REGISTERED STUDENT INFORMATION</div>
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
                  <td class="italic">{{ data.Student.last_name }}, {{ data.Student.first_name }} {{ data.Student.middle_name }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR TERM : </th>
                  <td class="italic" colspan="3">{{ data.YearLevelTerm.description }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-12">
           
              <button id="pagePrintCor" type="button" class="btn btn-info  btn-min" ng-click="print(data.Student.id )"><i class="fa fa-print"></i> PRINT CERTIFICATE OF REGISTRATION </button>
             
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
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                    <th class="text-center"> UNIT </th>
                    <th class="text-center"> TIME </th>
                    <th class="text-center"> DAYS </th>
                    <th class="text-center"> ROOM </th>
                    <th class="text-center"> INSTRUCTOR </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.StudentEnrolledCourse">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.course }}</td>
                    <td class="text-center uppercase">{{ subs.credit_unit }}</td>
                    <td class="text-center uppercase">
                      <div ng-repeat="dats in subs.subs">{{ dats.time }}</div>
                    </td>
                    <td class="text-center uppercase">
                      <div ng-repeat="dats in subs.subs">{{ dats.days }}</div>
                    </td>
                    <td class="text-center uppercase">
                      <div ng-repeat="dats in subs.subs">{{ dats.room }}</div>
                    </td>
                    <td class="text-center uppercase">
                      <div ng-repeat="dats in subs.subs">{{ dats.faculty_name }}</div>
                    </td>
                  </tr>
                  <tr ng-if="data.StudentEnrolledCourse == ''">
                    <td class="text-center" colspan="7">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> GRADES </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                    <th class="text-center"> MIDTERM GRADE </th>
                    <th class="text-center"> FINAL TERM GRADE </th>
                    <th class="text-center"> FINAL GRADE </th>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.StudentEnrolledCourse">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.course }}</td>
                    <td class="text-center uppercase">{{ subs.midterm_grade }}</td>
                    <td class="text-center uppercase">{{ subs.finalterm_grade }}</td>
                    <td class="text-center uppercase">{{ subs.final_grade }}</td>
                  </tr>
                  <tr ng-if="data.StudentEnrolledCourse == ''">
                    <td class="text-center" colspan="7">No data available.</td>
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
