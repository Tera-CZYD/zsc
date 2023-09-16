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
  handleAccess('pageEdit', 'purpose/edit', currentUser);

</script>

<div class="row" id="pageEdit">
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="header-title">EDIT PURPOSE</div>
                <div class="clearfix"></div>
                <hr>
                <form id="form">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label> CODE <i class="required">*</i></label>
                                <input type="text" class="form-control uppercase" autocomplete="off"
                                    ng-model="data.Purpose.code" data-validation-engine="validate[required]">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> TITLE/NAME <i class="required">*</i></label>
                                <input type="text" class="form-control uppercase" autocomplete="off"
                                    ng-model="data.Purpose.purpose" data-validation-engine="validate[required]">
                            </div>
                        </div>
                    </div>
                        
                </form>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-primary btn-min" id="save" ng-click="update();"><i
                                    class="fa fa-save"></i> UPDATE </button>
                        </div>
                    </div>
                </div>
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