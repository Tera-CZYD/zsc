<?php if (hasAccess('purpose/view', $currentUser)): ?>
<div class="row">
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="header-title"> PURPOSE INFORMATION</div>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">

                                <tr>
                                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                                    <td class="italic">{{ data.Purpose.code }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right" style="width:15%"> PURPOSE : </th>
                                    <td class="italic">{{ data.Purpose.purpose }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <?php if (hasAccess('purpose/edit', $currentUser)): ?>
                            <a href="#/registrar/purpose/edit/{{ data.Purpose.id }}"
                                class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                            <?php endif ?>
                            <?php if (hasAccess('purpose/delete', $currentUser)): ?>
                            <button class="btn btn-danger btn-min" ng-click="remove(data.Purpose)"><i
                                    class="fa fa-trash"></i> DELETE </button>
                            <?php endif ?>
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