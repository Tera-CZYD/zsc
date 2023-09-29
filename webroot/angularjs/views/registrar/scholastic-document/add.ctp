<?php if (hasAccess('scholastic document/add', $currentUser)): ?>
<div class="row">
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="header-title">ADD NEW SCHOLASTIC DOCUMENT</div>
                <div class="clearfix"></div>
                <hr>
                <form id="form">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label> CODE <i class="required">*</i></label>
                                <input type="text" class="form-control uppercase" autocomplete="off"
                                    ng-model="data.ScholasticDocument.code" data-validation-engine="validate[required]">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> TITLE/NAME <i class="required">*</i></label>
                                <input type="text" class="form-control uppercase" autocomplete="off"
                                    ng-model="data.ScholasticDocument.title" data-validation-engine="validate[required]">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label> ACRONYM <i class="required">*</i></label>
                                <input type="text" class="form-control uppercase" autocomplete="off"
                                    ng-model="data.ScholasticDocument.acronym" data-validation-engine="validate[required]">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label> SERIAL <i class="required">*</i></label>
                                <input type="text" class="form-control uppercase" autocomplete="off"
                                    ng-model="data.ScholasticDocument.serial" data-validation-engine="validate[required]">
                            </div>
                        </div>

                    </div>
                        
                </form>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i
                                    class="fa fa-save"></i> SAVE </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif ?>
<style type="text/css">
th {
    white-space: nowrap;
}

td {
    white-space: nowrap;
}
</style>