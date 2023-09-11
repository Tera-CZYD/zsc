<?php if (hasAccess('student attendance/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW FACULTY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> FACULTY NO. : </th>
                  <td class="italic">{{ data.Employee.code }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.code }} - {{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FAMILY NAME : </th>
                  <td class="italic">{{ data.Employee.family_name }}</td>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.Employee.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GIVEN NAME : </th>
                  <td class="italic">{{ data.Employee.given_name }}</td>
                  <th class="text-right"> ACADEMIC RANK : </th>
                  <td class="italic">{{ data.Employee.academic_rank }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MIDDLE NAME : </th>
                  <td class="italic" colspan="3">{{ data.Employee.middle_name }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize ng-model="data.StudentClearance.course_id" ng-options="opt.id as opt.value for opt in course" ng-change = "getDatas();">
                <option value=""></option>
              </select>
            </div>
          </div>

          <!-- <div class="col-md-4">
            <div class="form-group">
              <label> SELECT PROGRAM </label>
              <select selectize ng-model="program_id" ng-options="opt.id as opt.value for opt in programs" ng-change = "getDatas();">
                <option value=""></option>
              </select>
            </div>
          </div> -->

          <!-- <div class="col-md-4">
            <div class="form-group">
              <label> SELECT COURSE </label>
              <select selectize ng-model="course_id" ng-options="opt.course_id as opt.value for opt in courses" ng-change = "getDatas()">
                <option value=""></option>
              </select>
            </div>
          </div>  -->

          <!-- <div class="col-md-2">
            <div class="form-group">
              <label> SELECT SECTION </label>
              <select selectize ng-model="section_id" ng-options="opt.id as opt.value for opt in sections" ng-change = "getDatas()">
                <option value=""></option>
              </select>
            </div>
          </div>  -->

          <!-- <div class="col-md-2">
            <div class="form-group">
              <label> SELECT YEAR TERM </label>
              <select selectize ng-model="year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getDatas()">
                <option value=""></option>
              </select>
            </div>
          </div>  -->



          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>


          <?php if (hasAccess('student attendance/registrar', $currentUser)): ?>
          <div class="col-md-12">
             <div class="header-title">CLASS SCHEDULES {{datas }}</div><br>
            <!-- <button class="btn btn-danger btn-min" ng-click="print();" ng-disabled="bool"><i class="fa fa-print"></i> PRINT REPORT OF RATING </button> -->
          </div>
          <?php endif ?>


          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th class="text-center" style="width:3%">#</th>
                    <th class="text-center" >COURSE</th>
                    <th class="text-center" >SECTION</th>
                    <th class="text-center" >YEAR</th>
                    <th class="w90px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in datas">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ sub.course }}</td>
                    <td class="text-center">{{ sub.section }}</td>
                    <td class="text-center">{{ sub.year_term }}</td>
                    <td>
                    <div class="btn-group btn-group-xs">
                      <?php if (hasAccess('student attendance/add', $currentUser)): ?>
                        <a href="#/faculty/student-attendance/add/{{ sub.faculty_id }}/{{ sub.block_section_course_id }}/{{ sub.course_id }}" class="btn btn-success" title="ADD"><i class="fa fa-plus"></i></a>
                      <?php endif ?>
                      <?php if (hasAccess('student attendance/view attendance', $currentUser)): ?>
                        <a href="#/faculty/student-attendance/view-attendance/{{ sub.block_section_id }}/{{ sub.block_section_course_id }}/{{ sub.course_id }}" class="btn btn-primary" title="VIEW ATTENDACE"><i class="fa fa-eye"></i></a>
                      <?php endif ?> 
                    </div>
                  </td> 
                  </tr>
                  <tr ng-show="datas == null || datas == ''">
                    <td class="text-center" colspan="9">No available data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <!-- <?php if (hasAccess('student attendance/registar', $currentUser)): ?>
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();" ng-disabled="bool"><i class="fa fa-save"></i> SAVE GRADE </button>
              <?php endif ?> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<!-- <style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style> -->
