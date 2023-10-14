<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">EDIT APARTELLE/DORMITORY APPLICATION</div>
        <div class="clearfix"></div><hr>
        <form id="form">
          <div class="row">

            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-center" colspan="2">STUDENT INFORMATION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-left" style="width: 15%"> STUDENT NUMBER </th>
                      <td class="text-left uppercase">{{ data.ApartelleStudentClearance.student_no }}</td>   
                    </tr>
                    <tr>
                      <th class="text-left"> STUDENT NAME </th>
                      <td class="text-left uppercase">{{ data.ApartelleStudentClearance.student_name }}</td>   
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-12">
              <div class="clearfix"></div><hr>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label> CONTROL NO. </label>
                <input disabled type="text" class="form-control" ng-model="data.ApartelleStudentClearance.code">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label> PROGRAM <i class="required">*</i></label>
                <select selectize ng-options="opt.id as opt.value for opt in college_program" ng-model="data.ApartelleStudentClearance.program_id" ng-change = "getProgram(data.ApartelleStudentClearance.program_id)" data-validation-engine="validate[required]">
                <option value=""></option></select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> YEAR TERM </label>
                <select selectize ng-model="data.ApartelleStudentClearance.year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getYear(data.ApartelleStudentClearance.year_term_id)">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label> SCHOOL YEAR <i class="required">*</i></label>
                <input type="text" class="form-control uppercase" autocomplete="off" ng-model="data.ApartelleStudentClearance.school_year" data-validation-engine="validate[required]">
              </div>
            </div>
          </div>
         </form>
        <div class="clearfix"></div><hr>
        <div class="row"> 
          <div class="col-md-12">
            <div class="pull-right">
              <button class="btn btn-primary btn-min" id = "update" ng-click="update();"><i class="fa fa-save"></i> UPDATE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  th {
    white-space: Nowrap;
  }
  td {
    white-space: Nowrap;
  }
</style>

