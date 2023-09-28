<?php if (hasAccess('scholastic document/view', $currentUser)): ?>
<div class="row">
    <div class="col-lg-12 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="header-title"> SCHOLASTIC DOCUMENT INFORMATION</div>
                <div class="clearfix"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">

                                <tr>
                                    <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                                    <td class="italic">{{ data.ScholasticDocument.code }}</td>
                                </tr>
                                <tr>
                                    <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                                    <td class="italic">{{ data.ScholasticDocument.title }}</td>
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
                            <?php if (hasAccess('scholastic document/edit', $currentUser)): ?>
                            <a href="#/registrar/scholastic-document/edit/{{ data.ScholasticDocument.id }}"
                                class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                            <?php endif ?>
                            <?php if (hasAccess('scholastic document/delete', $currentUser)): ?>
                            <button class="btn btn-danger btn-min" ng-click="remove(data.ScholasticDocument)"><i
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