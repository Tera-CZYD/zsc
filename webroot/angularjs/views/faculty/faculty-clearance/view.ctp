<?php if (hasAccess('faculty clearance/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW FACULTY CLEARANCE</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.FacultyClearance.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> FACULTY NAME : </th>
                  <td class="italic">{{ data.FacultyClearance.faculty_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.FacultyClearance.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COMPLAINTS : </th>
                  <td class="italic">{{ data.FacultyClearance.request }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('faculty clearance/edit', $currentUser)): ?>
                <a href="#/faculty/faculty-clearance/edit/{{ data.FacultyClearance.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('faculty clearance/print faculty clearance', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.FacultyClearance.id )"><i class="fa fa-print"></i> PRINT FACULTY CLEARANCE </button>
              <?php endif ?>
              <?php if (hasAccess('faculty clearance/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.FacultyClearance)"><i class="fa fa-trash"></i> DELETE </button>
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
