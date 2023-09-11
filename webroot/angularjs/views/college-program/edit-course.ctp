<?php if (hasAccess('program management/add course', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">PRORGAM - EDIT COURSE</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> PRORGAM <i class="required">*</i></label>
                <input type="text" class="form-control" disabled="" ng-model="data.CollegeProgram.name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> COURSE <i class="required">*</i></label>
                <select selectize ng-model="data.CollegeProgramCourse.course_id" ng-options="opt.id as opt.value for opt in courses" ng-change="getCourse(data.CollegeProgramCourse.course_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="form-group">
                <label> YEAR AND TERM <i class="required">*</i></label>
                <select class="form-control" ng-model="data.CollegeProgramCourse.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getPrerequisites(data.CollegeProgramCourse.year_term_id)" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>
           
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <button type="button" class="btn btn-min btn-sm btn-primary" ng-click="addPrerequisite()"><i class="fa fa-plus"></i>&nbsp;ADD PREREQUISITES</button>
                  <div class="single-table">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr class="bg-info">
                            <th style="width: 15px;">#</th>
                            <th class="text-center"> COURSE </th>
                          <th style="width: 50px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="sub in data.CollegeProgramPrerequisite">
                            <td style="width: 15px;"> {{ $index + 1 }} </td>
                            <td class="text-left">
                              <select selectize ng-model="sub.course_id" ng-options="opt.id as opt.value for opt in prerequisites" ng-change="getPrerequisiteCourse(sub.course_id)">
                                <option value=""></option>
                              </select>
                            </td>
                            <td class="w90px text-center">
                              <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removePrerequisite($index)"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <tr ng-if="data.CollegeProgramPrerequisite == ''">
                            <td class="text-center" colspan="3">No data available.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div> 
                  </div>  
                </div>
                <div class="col-md-6">
                  <button type="button" class="btn btn-min btn-sm btn-primary" ng-click="addCorequisite()"><i class="fa fa-plus"></i>&nbsp;ADD COREQUISITE</button>
                  <div class="single-table">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr class="bg-info">
                            <th style="width: 15px;">#</th>
                            <th class="text-center"> COURSE </th>
                          <th style="width: 50px"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="sub in data.CollegeProgramCorequisite">
                            <td style="width: 15px;"> {{ $index + 1 }} </td>
                            <td class="text-left">
                              <select selectize ng-model="sub.course_id" ng-options="opt.id as opt.value for opt in corerequisites" ng-change="getCorequisiteCourse(sub.course_id)">
                                <option value=""></option>
                              </select>
                            </td>
                            <td class="w90px text-center">
                              <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeCorequisite($index)"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <tr ng-if="data.CollegeProgramCorequisite == ''">
                            <td class="text-center" colspan="3">No data available.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div> 
                  </div>  
                </div>
              </div>
            </div>
          </div>

        </form>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-danger btn-min btn-sm" ng-click="cancel();"><i class="fa fa-warning"></i> CANCEL </button>
              <button class="btn btn-primary btn-min btn-sm" id = "save" ng-click="save();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>


          

