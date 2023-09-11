<?php if (hasAccess('program management/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW PROGRAM </div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label> CODE </label>
                <input type="text" class="form-control" ng-model="data.CollegeProgram.code"  autocomplete="off">
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <label> NAME </label>
                <input type="text" class="form-control" ng-model="data.CollegeProgram.name"  autocomplete="off">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> PROGRAM TERM </label>
                <select class="form-control" ng-model="data.CollegeProgram.program_term_id" ng-options="opt.id as opt.value for opt in program_terms" autocomplete="off">
                  <option value=""></option>
                </select>
              </div>
            </div> 
             <div class="col-md-3">
              <div class="form-group">
                <label> MAJOR </label>
                <select class="form-control" ng-model="data.CollegeProgram.major" ng-options="opt.value as opt.value for opt in majors" autocomplete="off">
                  <option value=""></option>
                </select>
              </div>
            </div> 

            <div class="col-md-3">
              <div class="form-group">
                <label> PROGRAM ID </label>
                <input type="text" class="form-control" ng-model="data.CollegeProgram.program_name" autocomplete="off">
              </div>
            </div>
            <!-- <div class="col-md-3">
              <div class="form-group">
                <label> ACRONYM </label>
                <input type="text" class="form-control" ng-model="data.CollegeProgram.acronym" data-validation-engine="validate[required]" autocomplete="off">
              </div>
            </div> -->

            <div class="col-md-3">
              <div class="form-group">
                <label> CAPACITY </label>
                <input type="text" class="form-control" ng-model="data.CollegeProgram.capacity" autocomplete="off">
              </div>
            </div>


            <div class="col-md-3">
              <div class="form-group">
                <label> NO. OF YEARS </label>
                <input type="number" class="form-control" ng-model="data.CollegeProgram.no_of_years" number autocomplete="off">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> TOTAL NO. OF TERMS </label>
                <input type="number" class="form-control" ng-model="data.CollegeProgram.no_of_terms" number autocomplete="off">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label> PASSING RATE </label>
                <input type="number" class="form-control" ng-model="data.CollegeProgram.passing_rate" number autocomplete="off">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <h5 class="table-top-title mb-2"> REQUIREMENTS </h5>
            </div>
            <div class="col-md-12" style="margin-bottom: 5px">
              <button class="btn btn-min btn-primary" ng-click="addRequirement()"><i class="fa fa-plus"></i>&nbsp;ADD REQUIREMENTS</button>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th style="width: 15px;">#</th>
                      <th class="text-center"> REQUIREMENT </th>
                      <th style="width: 100px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="subs in data.CollegeProgramSub">
                      <td style="width: 15px;"> {{ $index + 1 }} </td>
                      <td class="text-left uppercase">{{ subs.requirement }}</td>
                      <td class="w90px text-center">
                        <div class="btn-group btn-group-xs"></div>
                        <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editRequirement($index, subs)"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeRequirement($index)"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <tr ng-if="data.CollegeProgramSub == ''">
                      <td class="text-center" colspan="3">No data available.</td>
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
<?php endif ?>
<script>
$('#form').validationEngine('attach');
</script>

<div class="modal fade" id="add-requirement-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD REQUIREMENT </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="requirement_form">  
          <div class="col-md-12">
            <div class="form-group">
              <label> REQUIREMENT <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="sub.requirement" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveRequirement(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-requirement-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-edit"></i> EDIT REQUIREMENT </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_requirement_form"> 
          <div class="col-md-12">
            <div class="form-group">
              <label> REQUIREMENT <i class="required">*</i></label>
              <input type="text" class="form-control" autocomplete="off" ng-model="sub.requirement" data-validation-engine="validate[required]">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateRequirement(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>

