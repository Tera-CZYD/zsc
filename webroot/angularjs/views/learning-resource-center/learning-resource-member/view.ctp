<?php if (hasAccess('learning resource member/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW MEMBER INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> LIBRARY ID NUMBER : </th>
                  <td class="italic">{{ data.LearningResourceMember.library_id_number }}</td>
                </tr>

                <tr>
                  <th class="text-right" style="width:15%"> MEMBER NAME : </th>
                  <td class="italic">{{ data.LearningResourceMember.member_name }}</td>
                </tr>

                <tr>
                  <th class="text-right"> PATRON TYPE : </th>
                  <td class="italic">{{ data.LearningResourceMember.classification }}</td>
                </tr>

                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.LearningResourceMember.address }}</td>
                </tr>

                <tr ng-if="data.LearningResourceMember.classification == 'STUDENT'">
                  <th class="text-right"> YEAR LEVEL : </th>
                  <td class="italic">{{ data.LearningResourceMember.year_level }}</td>
                </tr>

                <tr ng-if="data.LearningResourceMember.classification == 'FACULTY'">
                  <th class="text-right"> FACULTY STATUS : </th>
                  <td class="italic">{{ data.LearningResourceMember.faculty_status }}</td>
                </tr>

                <tr ng-if="data.LearningResourceMember.classification == 'STUDENT' || data.LearningResourceMember.classification == 'FACULTY'">
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.LearningResourceMember.college.name }}</td>
                </tr>

                <tr ng-if="data.LearningResourceMember.classification == 'FACULTY'">
                  <th class="text-right"> OFFICE : </th>
                  <td class="italic">{{ data.LearningResourceMember.office }}</td>
                </tr>

                <tr>
                  <th class="text-right"> PROGRAM/DEPARTMENT : </th>
                  <td class="italic">{{ data.LearningResourceMember.college_program.name }}</td>
                </tr>

                <tr>
                  <th class="text-right"> MEMBERSHIP DATE : </th>
                  <td class="italic">{{ data.LearningResourceMember.date }}</td>
                </tr>

              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('learning resource member/edit', $currentUser)): ?>
                <a href="#/learning-resource-center/learning-resource-member/edit/{{ data.LearningResourceMember.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
              <?php if (hasAccess('learning resource member/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.LearningResourceMember)"><i class="fa fa-trash"></i> DELETE </button>
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
<script>
$('#form').validationEngine('attach');
</script>