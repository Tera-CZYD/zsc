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
  handleAccess('pageView', 'program management/view', currentUser);
  handleAccess('pageEdit', 'program management/edit', currentUser);
  handleAccess('pageDelete', 'program management/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW PROGRAM INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> PROGRAM CODE : </th>
                  <td class="italic">{{ data.CollegeProgram.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM NAME : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM TERM : </th>
                  <td class="italic">{{ data.ProgramTerm.term }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM ID : </th>
                  <td class="italic">{{ data.CollegeProgram.program_name }}</td>
                </tr>
                <!-- <tr>
                  <th class="text-right"> ACRONYM : </th>
                  <td class="italic">{{ data.CollegeProgram.acronym }}</td>
                </tr> -->

                <tr>
                  <th class="text-right"> CAPACITY : </th>
                  <td class="italic">{{ data.CollegeProgram.capacity }}</td>
                </tr>

                <tr>
                  <th class="text-right"> NO. OF YEARS : </th>
                  <td class="italic">{{ data.CollegeProgram.no_of_years }}</td>
                </tr>
                <tr>
                  <th class="text-right"> TOTAL NO. OF TERMS : </th>
                  <td class="italic">{{ data.CollegeProgram.no_of_terms }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PASSING RATE : </th>
                  <td class="italic">{{ data.CollegeProgram.passing_rate }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">        
            <div class="clearfix"></div><hr>
            <div id="accordion1" class="according">
              <div class="card-header">
                <a class="card-link" data-toggle="collapse" data-target="#requirements" style="cursor: pointer"><h5>REQUIREMENTS</h5></a>
              </div>
              <div id="requirements" class="collapse" data-parent="#accordion1">
                <div class="row">
                  <div class="col-md-12" style="width:100%; height:100%; overflow-y:auto;">
                    <table class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr class="bg-info">
                          <th style="width: 15px;">#</th>
                          <th class="text-center"> REQUIREMENT </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="subs in data.CollegeProgramSub">
                          <td style="width: 15px;"> {{ $index + 1 }} </td>
                          <td class="text-left uppercase">{{ subs.requirement }}</td>
                        </tr>
                        <tr ng-if="data.CollegeProgramSub == ''">
                          <td class="text-center" colspan="2">No data available.</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/college-program/edit/{{ data.CollegeProgram.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a> 
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.CollegeProgram)"><i class="fa fa-trash"></i> DELETE </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="header-title">COURSES</div>
        <div class="clearfix"></div><hr>

        <div class="col-md-12">
          <div class="form-group">
            <?php if (hasAccess('program management/add course', $currentUser)): ?>
              <a href="#/college-program/add-course/{{ data.CollegeProgram.id }}" class="btn btn-success btn-min"><i class="fa fa-plus"></i> ADD COURSE </a>
            <?php endif ?>
          </div>
        </div> 
        <div class="col-md-12">
          <div class="clearfix"></div><hr>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label> YEAR LEVEL AND TERM </label>
            <select class="form-control" ng-model="year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getRecords(year_term_id)">
              <option value=""></option>
            </select>
          </div>
        </div> 
        <div class="col-md-12">
          <div class="clearfix"></div><hr>
        </div>
        <div class="col-md-12">
          <div class="single-table">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center" style="width: 15%"> COURSE CODE </th>
                    <th class="text-center"> COURSE TITLE </th>
                  <th style="width: 120px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in data.CollegeProgramCourse">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left">{{ sub.code }}</td>
                    <td class="text-left">{{ sub.title }}</td>
                    <td class="w90px text-center">
                        <a id="pageView" href="#/college-program/view-course/{{ sub.id }}" class="btn btn-xs btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                        <a id="pageDelete" href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeCourse(sub)" title="REMOVE"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr ng-if="data.CollegeProgramCourse == ''">
                    <td class="text-center" colspan="4">No data available.</td>
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
