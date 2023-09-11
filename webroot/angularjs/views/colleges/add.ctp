<?php if (hasAccess('colleges/add', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">NEW COLLEGE</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label> CODE <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.College.code" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> NAME <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.College.name" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> ACRONYM <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.College.acronym" data-validation-engine="validate[required]">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label> YEAR ESTABLISHED </label>
                <input type="text" class="form-control yearpicker" ng-model="data.College.year_established">
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
              <h5 class="table-top-title mb-2"> PROGRAMS </h5>
            </div>
            <div class="col-md-12" style="margin-bottom: 5px">
              <button class="btn btn-min btn-primary" ng-click="addProgram()"><i class="fa fa-plus"></i>&nbsp;ADD PROGRAMS</button>
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
                    <tr ng-repeat="subs in data.CollegeSub">
                      <td style="width: 15px;"> {{ $index + 1 }} </td>
                      <td class="text-left uppercase">{{ subs.program }}</td>
                      <td class="w90px text-center">
                        <div class="btn-group btn-group-xs"></div>
                        <a href="javascript:void(0)" class="btn btn-xs btn-success" ng-click="editProgram($index, subs)"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" ng-click="removeProgram($index)"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <tr ng-if="data.CollegeSub == ''">
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

<div class="modal fade" id="add-program-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD PROGRAM </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="program_form">  
          <div class="col-md-12">
            <div class="form-group">
              <label> PROGRAM <i class="required">*</i> </label>
              <select selectize ng-model="sub.program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]" ng-change="getProgram(sub.program_id)">
                <option value=""></option>
              </select>
            </div>
          </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveProgram(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-program-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-edit"></i> EDIT PROGRAM </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="edit_program_form"> 
          <div class="col-md-12">
            <div class="form-group">
              <label> PROGRAM <i class="required">*</i> </label>
              <select selectize ng-model="sub.program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]" ng-change="getProgram(sub.program_id)">
                <option value=""></option>
              </select>
            </div>
          </div> 
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updateProgram(sub)"><i class="fa fa-save"></i> SAVE </button>
      </div>
    </div>
  </div>
</div>
          

