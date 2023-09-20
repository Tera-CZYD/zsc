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
  handleAccess('pageIndex', 'class schedule/index', currentUser);
  handleAccess('pageAdd', 'class schedule/add', currentUser);
  handleAccess('pagePrint', 'class schedule/print', currentUser);
  handleAccess('pageView', 'class schedule/view', currentUser);
  handleAccess('pageEdit', 'class schedule/edit', currentUser);
  handleAccess('pageDelete', 'class schedule/delete', currentUser);

</script>

<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-8 col-xs-12">
              <h4 class="header-title">CLASS SCHEDULE MANAGEMENT</h4>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">

                <span class="dropleft float-right input-group-text" style="padding : 0;">
                  <a class="fa fa-filter" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 15px;"></a>
                  <div class="dropdown-menu">
                    <div ng-show="!data.CourseActivity.disable_admin_quiz_button">
                      <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('year')">YEAR</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('semester')">SEMESTER</a>
                    </div>
                  </div>
                </span>
                <input ng-show="selectedFilter == 'year'" type="text" class="form-control yearpicker input-sm uppercase" ng-model="search.year" ng-change="searchFilter(search)" placeholder="FILTER BY YEAR">
                <select class="form-control input-sm uppercase" ng-model="search.semester" ng-change="searchFilter(search)" data-validation-engine="validate[required]" ng-options="opt.id as opt.value for opt in year_level_term" placeholder="FILTER BY SEMESTER" ng-show="selectedFilter == 'semester'">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                <a id="pageAdd" href="#/class-schedule/add" class="btn btn-primary btn-sm btn-min"><i class="fa fa-plus"></i> ADD RECORD </a>
              <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                <a id="pagePrint" ng-click="print()" class="btn btn-danger btn-sm btn-min"><i class="fa fa-print"></i> PRINT </a>
              <button type="button" class="btn btn-warning btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search" ng-enter="searchy(searchTxt)" placeholder="SEARCH HERE" ng-model="searchTxt">
              </div>
              <sup style="font-color:gray">Press Enter to search</sup> 
            </div>
          </div>
        </div>
        <div class="clearfix"></div><hr>
        <div class="single-table mb-5">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th class="w10px" style="width: 50px">NO.</th>
                  <th>CODE</th>
                  <th>FACULTY</th>
                  <th>COLLEGE</th>
                  <th>PROGRAM</th>
                  <th>YEAR TERM</th>
                  <th>SCHOOL YEAR</th>
                  <th>STATUS</th>
                  <th class="w90px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="data in datas">
                  <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                  <td class="text-center">{{ data.code }}</td>
                  <td class="text-left uppercase">{{ data.faculty_name }}</td>
                  <td class="text-left">{{ data.college }}</td>
                  <td class="text-left">{{ data.program }}</td>
                  <td class="text-center">{{ data.year_term }}</td>
                  <td class="text-center">{{ data.school_year }}</td>
                  <td class="text-center" style="width: 250px">
                    <div ng-repeat="days in data.days">{{ days.slot }} remaining slots</div>
                  </td>
                  <td>
                    <div class="btn-group btn-group-xs">
                    	<a id="pageView" href="#/class-schedule/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                    	<a id="pageEdit" href="#/class-schedule/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a>
                      <a id="pageDelete" href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                    </div>
                  </td> 
                </tr>
                <tr ng-show="datas == null || datas == ''">
                  <td colspan="10">No available data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
              </li>
              <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt })">&laquo;</a>
              </li>
              <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
              </li>
              <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt })">&raquo;</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
              </li>
            </ul>
            <div class="clearfix"></div>
            <div class="text-center" ng-show="paginator.pageCount > 0">
              <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
            <label>FILTER BY</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-list-ul"></i></span>
              </div>
              <select ng-change="loadSelect()" class="form-control input-sm" ng-model="search.filterBy">
                <option value="faculty">FACULTY</option>
                <option value="college">COLLEGE</option>
                <option value="program">PROGRAM</option>
                <option value="year_term">YEAR TERM</option>
                <option value="school_year">SCHOOL YEAR</option>
              </select>
            </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'faculty'">
          <div class="col-md-12">
            <div class="form-group">
              <label>FACULTY</label>
                
                  <select selectize style="height: 100px" ng-model="search.faculty" ng-options="opt.id as opt.value for opt in faculties" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
             
          </div>
        </div>
      </div>
        <div ng-show="search.filterBy == 'college'">
          <div class="col-md-12">
            <div class="form-group">
              <label>COLLEGE</label>
                
                  <select selectize style="height: 100px" ng-model="search.college" ng-options="opt.id as opt.value for opt in colleges" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
             
          </div>
          </div>
        </div>
      
         <div ng-show="search.filterBy == 'program'">
          <div class="col-md-12">
            <div class="form-group">
              
              <label>PROGRAM</label>
                
                  <select selectize style="height: 100px" ng-model="search.program" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
             
          </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'year_term'">
          <div class="col-md-12">
            <div class="form-group">
              
              <label>YEAR TERM</label>
                
                  <select selectize style="height: 100px" ng-model="search.year_term" ng-options="opt.id as opt.value for opt in year_terms" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
             
          </div>
          </div>
        </div>

        <div ng-show="search.filterBy == 'school_year'">
          <div class="col-md-12">
            <div class="form-group">
              
              <label>SCHOOL YEAR</label>
                
                  <select selectize id="year" style="height: 100px"  ng-model="search.school_year" data-validation-engine="validate[required]">

                </select>
             
          </div>
          </div>
        </div>
        



      </div>
      <div class="modal-footer">
        <!-- <div class="btn-group btn-group-sm pull-right btn-min"> -->
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="searchFilter(search)"> SEARCH</button>
        <!-- </div>  -->
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div>

<script language="javascript" type="text/javascript"> 

var start = 2000;
var end = 2030;
var options = "";
for(var year = start ; year <=end; year++){
   

  options += "<option>" + year + "</option>";
}
document.getElementById("year").innerHTML = options;

</script>
