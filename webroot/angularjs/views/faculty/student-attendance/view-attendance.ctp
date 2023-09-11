<?php if (hasAccess('student attendance/view attendance', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW ATTENDANCE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> COURSE : </th>
                  <td class="italic" >{{ data.BlockSectionCourse[0].course }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> SECTION : </th>
                  <td class="italic" >{{ data.BlockSection.section }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> SCHEDULE </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover"> 
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> DAY </th>
                    <th class="text-center"> TIME </th>
                    <th class="w90px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.BlockSectionSchedule">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-center">{{ subs.day }}</td>
                    <td class="text-center">{{ subs.time_start }} - {{ subs.time_end }}</td>
                    <td>
                    <div class="btn-group btn-group-xs">
                      <?php if (hasAccess('student attendance/view', $currentUser)): ?>
                        <a href="javascript:void(0)" ng-click="viewAttendance($index, subs)" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                      <?php endif ?> 
                    </div>
                  </td>
                  </tr>
                  <tr ng-if="data.BlockSectionSchedule == ''">
                    <td class="text-center" colspan="9">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>

<div class="modal fade" id="view-attendance-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-book"></i> ATTENDANCE </h5>
        <button type="button" class="close" ng-click="reFetch()" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="view_attendance_form"> 
          <div class="col-md-12" >
            <div class="form-group">
              <label> DATE <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="date" ng-options="opt.id as opt.value for opt in subs" ng-change="getStudentLists(date)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;" rowspan="2">#</th>
                    <th class="text-center"> STUDENT NAME </th>
                    <th class="text-center"> ATTENDANCE </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in datas">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-center">{{ sub.student_name }}</td>
                    <td class="text-center">{{ sub.is_present }}</td>
                  </tr>
                  <tr ng-if="datas == '' || datas == null">
                    <td class="text-center" colspan="11">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <a ng-show="date" ng-click="editAttendance()" class="btn btn-primary btn-sm btn-min"><i class="fa fa-pen"></i> EDIT </a>
        <a ng-show="date" ng-click="remove(date)" class="btn btn-warning btn-sm btn-min"><i class="fa fa-times"></i> DELETE </a>
        <button type="button" class="btn btn-danger btn-sm btn-min" ng-click="reFetch()" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
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
