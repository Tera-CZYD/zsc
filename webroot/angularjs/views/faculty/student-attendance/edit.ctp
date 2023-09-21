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
  handleAccess('pageEdit', 'student attendance/edit', currentUser);

</script>

<div class="row" id="pageEdit">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT ATTENDANCE </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">



            <div class="col-md-3">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.StudentAttendance.date" data-validation-engine="validate[required]">
              </div>
            </div>


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
                  <tr ng-repeat="sub in data.StudentAttendanceSub">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ sub.student_name }}</td> 
                    <td><input icheck="" type="checkbox"  ng-change="getVal()" autocomplete="false" ng-model="data.StudentAttendanceSub[$index].is_present" style="position: absolute; opacity: 1;"></td>
                  </tr>
                  <tr ng-show="data.StudentAttendanceSub == null || data.StudentAttendanceSub == ''">
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
              <button class="btn btn-primary btn-min" id = "update" ng-click="update();"><i class="fa fa-save"></i> Update </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$('#form').validationEngine('attach');
</script>


          

