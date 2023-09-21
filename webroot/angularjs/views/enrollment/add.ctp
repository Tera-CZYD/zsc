<div class="row">
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

    <div class="card" style="margin-bottom: 20px;">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <h5> Section : {{ blockSectionData.BlockSection.section }} </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover"> 
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                    <th class="text-center"> FACULTY </th>
                    <th class="text-center"> ROOM </th>
                    <th class="text-center"> SLOT </th>
                    <th class="text-center"> DAY </th>
                    <th class="text-center"> TIME </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="datas in datas">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ datas.course }}</td>
                    <td class="text-left uppercase">{{ datas.faculty_name }}</td>
                    <td class="text-center uppercase">{{ datas.room }}</td>
                    <td class="text-center uppercase">{{ datas.slot }}</td>
                    <td class="text-center uppercase">
                      <div ng-repeat="subs in datas.schedules">{{ subs.day }}</div>
                    </td>
                    <td class="text-center uppercase">
                      <div ng-repeat="subs in datas.schedules">{{ subs.time_start }} - {{ subs.time_end }}</div>
                    </td>
                    <td class="text-center">
                      <div class="btn-group btn-group-xs">
                        <button class="btn btn-primary" ng-click="addCourse(datas,$index)" ng-disabled="datas.btn_status"><i class="fa fa-plus"></i> ADD COURSE </button>
                      </div>
                    </td> 
                  </tr>
                  <tr ng-if="data.BlockSectionSchedule == ''">
                    <td class="text-center" colspan="5">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <h4 class="header-title"> LIST OF SUBJECT(S) TO APPEAR IN THE CERTIFICATE OF REGISTRATION </h4>
            <div class="clearfix"></div><hr>
            <div class="single-table">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover"> 
                  <thead>
                    <tr class="bg-info">
                      <th style="width: 15px;">#</th>
                      <th class="text-center"> Course Title </th>
                      <th class="text-center"> Credit Units </th>
                      <th class="text-center"> Lec Units </th>
                      <th class="text-center"> Lab Units </th>
                      <th class="text-center"> Faculty </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="dats in data.StudentEnrolledCourse">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="text-left">{{ dats.course }}</td>
                      <td class="text-center">{{ dats.credit_unit }}</td>
                      <td class="text-center">{{ dats.lecture_unit }}</td>
                      <td class="text-center">{{ dats.laboratory_unit }}</td>
                      <td class="text-left">{{ dats.faculty_name }}</td>
                      <td class="text-center">
                        <div class="btn-group btn-group-xs">
                          <button class="btn btn-danger" ng-click="removeCourse(dats,$index)"><i class="fa fa-plus"></i> REMOVE COURSE </button>
                        </div>
                      </td> 
                    </tr>
                    <tr ng-if="data.StudentEnrolledCourse == ''">
                      <td class="text-center" colspan="8">No data available.</td>
                    </tr>
                  </tbody>
                </table>
              </div> 
            </div> 
            <h6> <b>Totals:</b>&nbsp;&nbsp;Subject(s) : {{ total_course }} &nbsp;&nbsp;Credit Units = {{ total_credit_unit }}&nbsp; Lecture Units = {{ total_lecture_unit }} &nbsp; Laboratory Units = {{ total_laboratory_unit }}</h6>
            <div class="row">
              <div class="col-md-12">
                <div class="pull-right">
                  <button class="btn btn-primary btn-min" id = "save" ng-click="save();" ng-disabled="data.StudentEnrolledCourse == ''"><i class="fa fa-save"></i> SAVE REGISTRATION </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    

    
  </div>
</div>