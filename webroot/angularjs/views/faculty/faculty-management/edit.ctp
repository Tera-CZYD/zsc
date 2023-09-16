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
  handleAccess('pageEdit', 'faculty management/edit', currentUser);

</script>

<div class="row" id="pageEdit">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT FACULTY </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> FACULTY NO. <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.Employee.code" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> FAMILY NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.Employee.family_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> GIVEN NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.Employee.given_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> MIDDLE NAME <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.Employee.middle_name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select class="form-control" ng-model="data.Employee.college_id" ng-options="opt.id as opt.value for opt in colleges" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div> 
            <div class="col-md-3" >
              <div class="form-group">
                <label> GENDER <i class="required">*</i></label>
                <select class="form-control" ng-model="data.Employee.gender" data-validation-engine="validate[required]">
                  <option value=""></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> BIRTH DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" ng-model="data.Employee.birthdate" data-validation-engine="validate[required]">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label> ACADEMIC RANK <i class="required">*</i></label>
                <select class="form-control" ng-model="data.Employee.academic_rank_id" ng-options="opt.id as opt.value for opt in academic_ranks" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div> 

            <div class="col-md-6">
              <div class="form-group">
                <label> SPECIALIZATION <i class="required">*</i></label>
                <select class="form-control" ng-model="data.Employee.specialization_id" ng-options="opt.id as opt.value for opt in specialization" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div> 
          </div>  
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> UPDATE </button>
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


          

