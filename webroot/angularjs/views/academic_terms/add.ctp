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
  handleAccess('pageAdd', 'academic term management/add', currentUser);

</script>

<div class="row" id="pageAdd">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW ACADEMIC TERM </div>
        <div class="clearfix"></div><hr>
       	 <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> School Year Start <i class="required">*</i></label>
                <input type="text" class="form-control yearpicker" autocomplete="false" ng-model="data.AcademicTerm.school_year_start" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> School Year End<i class="required">*</i></label>
                <input type="text" class="form-control yearpicker" autocomplete="false" ng-model="data.AcademicTerm.school_year_end" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label> YEAR TERM </label>
                  <select selectize ng-model="data.AcademicTerm.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change="getYear(data.AcademicTerm.year_term_id)" data-validation-engine="validate[required]">
                    <option value=""></option>
                  </select>
                </div>
              </div>
           </div>
         </div>
       </form>
       <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
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


          

