<?php if (hasAccess('calendar of activities/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW CALENDAR OF ACTIVITY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width: 20%"> CONTROL NO. : </th>
                  <td class="italic">{{ data.CalendarActivity.code }}</td>
                </tr>
                
                <tr>
                  <th class="text-right"> TITLE : </th>
                  <td class="uppercase italic">{{ data.CalendarActivity.title }}</td>
                </tr>
                <tr>
                  <th class="text-right"> START DATE : </th>
                  <td class="italic">{{ data.CalendarActivity.startDate }}</td>
                </tr>
                <tr>
                  <th class="text-right"> END DATE : </th>
                  <td class="italic">{{ data.CalendarActivity.endDate }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic">{{ data.CalendarActivity.remarks }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('calendar of activities/edit', $currentUser)): ?>
                <a href="#/guidance/calendar-activities/edit/{{ data.CalendarActivity.id }}" class="btn btn-primary  btn-min"><i class="fa fa-edit"></i> EDIT</a> 
              <?php endif ?>
              <?php if (hasAccess('calendar of activities/delete', $currentUser)): ?>
              <button type="button" class="btn btn-danger  btn-min" ng-click="remove(data.CalendarActivity)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>