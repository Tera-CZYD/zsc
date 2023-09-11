<?php if (hasAccess('colleges/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW COLLEGE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> COLLEGE CODE : </th>
                  <td class="italic">{{ data.College.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE NAME : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ACRONYM : </th>
                  <td class="italic">{{ data.College.acronym }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR ESTABLISHED : </th>
                  <td class="italic">{{ data.College.year_established }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> PROGRAMS </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> PROGRAM </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.CollegeSub">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.program }}</td>
                  </tr>
                  <tr ng-if="data.CollegeSub == ''">
                    <td class="text-center" colspan="3">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('colleges/edit', $currentUser)): ?>
                <a href="#/college/edit/{{ data.College.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('colleges/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.College)"><i class="fa fa-trash"></i> DELETE </button>
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
