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
  handleAccess('pageView', 'grades/view', currentUser);
  // handleAccess('pageEdit', 'grades/edit', currentUser);
  // handleAccess('pageDelete', 'grades/delete', currentUser);
  handleAccess('pageSubmission', 'grades/grade submission', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW FACULTY INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> FACULTY NO. : </th>
                  <td class="italic">{{ data.Employee.code }}</td>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.College.code }} - {{ data.College.name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> FAMILY NAME : </th>
                  <td class="italic">{{ data.Employee.family_name }}</td>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.Employee.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GIVEN NAME : </th>
                  <td class="italic">{{ data.Employee.given_name }}</td>
                  <th class="text-right"> ACADEMIC RANK : </th>
                  <td class="italic">{{ data.Employee.academic_rank }}</td>
                </tr>
                <tr>
                  <th class="text-right"> MIDDLE NAME : </th>
                  <td class="italic" colspan="3">{{ data.Employee.middle_name }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label> SELECT YEAR TERM </label>
              <select selectize ng-model="year_term_id" ng-options="opt.id as opt.value for opt in year_terms" ng-change = "getDatas()">
                <option value=""></option>
              </select>
            </div>
          </div> 

          <div class="col-md-2">
            <div class="form-group">
              <label> SELECT SECTION </label>
              <select selectize ng-model="section_id" ng-options="opt.id as opt.value for opt in sections" ng-change = "getDatas()">
                <option value=""></option>
              </select>
            </div>
          </div> 

          <div class="col-md-4">
            <div class="form-group">
              <label> SELECT PROGRAM </label>
              <select selectize ng-model="program_id" ng-options="opt.id as opt.value for opt in programs" ng-change = "getProgram(program_id);getDatas();">
                <option value=""></option>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label> SELECT COURSE </label>
              <select selectize ng-model="course_id" ng-options="opt.course_id as opt.value for opt in courses" ng-change = "getDatas()">
                <option value=""></option>
              </select>
            </div>
          </div> 

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-12" id="pageSubmission">
            <button class="btn btn-print btn-min" ng-click="print();" ng-disabled="bool"><i class="fa fa-print"></i> PRINT REPORT OF RATING </button>
            <button class="btn btn-warning btn-min" ng-click="submitMidterm();" ng-disabled="boolMidterm"><i class="fa fa-save"></i> SUBMIT MID TERM GRADE </button>
            <button class="btn btn-success btn-min" ng-click="submitFinalterm();" ng-disabled="boolFinalterm"><i class="fa fa-save"></i> SUBMIT FINAL TERM GRADE </button>
            <button class="btn btn-info btn-min" ng-if="button_status == 'edit'" ng-click="editIncomplete();" ng-disabled="boolIncomplete"><i class="fa fa-edit"></i> EDIT INCOMPLETE </button>
            <button class="btn btn-info btn-min" ng-if="button_status == 'save'" ng-click="submitFinalterm();"><i class="fa fa-save"></i> UPDATE INCOMPLETE </button>
          </div>


          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th class="text-center" style="width:3%">#</th>
                    <th class="text-center" style="width:10%">STUDENT NO.</th>
                    <th class="text-center" style="width:40%">STUDENT NAME</th>
                    <th class="text-center" style="width:10%">MID TERM GRADE</th>
                    <th class="text-center" style="width:10%">FINALTERM GRADE</th>
                    <th class="text-center">FINAL GRADE</th>
                    <th class="text-center" style="width:15%">REMARKS</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="sub in datas">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ sub.student_no }}</td>
                    <td class="text-left">{{ sub.student_name }}</td>
                    <td><input type="text" style="text-align: center" ng-model="sub.midterm_grade" ng-disabled="sub.midterm_submitted==1" class="form-control" ng-change="getFinalGrade($index)" data-validation-engine="validate[required]" autocomplete="off"></td>
                    <td>
                      <input type="text" style="text-align: center" ng-model="sub.finalterm_grade" ng-disabled="sub.midterm_submitted==0 || sub.finalterm_submitted==1 && !sub.incomplete_status" class="form-control" ng-change="getFinalGrade($index)" data-validation-engine="validate[required]" autocomplete="off">
                    </td>
                    <td class="text-center">{{ sub.final_grade }}</td>
                    <td class="text-center">{{ sub.remarks }}</td>
                    <td>
                    <div class="btn-group btn-group-xs">
                      <button class="btn btn-warning" ng-click="submitSingleMidterm(sub);" ng-disabled="sub.midterm_submitted == 1" title="SUBMIT MID TERM GRADE "><i class="fa fa-save"></i></button>
                      <button class="btn btn-success" ng-click="submitSingleFinalterm(sub);" ng-disabled="sub.midterm_submitted == 0 || sub.finalterm_submitted==1" title="SUBMIT FINAL TERM GRADE "><i class="fa fa-check"></i></button>
                      <button class="btn btn-info" ng-if="button_single_status == 'edit'" ng-click="editSingleIncomplete();" ng-disabled="sub.incomplete != 1" title="EDIT INCOMPLETE"><i class="fa fa-edit"></i></button>
                      <button class="btn btn-info" ng-if="button_single_status == 'save'" ng-disabled="sub.incomplete != 1" ng-click="submitSingleFinalterm(sub);" title="UPDATE INCOMPLETE"><i class="fa fa-save"></i></button>
                    </div>
                  </td> 
                  </tr>
                  <tr ng-show="datas == null || datas == ''">
                    <td class="text-center" colspan="9">No available data</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-right">
              <button id="pageSubmission" class="btn btn-primary btn-min" id = "save" ng-click="save();" ng-disabled="bool"><i class="fa fa-save"></i> SAVE GRADE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style> -->
