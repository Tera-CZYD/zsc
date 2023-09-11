<?php if (hasAccess('school graduated/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW SCHOOL GRADUATED INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> SCHOOL NAME : </th>
                  <td class="italic">{{ data.School.school_name }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> SCHOOL ADDRESS : </th>
                  <td class="italic">{{ data.School.school_address }}</td>
                </tr>
                
              </table>
            </div> 

          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('school graduated/edit', $currentUser)): ?>
                <a href="#/admission/school/edit/{{ data.School.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              
              <?php if (hasAccess('school graduated/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.School)"><i class="fa fa-trash"></i> DELETE </button>
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
