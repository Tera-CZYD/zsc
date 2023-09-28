
<script type="text/javascript">

  function handleAccess(elementId, permissionCode, currentUser) {
    const element = document.getElementById(elementId);
    const accessGranted = hasAccess(permissionCode, currentUser);
    
    if (accessGranted) {
      element.classList.remove('d-none'); // Remove Bootstrap's "d-none" class to show the element
    } else {
      element.classList.edit('d-none'); // edit Bootstrap's "d-none" class to hide the element
    }
  }

  // INCLUDE ALL PAGE PERMISSION
  handleAccess('pageAdd', 'announcement management/edit', currentUser);

</script>

<div class="row" id="pageAdd">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT ANNOUNCEMENT</div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label> Announcement Title <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.AnnouncementManagement.title" data-validation-engine="validate[required]"/>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label> Announcement Description <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="false" ng-model="data.AnnouncementManagement.content" data-validation-engine="validate[required]"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> Start Date <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.AnnouncementManagement.date_start" data-validation-engine="validate[required]"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> End Date <i class="required">*</i></label>
                <input type="text" class="form-control datepicker" autocomplete="false" ng-model="data.AnnouncementManagement.date_end" data-validation-engine="validate[required]"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> Time Start <i class="required">*</i></label>
                <input type="text" class="form-control clockpicker" autocomplete="false" ng-model="data.AnnouncementManagement.time_start" data-validation-engine="validate[required]"/>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> Time End <i class="required">*</i></label>
                <input type="text" class="form-control clockpicker" autocomplete="false" ng-model="data.AnnouncementManagement.time_end" data-validation-engine="validate[required]"/>
              </div>
            </div>
           </div>
         </div>
       </form>
       <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="update();"><i class="fa fa-save"></i> SAVE </button>
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


          

