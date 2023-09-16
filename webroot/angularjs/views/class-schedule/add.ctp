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
  handleAccess('pageAdd', 'class schedule/add', currentUser);

</script>

<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW CLASS SCHEDULE</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CODE <i class="required">*</i></label>
                <input type="text" class="form-control" disabled autocomplete="off" ng-model="data.ClassSchedule.code" data-validation-engine="validate[required]">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label> SEARCH FACULTY </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                <input type="text" class="form-control search uppercase" placeholder="TYPE EMPLOYEE HERE" ng-model="searchTxtFaculty" ng-enter="searchEmployee({ search: searchTxtFaculty })">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label> FACULTY </label>
                <label style="font-size:10px;color:gray;" class="pull-right"><input icheck type="checkbox" id="checkbox" class="form-control" autocomplete="false" ng-model="data.ClassSchedule.faculty_check">  No assigned faculty as for now </label>
                <table class="table table-bordered">
                  <tr>
                    <td style="{{ data.ClassSchedule.faculty_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.ClassSchedule.faculty_name }}</td>
                    <td style="{{ data.ClassSchedule.faculty_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.ClassSchedule.faculty_name == undefined">
                      <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.ClassSchedule.faculty_name = null; data.ClassSchedule.faculty_id = null;" ng-init="data.ClassSchedule.faculty_id = null"><i class="fa fa-times"></i></button>
                    </td>
                  </tr>  
                </table>  
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
            
            <div class="col-md-6" >
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.ClassSchedule.college_id" ng-options="opt.id as opt.value for opt in colleges" ng-change="getCollegeProgram(data.ClassSchedule.college_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
            
            <div class="col-md-6" >
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.ClassSchedule.program_id" ng-options="opt.id as opt.value for opt in programs" ng-change="getProgram(data.ClassSchedule.program_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SCHOOL YEAR START <i class="required">*</i></label>
                <input type="text" class="form-control yearpicker" autocomplete="off" ng-model="data.ClassSchedule.school_year_start" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> SCHOOL YEAR END <i class="required">*</i></label>
                <input type="text" class="form-control yearpicker" autocomplete="off" ng-model="data.ClassSchedule.school_year_end" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> YEAR TERM </label>
                <select selectize ng-model="data.ClassSchedule.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getDatas(data.ClassSchedule.year_term_id,data.ClassSchedule.school_year_start,data.ClassSchedule.school_year_end)">
                  <option value=""></option>
                </select>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <h5 class="table-top-title mb-2"> SCHEDULE </h5>
            </div>
            <div class="col-md-12" style="margin-bottom: 5px">
              <button class="btn btn-min btn-primary" ng-click="addSchedule()" ng-disabled="data.ClassSchedule.faculty_id == null"><i class="fa fa-plus"></i>&nbsp;ADD SCHEDULE</button>
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
                      <th style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="subs in data.ClassScheduleSub">
                      <td style="width: 15px;"> {{ $index + 1 }} </td>
                      <td class="text-left uppercase">{{ subs.course }}</td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.day }}</div>
                      </td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.building }}</div>
                      </td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.room }}</div>
                      </td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.time_start }}</div>
                      </td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.time_end }}</div>
                      </td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.section }}</div>
                      </td>
                      <td class="text-center">
                        <div ng-repeat="days in subs.ClassScheduleDay">{{ days.slot }}</div>
                      </td>
                      <td class="w90px text-center">
                        <div class="btn-group btn-group-xs"></div>
                        <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editSchedule($index, subs)"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeSchedule($index)"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <tr ng-if="data.ClassScheduleSub == ''">
                      <td class="text-center" colspan="9">No data available.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>  
        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add-schedule-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD SCHEDULE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="schedule_form">  
          <div class="col-md-12" >
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.course_id" ng-options="opt.id as opt.value for opt in courses" ng-change="getCourse(sub.course_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          
          <div class="col-md-12 mb-2">
            <button class="btn btn-min btn-primary" ng-click="addScheduleDay()"><i class="fa fa-plus"></i>&nbsp;ADD DAY</button>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;" rowspan="2">#</th>
                    <th class="text-center"> DAY </th>
                    <th class="text-center"> BUILDING </th>
                    <th class="text-center"> ROOM </th>
                    <th class="text-center"> TIME START </th>
                    <th class="text-center"> TIME END </th>
                    <th class="text-center"> SECTION </th>
                    <th class="text-center"> SLOT </th>
                    <th style="width: 100px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="days in data.ClassScheduleDay">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-center">{{ days.day }}</td>
                    <td class="text-center">{{ days.building }}</td>
                    <td class="text-left">{{ days.room }}</td>
                    <td class="text-center">{{ days.time_start }}</td>
                    <td class="text-center">{{ days.time_end }}</td>
                    <td class="text-center">{{ days.section }}</td>
                    <td class="text-center">{{ days.slot }}</td>
                    <td class="w90px text-center">
                      <div class="btn-group btn-group-xs"></div>
                      <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editScheduleDay($index, days)"><i class="fa fa-edit"></i></a>
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeScheduleDay($index)"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr ng-if="data.ClassScheduleDay == ''">
                    <td class="text-center" colspan="11">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveSchedule(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-schedule-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-edit"></i> EDIT SCHEDULE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_schedule_form"> 
          <div class="col-md-12" >
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.course_id" ng-options="opt.id as opt.value for opt in courses" ng-change="getCourse(sub.course_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          
          <div class="col-md-12 mb-2">
            <button class="btn btn-min btn-primary" ng-click="addScheduleDay()"><i class="fa fa-plus"></i>&nbsp;ADD DAY</button>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;" rowspan="2">#</th>
                    <th class="text-center"> DAY </th>
                    <th class="text-center"> BUILDING </th>
                    <th class="text-center"> ROOM </th>
                    <th class="text-center"> TIME START </th>
                    <th class="text-center"> TIME END </th>
                    <th class="text-center"> SECTION </th>
                    <th class="text-center"> SLOT </th>
                    <th style="width: 100px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="days in sub.ClassScheduleDay">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-center">{{ days.day }}</td>
                    <td class="text-center">{{ days.building }}</td>
                    <td class="text-center">{{ days.room }}</td>
                    <td class="text-center">{{ days.time_start }}</td>
                    <td class="text-center">{{ days.time_end }}</td>
                    <td class="text-center">{{ days.section }}</td>
                    <td class="text-center">{{ days.slot }}</td>
                    <td class="w90px text-center">
                      <div class="btn-group btn-group-xs"></div>
                      <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editScheduleDay($index, days)"><i class="fa fa-edit"></i></a>
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeScheduleDay($index)"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr ng-if="data.ClassScheduleDay == ''">
                    <td class="text-center" colspan="11">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateSchedule(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<!-- FOR SCHEDULE DAYS -->

<div class="modal fade" id="add-schedule-day-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD DAY </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="schedule_day_form">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DAY <i class="required">*</i> </label>
              <select class="form-control" ng-model="day.day" data-validation-engine="validate[required]">
                <option value=""></option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
              </select>
            </div>
          </div> 
          <div class="col-md-12" >
            <div class="form-group">
              <label> BUILDING <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="day.building_id" ng-options="opt.id as opt.value for opt in buildings" ng-change="getBuilding(day.building_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12" >
            <div class="form-group">
              <label> ROOM <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="day.room_id" ng-options="opt.id as opt.value for opt in rooms" ng-change="getRoom(day.room_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME START </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="day.time_start" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME END </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="day.time_end" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
          <div class="col-md-12" >
            <div class="form-group">
              <label> SECTION <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="day.section_id" ng-options="opt.id as opt.value for opt in sections" ng-change="getSection(day.section_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> SLOT <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="day.slot" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveScheduleDay(day)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-schedule-day-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> EDIT DAY </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_program_form">  
          <div class="col-md-12">
            <div class="form-group">
              <label> DAY <i class="required">*</i> </label>
              <select class="form-control" ng-model="day.day" data-validation-engine="validate[required]">
                <option value=""></option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
              </select>
            </div>
          </div> 
          <div class="col-md-12" >
            <div class="form-group">
              <label> BUILDING <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="day.building_id" ng-options="opt.id as opt.value for opt in rooms" ng-change="getBuilding(day.building_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12" >
            <div class="form-group">
              <label> ROOM <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="day.room_id" ng-options="opt.id as opt.value for opt in rooms" ng-change="getRoom(day.room_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME START </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="day.time_start" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
          <div class="col-md-12">  
            <div class="form-group">
              <label> TIME END </label><i class="required">*</i>
              <div class="input-group clockpicker">
                <input type="text" autocomplete = "off" class="form-control uppercase" ng-model="day.time_end" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
          <div class="col-md-12" >
            <div class="form-group">
              <label> SECTION <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="day.section_id" ng-options="opt.id as opt.value for opt in sections" ng-change="getSection(day.section_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label> SLOT <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="day.slot" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateScheduleDay(day)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>



<style type="text/css">
  .popover.clockpicker-popover{
    z-index:1151 !important;
  }
</style>
          
<div class="modal fade" id="searched-employee-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered vcenter table-striped table-condensed">
              <thead>
                <tr>
                  <th class="w30px">#</th>
                  <th class="text-center">EMPLOYEE NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="employee in employees">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ employee.code }}</td>
                  <td class="uppercase text-center">{{ employee.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="employee.selected = false" ng-model="employee.selected" name="iCheck" ng-selected="employee.selected = true" ng-change="selectedEmployee(employee)">
                  </td>
                </tr>
              </tbody>
              <tfoot ng-show="paginator.pageCount > 0">
                <tr>
                  <td colspan="4" class="text-center">
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center" ng-show="paginator.pageCount > 0">
                          <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>  
      </div> 

      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="employeeData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>

<script>
$('#form').validationEngine('attach');
</script>

<style>
  input[type="checkbox"] {
    float: right; 
  }
</style>