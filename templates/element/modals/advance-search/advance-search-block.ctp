<div class="modal fade" id="advance-search-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>ACADEMIC TERM</label>
            <select class="form-control" ng-model="search.term_id" ng-options="opt.id as opt.value for opt in academic_terms" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>COLLEGE</label>
            <select class="form-control" ng-model="search.college_id" ng-options="opt.id as opt.value for opt in colleges" ng-change = "getDepartment(search.college_id)" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>DEPARTMENT</label>
            <select class="form-control" ng-model="search.department_id" ng-options="opt.id as opt.value for opt in college_departments" ng-change = "getProgram(search.department_id)" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>PROGRAMS</label>
            <select class="form-control" ng-model="search.program_id" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
              <option value=""></option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="searchFilter(search)"> SEARCH</button>
        </div> 
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div>