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
  handleAccess('pageView', 'class schedule/view', currentUser);
  handleAccess('pageEdit', 'class schedule/edit', currentUser);
  handleAccess('pageDelete', 'class schedule/delete', currentUser);

</script>

<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW CLASS SCHEDULE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CODE : </th>
                  <td class="italic">{{ data.ClassSchedule.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FACULTY NAME : </th>
                  <td class="italic">{{ data.ClassSchedule.faculty_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.ClassSchedule.program }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR TERM : </th>
                  <td class="italic">{{ data.YearLevelTerm.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SCHOOL YEAR : </th>
                  <td class="italic">{{ data.ClassSchedule.school_year_start }} - {{ data.ClassSchedule.school_year_end }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> CALENDAR SCHEDULE </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover"> 
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                    <th class="text-center"> DAY </th>
                    <th class="text-center"> BUILDING </th>
                    <th class="text-center"> ROOM </th>
                    <th class="text-center"> TIME START </th>
                    <th class="text-center"> TIME END </th>
                    <th class="text-center"> SECTION </th>
                    <th class="text-center"> SLOT </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.ClassScheduleSub">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.course }}</td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.day }}</div>
                    </td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.building }}</div>
                    </td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.room }}</div>
                    </td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.time_start }}</div>
                    </td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.time_end }}</div>
                    </td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.section }}</div>
                    </td>
                    <td class="text-center">
                      <div ng-repeat="days in data.ClassScheduleDay">{{ days.slot }}</div>
                    </td>
                  </tr>
                  <tr ng-if="data.ClassScheduleSub == ''">
                    <td class="text-center" colspan="9">No data available.</td>
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
                <a id="pageEdit" href="#/class-schedule/edit/{{ data.ClassSchedule.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.ClassSchedule)"><i class="fa fa-trash"></i> DELETE </button>
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
