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
  handleAccess('pageEdit', 'faculty student attendance/edit', currentUser);

</script>


<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT COURSE</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CODE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.Course.code" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> TITLE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.Course.title" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> DESCRIPTION </label>
                <textarea type="text" class="form-control" ng-model="data.Course.description"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <table class="table table-bordered center">
                <tr>
                  <th></th>
                  <th class="text-center" style="width: 10%"> HOURS </th>
                  <th class="text-center" style="width: 10%"> UNITS </th>
                </tr>
                <tr>
                  <th class="text-left"> LECTURE </th>
                  <td class="text-center">
                    <input type="text" class="form-control text-center" numberdecimal ng-model="data.Course.lecture_hours" ng-change="getCreditHours()">
                  </td>
                  <td class="text-right">
                    <input type="text" class="form-control text-center" numberdecimal ng-model="data.Course.lecture_unit" ng-change="getCreditUnit()">
                  </td>
                </tr>
                <tr>
                  <th class="text-left"> LABORATORY </th>
                  <td class="text-center">
                    <input type="text" class="form-control text-center" numberdecimal ng-model="data.Course.laboratory_hours" ng-change="getCreditHours()">
                  </td>
                  <td class="text-right">
                    <input type="text" class="form-control text-center" numberdecimal ng-model="data.Course.laboratory_unit" ng-change="getCreditUnit()">
                  </td>
                </tr>
                <tr>
                  <th class="text-left"> CREDIT </th>
                  <td class="text-center">
                    <input type="text" class="form-control text-center" numberdecimal ng-model="data.Course.credit_hours">
                  </td>
                  <td class="text-right">
                    <input type="text" class="form-control text-center" numberdecimal ng-model="data.Course.credit_unit">
                  </td>
                </tr>
              </table>
            </div>
          </div>  
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
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


          

