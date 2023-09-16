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
  handleAccess('pageView', 'block section/view', currentUser);
  handleAccess('pageEdit', 'block section/edit', currentUser);
  handleAccess('pageDelete', 'block section/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW BLOCK SECTION INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CODE : </th>
                  <td class="italic">{{ data.BlockSection.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COLLEGE : </th>
                  <td class="italic">{{ data.BlockSection.college }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PROGRAM : </th>
                  <td class="italic">{{ data.BlockSection.program }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR TERM : </th>
                  <td class="italic">{{ data.YearLevelTerm.description }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SCHOOL YEAR : </th>
                  <td class="italic">{{ data.BlockSection.school_year_start }} - {{ data.BlockSection.school_year_end }}</td>
                </tr>
                <tr>
                  <th class="text-right"> SECTION : </th>
                  <td class="italic">{{ data.BlockSection.section }}</td>
                </tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> COURSES </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover"> 
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> COURSE </th>
                    <th class="text-center"> FACULTY </th>
                    <th class="text-center"> ROOM </th>
                    <th class="text-center"> SLOT </th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.BlockSectionCourse">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.course }}</td>
                    <td class="text-left uppercase">{{ subs.faculty_name }}</td>
                    <td class="text-center uppercase">{{ subs.room }}</td>
                    <td class="text-center uppercase">{{ subs.slot }}</td>
                    <td class="text-center uppercase">
                      <button class="btn btn-primary btn-min" ng-click="addCourse()"><i class="fa fa-plus"></i> ADD FACULTY </button>
                    </td>
                  </tr>
                  <tr ng-if="data.BlockSectionCourse == ''">
                    <td class="text-center" colspan="6">No data available.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>

          <div class="col-md-12">
            <div class="pull-right">
                <a id="pageEdit" href="#/block-section/edit/{{ data.BlockSection.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.BlockSection)"><i class="fa fa-trash"></i> DELETE </button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add-faculty-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title uppercase"><i class="fa fa-plus"></i> ADD FACULTY </h5>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form id="faculty_form">
          <div class="col-md-12" >
            <div class="form-group">
              <label> FACULTY <i class="required">*</i></label>
              <select selectize style="height: 100px" ng-model="sub.faculty_id" ng-options="opt.id as opt.value for opt in faculties" ng-change="getFaculty(sub.faculty_id)" data-validation-engine="validate[required]">
                <option value=""></option>
              </select>

              <br><br><br><br><br><br><br><br><br>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE </button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="saveCourse(sub)"><i class="fa fa-save"></i> ADD </button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>
