<?php if (hasAccess('student attendance/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW ATTENDANCE </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">



            <div class="col-md-6">
              <div class="form-group">
                <label> DAY OF SCHEDULE <i class="required">*</i></label>
                <select ng-disabled="is_empty == false" selectize ng-model="data.StudentAttendance.class_schedule_day_id" ng-options="opt.id as opt.value for opt in scheduledays" ng-change="getStudents(data.StudentAttendance.class_schedule_day_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>


            <div class="col-md-3">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.StudentAttendance.date" data-validation-engine="validate[required]">
              </div>
            </div>

            <input type="hidden" class="form-control" ng-model="data.StudentAttendance.block_section_schedule_id" data-validation-engine="validate[required]">

            <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th class="text-center" style="width:3%">#</th>
                    <th class="text-center" >STUDENT</th>
                    <th class="w90px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in adata">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ sub.name }}</td> 
                    <td><input icheck="" type="checkbox"  ng-change="getVal()" autocomplete="false" ng-model="data.StudentAttendanceSub[$index].is_present" style="position: absolute; opacity: 1;"></td>
                  </tr>
                  <tr ng-show="adata == null || adata == ''">
                    <td class="text-center" colspan="9">No available data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </form>


        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" ng-disabled="is_empty == false" id = "save" ng-click="save();"><i class="fa fa-save" ></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>


          

