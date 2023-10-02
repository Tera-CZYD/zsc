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
  handleAccess('pageView', 'colleges/view', currentUser);
  handleAccess('pageEdit', 'colleges/edit', currentUser);
  handleAccess('pageDelete', 'colleges/delete', currentUser);

</script>

<div class="row" id="pageView">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW CURRICULUM INFORMATION </div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> CODE : </th>
                  <td class="italic">{{ data.Curriculum.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.Curriculum.description }}</td>
                </tr>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
            <h5 class="table-top-title mb-2"> PROGRAMS </h5>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr class="bg-info">
                    <th style="width: 15px;">#</th>
                    <th class="text-center"> PROGRAM </th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="subs in data.Curriculum.CurriculumSubs">
                    <td style="width: 15px;"> {{ $index + 1 }} </td>
                    <td class="text-left uppercase">{{ subs.program }}</td>
                  </tr>
                  <tr ng-if="data.Curriculum.CurriculumSubs == '' || data.Curriculum.CurriculumSubs == null">
                    <td class="text-center" colspan="3">No data available.</td>
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
                <a id="pageEdit" href="#/curriculum/curriculums/edit/{{ data.Curriculum.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
                <button id="pageDelete" class="btn btn-danger btn-min" ng-click="remove(data.Curriculum)"><i class="fa fa-trash"></i> DELETE </button>
            </div>
          </div>
        </div>
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
