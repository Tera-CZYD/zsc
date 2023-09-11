<?php if (hasAccess('learning resource member/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">MEMBERS</h4>
        <div class="clearfix"></div><hr>
        <!-- nav tab start -->
        <div class="col-lg-12">
          <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" data-target ="#student" role="tab">STUDENT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" data-target ="#faculty" role="tab">FACULTY</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" data-target ="#admin" role="tab">ADMIN STAFF</a>
            </li>
          </ul>
          <div class="tab-content mt-3" id="myTabContent">

          <div class="tab-pane fade show active" id="student">
            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                  <?php if (hasAccess('learning resource member/add', $currentUser)): ?>
                    <a href="#/learning-resource-center/learning-resource-member/add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
                  <?php endif ?>
                  <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
                  <?php if (hasAccess('learning resource member/print', $currentUser)): ?>
                    <button ng-click="print()" class="btn btn-danger  btn-min"><i class="fa fa-print"></i> PRINT</button>
                  <?php endif ?>
                  <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
                  <?php if (hasAccess('learning resource member/export', $currentUser)): ?>
                  <!-- <button type="button" class="btn btn-primary  btn-min" ng-click="export()"><i class="fa fa-refresh"></i> EXPORT </button> -->
                  <?php endif ?>
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
                  <thread>
                    <tr class="bg-info">
                      <th class="text-center w30px">#</th>
                      <th class="text-center"> LIBRARY ID NUMBER </th>
                      <th class="text-center"> MEMBER NAME </th>
                      <th class="text-center"> YEAR LEVEL </th>
                      <th class="text-center"> PROGRAM </th>
                      <th class="text-center"> DATE </th>
                      <th class="w90px"></th>
                    </tr>
                  </thread>
                  <tbody>
                    <tr ng-repeat="data in datas">
                      <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                      <td class="text-center">{{ data.library_id_number }}</td>
                      <td class="text-center">{{ data.member_name }}</td>
                      <td class="text-center">{{ data.year_level }}</td>
                      <td class="text-center">{{ data.program }}</td>
                      <td class="text-center">{{ data.date }}</td>
                      <td>
                        <div class="btn-group btn-group-xs">
                          <?php if (hasAccess('learning resource member/view', $currentUser)): ?>
                          <a href="#/learning-resource-center/learning-resource-member/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                          <?php endif ?>
                          <?php if (hasAccess('learning resource member/edit', $currentUser)): ?>
                          <a href="#/learning-resource-center/learning-resource-member/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                          <?php endif ?>
                          <?php if (hasAccess('learning resource member/delete', $currentUser)): ?>
                          <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                          <?php endif ?>
                        </div>
                      </td>
                    </tr>
                    <tr ng-show="datas == null || datas == ''">
                      <td colspan="12">No available data</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
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

          <div class="tab-pane fade show" id="faculty">
            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                  <?php if (hasAccess('learning resource member/add', $currentUser)): ?>
                    <a href="#/learning-resource-center/learning-resource-member/add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
                  <?php endif ?>
                  <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
                  <?php if (hasAccess('learning resource member/print', $currentUser)): ?>
                    <button ng-click="printFaculty()" class="btn btn-danger  btn-min"><i class="fa fa-print"></i> PRINT</button>
                  <?php endif ?>
                  <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
                  <?php if (hasAccess('learning resource member/export', $currentUser)): ?>
                  <!-- <button type="button" class="btn btn-primary  btn-min" ng-click="exportFaculty()"><i class="fa fa-refresh"></i> EXPORT </button> -->
                  <?php endif ?>
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
                  <thread>
                    <tr class="bg-info">
                      <th class="text-center w30px">#</th>
                      <th class="text-center"> LIBRARY ID NUMBER </th>
                      <th class="text-center"> MEMBER NAME </th>
                      <th class="text-center"> FACULTY STATUS </th>
                      <th class="text-center"> OFFICE </th>
                      <th class="text-center"> DATE </th>
                      <th class="w90px"></th>
                    </tr>
                  </thread>
                  <tbody>
                    <tr ng-repeat="data in datasFaculty">
                      <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                      <td class="text-center">{{ data.library_id_number }}</td>
                      <td class="text-center">{{ data.member_name }}</td>
                      <td class="text-center">{{ data.faculty_status }}</td>
                      <td class="text-center">{{ data.office }}</td>
                      <td class="text-center">{{ data.date }}</td>
                      <td>
                        <div class="btn-group btn-group-xs">
                          <?php if (hasAccess('learning resource member/view', $currentUser)): ?>
                          <a href="#/learning-resource-center/learning-resource-member/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                          <?php endif ?>
                          <?php if (hasAccess('learning resource member/edit', $currentUser)): ?>
                          <a href="#/learning-resource-center/learning-resource-member/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                          <?php endif ?>
                          <?php if (hasAccess('learning resource member/delete', $currentUser)): ?>
                          <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                          <?php endif ?>
                        </div>
                      </td>
                    </tr>
                    <tr ng-show="datasFaculty == null || datasFaculty == ''">
                      <td colspan="12">No available data</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <ul class="pagination justify-content-center">
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" ng-click="faculty({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId})"><sub>&laquo;&laquo;</sub></a>
                  </li>
                  <li class="page-item prevPage {{ !paginatorFaculty.prevPage? 'disabled':'' }}">
                    <a class="page-link" href="javascript:void(0)" ng-click="faculty({ page: paginatorFaculty.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                  </li>
                  <li ng-repeat="page in pagesFaculty" class="page-item {{ paginatorFaculty.page == page.number ? 'active':''}}" >
                    <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="faculty({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                  </li>
                  <li class="page-item nextPage {{ !paginatorFaculty.nextPage? 'disabled':'' }}">
                    <a class="page-link" href="javascript:void(0)" ng-click="faculty({ page: paginatorFaculty.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" ng-click="faculty({ page: paginatorFaculty.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                  </li>
                </ul>
                <div class="clearfix"></div>
                <div class="text-center" ng-show="paginatorFaculty.pageCount > 0">
                  <sup class="text-primary">Page {{ paginatorFaculty.pageCount > 0 ? paginatorFaculty.page : 0 }} out of {{ paginatorFaculty.pageCount }}</sup>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade show" id="admin">
            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                  <?php if (hasAccess('learning resource member/add', $currentUser)): ?>
                    <a href="#/learning-resource-center/learning-resource-member/add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
                  <?php endif ?>
                  <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
                  <?php if (hasAccess('learning resource member/print', $currentUser)): ?>
                    <button ng-click="printAdmin()" class="btn btn-danger  btn-min"><i class="fa fa-print"></i> PRINT</button>
                  <?php endif ?>
                  <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
                  <?php if (hasAccess('learning resource member/export', $currentUser)): ?>
                  <!-- <button type="button" class="btn btn-primary  btn-min" ng-click="exportAdmin()"><i class="fa fa-refresh"></i> EXPORT </button> -->
                  <?php endif ?>
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
                  <thread>
                    <tr class="bg-info">
                      <th class="text-center w30px">#</th>
                      <th class="text-center"> LIBRARY ID NUMBER </th>
                      <th class="text-center"> MEMBER NAME </th>
                      <th class="text-center"> PROGRAM </th>
                      <th class="text-center"> DATE </th>
                      <th class="w90px"></th>
                    </tr>
                  </thread>
                  <tbody>
                    <tr ng-repeat="data in datasAdmin">
                      <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                      <td class="text-center">{{ data.library_id_number }}</td>
                      <td class="text-center">{{ data.member_name }}</td>
                      <td class="text-center">{{ data.program }}</td>
                      <td class="text-center">{{ data.date }}</td>
                      <td>
                        <div class="btn-group btn-group-xs">
                          <?php if (hasAccess('learning resource member/view', $currentUser)): ?>
                          <a href="#/learning-resource-center/learning-resource-member/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                          <?php endif ?>
                          <?php if (hasAccess('learning resource member/edit', $currentUser)): ?>
                          <a href="#/learning-resource-center/learning-resource-member/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                          <?php endif ?>
                          <?php if (hasAccess('learning resource member/delete', $currentUser)): ?>
                          <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                          <?php endif ?>
                        </div>
                      </td>
                    </tr>
                    <tr ng-show="datasAdmin == null || datasAdmin == ''">
                      <td colspan="12">No available data</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <ul class="pagination justify-content-center">
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" ng-click="admin({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId})"><sub>&laquo;&laquo;</sub></a>
                  </li>
                  <li class="page-item prevPage {{ !paginatorAdmin.prevPage? 'disabled':'' }}">
                    <a class="page-link" href="javascript:void(0)" ng-click="admin({ page: paginatorAdmin.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                  </li>
                  <li ng-repeat="page in pagesFaculty" class="page-item {{ paginatorAdmin.page == page.number ? 'active':''}}" >
                    <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="admin({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                  </li>
                  <li class="page-item nextPage {{ !paginatorAdmin.nextPage? 'disabled':'' }}">
                    <a class="page-link" href="javascript:void(0)" ng-click="admin({ page: paginatorAdmin.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" ng-click="admin({ page: paginatorAdmin.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                  </li>
                </ul>
                <div class="clearfix"></div>
                <div class="text-center" ng-show="paginatorAdmin.pageCount > 0">
                  <sup class="text-primary">Page {{ paginatorAdmin.pageCount > 0 ? paginatorAdmin.page : 0 }} out of {{ paginatorAdmin.pageCount }}</sup>
                </div>
              </div>
            </div>

          </div>
        </div>  
      </div>
    </div>
  </div>
</div>
<?php endif ?>

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
              <select class="form-control input-sm" ng-model="search.filterBy">
                

                <option value="college">COLLEGE</option>
                <option value="program">PROGRAM/DEPARTMENT</option>
                <option value="faculty_status">FACULTY STATUS</option>

                <option value="date">DATE</option>
                <option value="today">TODAY</option>
                <option value="month">MONTH</option>
                <option value="this-month">THIS MONTH</option>
                <option value="custom-range">CUSTOM RANGE</option>
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
              <label>PROGRAM/DEPARTMENT</label>
                <select selectize ng-model="search.program" ng-options="opt.id as opt.value for opt in programs" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
          </div>

          <div ng-show="search.filterBy == 'faculty_status'">
          <div class="col-md-12">
            <div class="form-group">
              <label>FACULTY STATUS</label>
                <select class="form-control" ng-model="search.faculty_status" autocomplete="false" data-validation-engine="validate[required]" style="height: 44px">
                  <option value=""></option>
                  <option value="PERMANENT">PERMANENT</option>
                  <option value="VISITING LECTURE">VISITING LECTURE</option>
                  <option value="CASUAL">CASUAL</option>
                  <option value="JOB ORDER">JOB ORDER</option>
                </select>
              </div>
            </div>
          </div>



        <div ng-show="search.filterBy == 'custom-range'">
          <div class="col-md-12">
            <div class="input-group input-daterange mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.startDate">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="text" class="form-control input-sm uppercase" ng-model="search.endDate">
            </div>
          </div>  
        </div>  
        <div ng-show="search.filterBy == 'month'">
          <div class="col-md-12">
            <div class="form-group">
              <label>MONTH</label>
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control monthpicker input-sm uppercase" ng-model="search.month">
              </div>
            </div>
          </div>
        </div>
        <div ng-show="search.filterBy == 'date'">
          <div class="col-md-12">
            <div class="form-group">
              <label>DATE</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" class="form-control datepicker input-sm uppercase" ng-model="search.date">
              </div>
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