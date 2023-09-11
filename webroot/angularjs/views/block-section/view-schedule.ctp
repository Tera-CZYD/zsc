<?php if (hasAccess('block section/view schedules', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW BLOCK SECTION SCHEDULES INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right"> COURSE : </th>
                  <td class="italic">{{ data.BlockSectionCourse.course }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FACULTY : </th>
                  <td class="italic">{{ data.BlockSectionCourse.faculty_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ROOM : </th>
                  <td class="italic">{{ data.BlockSectionCourse.room }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SLOT : </th>
                  <td class="italic">{{ data.BlockSectionCourse.slot }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> SCHEDULES </h5>
          </div>
          <div class="col-md-12">
            <?php if (hasAccess('block section/add schedule', $currentUser)): ?>
              <button class="btn btn-min btn-primary" ng-click="addSchedule()"><i class="fa fa-plus"></i> ADD SCHEDULE</button>
            <?php endif ?> 
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover"> 
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> DAY </th>
                    <th class="text-center"> TIME START </th>
                    <th class="text-center"> TIME END </th>
                    <th class="w90px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.BlockSectionSchedule">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-center uppercase">{{ subs.day }}</td>
                    <td class="text-center uppercase">{{ subs.time_start }}</td>
                    <td class="text-center uppercase">{{ subs.time_end }}</td>
                    <td class="text-center">
                      <div class="btn-group btn-group-xs">
                        <?php if (hasAccess('block section/edit schedule', $currentUser)): ?>
                          <a href="javascript:void(0)" ng-click="editSchedule($index, subs)" class="btn btn-success" title="EDIT"><i class="fa fa-edit"></i></a>
                        <?php endif ?> 
                        <?php if (hasAccess('block section/delete schedule', $currentUser)): ?>
                          <a href="javascript:void(0)" ng-click="removeSchedule(subs)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                        <?php endif ?> 
                      </div>
                    </td> 
                  </tr>
                  <tr ng-if="data.BlockSectionSchedule == ''">
                    <td class="text-center" colspan="5">No data available.</td>
                  </tr>
                </tbody>
              </table>
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

<style type="text/css">
  .popover.clockpicker-popover{
    z-index:1151 !important;
  }
</style>

<div class="modal fade" id="add-schedule-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD SCHEDULE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="add_schedule">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DAY <i class="required">*</i></label>
              <select class="form-control" ng-model="adata.day" data-validation-engine="validate[required]">
                <option value=""></option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
              </select>
            </div>
          </div>  
          
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME START </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="adata.time_start" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME END </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="adata.time_end" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveSchedule(adata)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-schedule-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> EDIT SCHEDULE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_schedule">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DAY <i class="required">*</i></label>
              <select class="form-control" ng-model="adata.day" data-validation-engine="validate[required]">
                <option value=""></option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
              </select>
            </div>
          </div>  
          
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME START </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="adata.time_start" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME END </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="adata.time_end" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateSchedule(data)"><i class="fa fa-save"></i> UPDATE </button>
      </div>
    </div>
  </div>
</div>