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
  handleAccess('pageAdd', 'program adviser/add', currentUser);

</script>


<div class="row" id="pageAdd">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW PROGRAM ADVISER </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.ProgramAdviser.code">
              </div>
            </div>

           <div class="col-md-6">
              <div class="form-group">
                <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudentApplication({ search: searchTxt })">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="form-group">
                  <label> STUDENT NAME <i class="required">*</i></label>
                  <input type="text" class="form-control" ng-model="data.ProgramAdviser.student_name" data-validation-engine="validate[required]">
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> AGE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.ProgramAdviser.age" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> EMAIL <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.ProgramAdviser.email" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> CONTACT NO <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.ProgramAdviser.contact_no" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> GENDER <i class="required">*</i></label>
                <select selectize ng-model="data.ProgramAdviser.gender" data-validation-engine="validate[required]">
                  <option value=""> </option>
                  <option value="Male">MALE</option>
                  <option value="Female">FEMALE</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.ProgramAdviser.program" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> DATE <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.ProgramAdviser.date" data-validation-engine="validate[required]">
              </div>
            </div>

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
  </form>
</div>
<script>
$('#form').validationEngine('attach');
</script>


          

