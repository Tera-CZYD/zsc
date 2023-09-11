<?php if (hasAccess('nurse profile/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW NURSE PROFILE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right"> NAME : </th>
                  <td class="italic">{{ data.NurseProfile.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.NurseProfile.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AGE : </th>
                  <td class="italic">{{ data.NurseProfile.age }}</td>
                </tr>
                <tr>
                  <th class="text-right"> BIRTHDATE : </th>
                  <td class="italic">{{ data.NurseProfile.birthdate }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('nurse profile/edit', $currentUser)): ?>
                <a href="#/medical-services/nurse-profile/edit/{{ data.NurseProfile.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('nurse profile/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.NurseProfile)"><i class="fa fa-trash"></i> DELETE </button>
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
