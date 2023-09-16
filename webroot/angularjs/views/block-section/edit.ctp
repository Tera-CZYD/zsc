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
  handleAccess('pageEdit', 'block section/edit', currentUser);

</script>

<div class="row" id="pageEdit">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT BLOCK SECTION </div>
        <div class="clearfix"></div><hr>
         <form id="form">
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label> CODE <i class="required">*</i></label>
                <input type="text" class="form-control" autocomplete="off" ng-model="data.BlockSection.code" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> YEAR TERM </label>
                <select selectize ng-model="data.BlockSection.year_term_id" ng-options="opt.id as opt.value for opt in year_terms">
                  <option value=""></option>
                </select>
              </div>
            </div> 

            <div class="col-md-3" >
              <div class="form-group">
                <label> SECTION <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.BlockSection.section_id" ng-options="opt.id as opt.value for opt in sections" ng-change="getSection(data.BlockSection.section_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6" >
              <div class="form-group">
                <label> COLLEGE <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.BlockSection.college_id" ng-options="opt.id as opt.value for opt in colleges" ng-change="getCollegeProgram(data.BlockSection.college_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6" >
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize style="height: 100px" ng-model="data.BlockSection.program_id" ng-options="opt.id as opt.value for opt in programs" ng-change="getProgram(data.BlockSection.program_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> SCHOOL YEAR START <i class="required">*</i></label>
                <input type="text" class="form-control yearpicker" autocomplete="off" ng-model="data.BlockSection.school_year_start" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> SCHOOL YEAR END <i class="required">*</i></label>
                <input type="text" class="form-control yearpicker" autocomplete="off" ng-model="data.BlockSection.school_year_end" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <h5 class="table-top-title mb-2"> COURSES </h5>
            </div>
            <div class="col-md-12" style="margin-bottom: 5px">
              <button class="btn btn-min btn-primary" ng-click="addCourse()" ng-disabled="data.BlockSection.college_id == null || data.BlockSection.program_id == null"><i class="fa fa-plus"></i>&nbsp;ADD COURSE</button>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th style="width: 15px;">#</th>
                      <th class="text-center"> COURSE </th>
                      <th class="text-center"> ROOM </th>
                      <th class="text-center"> SLOT </th>
                      <th style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="subs in data.BlockSectionCourse">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.course }}</td>
                    <td class="text-center uppercase">{{ subs.room }}</td>
                    <td class="text-center uppercase">{{ subs.slot }}</td>
                    <td class="w90px text-center">
                      <div class="btn-group btn-group-xs"></div>
                      <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editCourse($index, data.BlockSectionCourse)"><i class="fa fa-edit"></i></a>
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeCourse($index)"><i class="fa fa-trash"></i></a>
                    </td>
                    </tr>
                    <tr ng-if="data.BlockSectionCourse == ''">
                      <td class="text-center" colspan="6">No data available.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

           </div>
         </div>
       </form>
       <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "save" ng-click="save();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$('#form').validationEngine('attach');
</script>

<style type="text/css">
  .popover.clockpicker-popover{
    z-index:1151 !important;
  }
</style>

<div class="modal fade" id="add-course-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD SCHEDULE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="course_form">  
          <div class="col-md-12" >
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.course_id" ng-options="opt.course_id as opt.value for opt in courses" ng-change="getCourse(sub.course_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          
          <!-- <div class="col-md-12" >
            <div class="form-group">
              <label> FACULTY <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.faculty_id" ng-options="opt.id as opt.value for opt in faculties" ng-change="getFaculty(sub.faculty_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div> -->

          <div class="col-md-12">
            <div class="form-group">
              <label> ROOM </label>
              <select selectize ng-model="sub.room_id" ng-options="opt.id as opt.value for opt in rooms" ng-change = "getRoom(sub.room_id)">
                <option value=""></option>
              </select>
            </div>
          </div> 

          <div class="col-md-12">
            <div class="form-group">
              <label> SLOTS <i class="required">*</i></label>
              <input type="text" class="form-control" ng-model="sub.slot" data-validation-engine="validate[required]">
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveCourse(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-course-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-edit"></i> EDIT COURSE </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_course_form"> 
          <div class="col-md-12" >
            <div class="form-group">
              <label> COURSE <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.course_id" ng-options="opt.course_id as opt.value for opt in courses" ng-change="getCourse(sub.course_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div>
          
          <!-- <div class="col-md-12" >
            <div class="form-group">
              <label> FACULTY <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.faculty_id" ng-options="opt.id as opt.value for opt in faculties" ng-change="getFaculty(sub.faculty_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>
            </div>
          </div> -->

          <div class="col-md-12">
            <div class="form-group">
              <label> ROOM </label>
              <select selectize ng-model="sub.room_id" ng-options="opt.id as opt.value for opt in rooms" ng-change = "getRoom(sub.room_id)">
                <option value=""></option>
              </select>
            </div>
          </div> 

          <div class="col-md-12">
            <div class="form-group">
              <label> SLOTS <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="sub.slot" data-validation-engine="validate[required]">
            </div>
          </div>
       
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateCourse(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

          

