<?php if (hasAccess('awardee management/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW AWARDEE</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
              <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.AwardeeManagement.code }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.AwardeeManagement.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> AWARD NAME : </th>
                  <td class="italic">{{ data.AwardeeManagement.award_id }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SECTION : </th>
                  <td class="italic">{{ data.Section.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR : </th>
                  <td class="italic">{{ data.AwardeeManagement.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.CollegeProgram.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COURSE : </th>
                  <td class="italic">{{ data.Course.title }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.AwardeeManagement.date }}</td>
                </tr>

              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('awardee management/edit', $currentUser)): ?>
                <a href="#/settings/awardee-management/edit/{{ data.AwardeeManagement.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              <?php if (hasAccess('awardee management/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.AwardeeManagement)"><i class="fa fa-trash"></i> DELETE </button>
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
