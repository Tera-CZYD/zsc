<?php if (hasAccess('program management/view course', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card" style="margin-bottom: 20px">
      <div class="card-body">
        <div class="header-title">VIEW COURSE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgramCourse.curriculum_view }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COURSE : </th>
                  <td class="italic">{{ data.CollegeProgramCourse.course }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR LEVEL AND TERM : </th>
                  <td class="italic">{{ data.YearLevelTerm.description }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('program management/edit', $currentUser)): ?>
                <a href="#/college-program/edit-course/{{ data.CollegeProgramCourse.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT COURSE </a>
               <?php endif ?>
              <?php if (hasAccess('program management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data)"><i class="fa fa-trash"></i> DELETE COURSE </button>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="header-title">REQUISITES</div>
        <div class="clearfix"></div><hr>
        <div class="col-md-6">
          <div class="header-title">PREREQUISITES</div>
          <div class="single-table">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in data.CollegeProgramPrerequisite">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left">{{ sub.Course.code }} - {{ sub.Course.title }}</td>
                  </tr>
                  <tr ng-if="data.CollegeProgramPrerequisite == ''">
                    <td class="text-center" colspan="2">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div> 
          </div>  
        </div>
        <div class="col-md-6">
          <div class="header-title">COREQUISITES</div>
          <div class="single-table">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in data.CollegeProgramCorequisite">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left">{{ sub.Course.code }} - {{ sub.Course.title }}</td>
                  </tr>
                  <tr ng-if="data.CollegeProgramCorequisite == ''">
                    <td class="text-center" colspan="2">No data available.</td>
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
