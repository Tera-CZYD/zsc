<div class="row" ng-show="alreadyEnrolled != 1">
  <div class="col-lg-12 mt-3">
    <div class="card" style="margin-bottom: 20px;">
      <div class="card-body">
        <h3><b> {{ data.Student.student_no }} : {{ data.Student.last_name | uppercase }}, {{ data.Student.first_name | uppercase }} </b></h3>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-lg-12">
            <h6> College : {{ data.College.name }} </h6>
          </div>
          <div class="col-lg-12">
            <h6> Program : {{ data.CollegeProgram.name }}</h6>
          </div>
          <div class="col-lg-12">
            <h6> Year Level : {{ data.YearLevelTerm.description }}</h6>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="col-lg-12">
          <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
            <li class="nav-item">
              <a class="nav-link active" data-target ="#course_selection" role="tab">COURSE SELECTION</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-target ="#review_create" role="tab">REVIEW & ENROLL</a>
            </li>
          </ul>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="tab-content mt-3" id="myTabContent">
              <div class="tab-pane fade show active" id="course_selection">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thead>
                        <tr class="bg-info">
                          <th colspan="5">AVAILABLE COURSES</th>
                        </tr>
                        <tr class="bg-info">
                          <th>SECTION</th>
                          <th>COURSE</th>
                          <th>SLOT</th>
                          <th>SCHEDULE</th>
                          <th class="w90px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ data.section }}</td>
                          <td class="text-center">{{ data.course }}</td>
                          <td class="text-center">{{ data.slot }}</td>
                          <td class="text-center">
                            <div ng-repeat="sub in data.schedules">{{ sub.day }} ({{ sub.time_start }} - {{ sub.time_end }})</div>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a href="javascript:void(0)" ng-click="addCourse(data)" class="btn btn-primary" title="ADD COURSE"><i class="fa fa-plus"></i></a>
                            </div>
                          </td> 
                        </tr>
                        <tr ng-show="datas == null || datas == ''">
                          <td colspan="7">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
               
                <div class="col-md-12" ng-show="selectedCourse != null && selectedCourse != ''">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thead>
                        <tr class="bg-info">
                          <th colspan="5">SELECTED COURSES</th>
                        </tr>
                        <tr class="bg-info">
                          <th>SECTION</th>
                          <th>COURSE</th>
                          <th>SLOT</th>
                          <th>SCHEDULE</th>
                          <th class="w90px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in selectedCourse">
                          <td class="text-center">{{ data.section }}</td>
                          <td class="text-center">{{ data.course }}</td>
                          <td class="text-center">{{ data.slot }}</td>
                          <td class="text-center">
                            <div ng-repeat="sub in data.schedules">{{ sub.day }} ({{ sub.time_start }} - {{ sub.time_end }})</div>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a href="javascript:void(0)" ng-click="removeCourse($index)" class="btn btn-danger" title="REMOVE COURSE"><i class="fa fa-times"></i></a>
                            </div>
                          </td> 
                        </tr>
                        <tr ng-show="selectedCourse == null || selectedCourse == ''">
                          <td colspan="7">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="pull-right">
                    <button class="btn btn-success btn-sm btn-min" ng-click = "next()">NEXT</button>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show" id="review_create">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thead>
                        <tr class="bg-info">
                          <th>SECTION</th>
                          <th>COURSE</th>
                          <th>SLOT</th>
                          <th>SCHEDULE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in selectedCourse">
                          <td class="text-center">{{ data.section }}</td>
                          <td class="text-center">{{ data.course }}</td>
                          <td class="text-center">{{ data.slot }}</td>
                          <td class="text-center">
                            <div ng-repeat="sub in data.schedules">{{ sub.day }} ({{ sub.time_start }} - {{ sub.time_end }})</div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="pull-right">
                    <button class="btn btn-success btn-sm btn-min" ng-click = "back()">BACK</button>
                    <button class="btn btn-primary btn-min" ng-click="save();"> ENROLL </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<style type="text/css">
  .warning2 {
    margin-bottom: 15px;
    padding: 4px 12px;
    background-color: #ffffcc;
    border-left: 6px solid #ffeb3b;
  }
</style>