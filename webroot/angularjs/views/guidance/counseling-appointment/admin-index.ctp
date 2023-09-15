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
  handleAccess('pageIndex', 'counseling appointment/index', currentUser);
  handleAccess('pageAdd', 'counseling appointment/add', currentUser);
  handleAccess('pagePrint', 'counseling appointment/print', currentUser);
  handleAccess('pageView', 'counseling appointment/view', currentUser);
  handleAccess('pageEdit', 'counseling appointment/edit', currentUser);
  handleAccess('pageDelete', 'counseling appointment/delete', currentUser);

</script>


<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">COUNSELING APPOINTMENT MANAGEMENT</h4>
        <div class="clearfix"></div><hr>
        <!-- nav tab start -->
          <div class="col-lg-12">
            <div class="col-md-8 col-xs-12">
              <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" data-target ="#pending" role="tab">PENDING</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#approved" role="tab">APPROVED</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#confirmed" role="tab">CONFIRMED</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#disapproved" role="tab">DISAPPROVED</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" data-target ="#cancelled" role="tab">CANCELLED</a>
                </li>
              </ul>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">
                <span class="dropleft float-right input-group-text" style="padding : 0;">
                  <a class="fa fa-filter" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 15px;"></a>
                  <div class="dropdown-menu">
                    <div ng-show="!data.CourseActivity.disable_admin_quiz_button">
                      <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('date')">DATE</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('month')">MONTH</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-dark" href="javascript:void(0)" ng-click="changeFilter('customRange')">CUSTOM RANGE</a>
                    </div>
                  </div>
                </span>
                <input ng-show="selectedFilter == 'date'" type="text" class="form-control datepicker input-sm uppercase" ng-model="search.date" ng-change="searchFilter(search)" placeholder="FILTER BY DATE">
                <input ng-show="selectedFilter == 'month'" type="text" class="form-control monthpicker input-sm uppercase" ng-model="search.month" ng-change="searchFilter(search)" placeholder="FILTER BY MONTH">
                <div class="input-group input-daterange" style="margin-bottom: 0;" ng-show="selectedFilter == 'customRange'">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control input-sm uppercase" ng-model="search.startDate" ng-change="searchFilter(search)" placeholder="START DATE">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                  <input type="text" class="form-control input-sm uppercase" ng-model="search.endDate" ng-change="searchFilter(search)" placeholder="END DATE">
                </div>
              </div>
            </div>
            <div class="tab-content mt-3" id="myTabContent">

              <div class="tab-pane fade show active" id="pending">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      
                        <a id="pageAdd" href="#/guidance/admin-counseling-appointment/add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
                      
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      
                        <button id="pagePrint" ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      
                      <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> TYPE </th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> DATE </th>
                          <th class="text-center"> TIME </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.type }}</td>
                          <td class="text-center">{{ data.student_name }}</td>
                          <td class="text-center">{{ data.date }}</td>
                          <td class="text-center">{{ data.time }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 4" class="label label-success"> CONFIRMED </span>
                            <span ng-if="data.status == 3" class="label label-danger"> CANCELLED </span>
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              
                              <a id="pageView" href="#/guidance/admin-counseling-appointment/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              
                              
                              <a id="pageEdit" href="#/guidance/admin-counseling-appointment/edit/{{ data.id }}" class="btn btn-primary" ng-disabled = "data.status != 0" title="EDIT"><i class="fa fa-edit"></i></a> 
                              
                             
                              <a id="pageDelete" href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" ng-disabled = "data.status != 0" title="DELETE"><i class="fa fa-trash"></i></a>
                              
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

              <div class="tab-pane fade show" id="approved">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      
                        <button id="pagePrint" ng-click="printApproved()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      
                      <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> TYPE </th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> DATE </th>
                          <th class="text-center"> TIME </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasApproved">
                          <td class="text-center">{{ (paginatorApproved.page - 1 ) * paginatorApproved.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.type }}</td>
                          <td class="text-center">{{ data.student_name }}</td>
                          <td class="text-center">{{ data.date }}</td>
                          <td class="text-center">{{ data.time }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 4" class="label label-success"> CONFIRMED </span>
                            <span ng-if="data.status == 3" class="label label-danger"> CANCELLED </span>
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              
                              <a id="pageView" href="#/guidance/admin-counseling-appointment/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasApproved == null || datasApproved == ''">
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
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId})"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorApproved.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: paginatorApproved.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesApproved" class="page-item {{ paginatorApproved.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="approved({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorApproved.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: paginatorApproved.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="approved({ page: paginatorApproved.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorApproved.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorApproved.pageCount > 0 ? paginatorApproved.page : 0 }} out of {{ paginatorApproved.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="confirmed">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      
                        <button id="pagePrint" ng-click="printConfirmed()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      
                      <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> TYPE </th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> DATE </th>
                          <th class="text-center"> TIME </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasConfirmed">
                          <td class="text-center">{{ (paginatorConfirmed.page - 1 ) * paginatorConfirmed.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.type }}</td>
                          <td class="text-center">{{ data.student_name }}</td>
                          <td class="text-center">{{ data.date }}</td>
                          <td class="text-center">{{ data.time }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 4" class="label label-success"> CONFIRMED </span>
                            <span ng-if="data.status == 3" class="label label-danger"> CANCELLED </span>
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              
                              <a id="pageView" href="#/guidance/admin-counseling-appointment/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasConfirmed == null || datasConfirmed == ''">
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
                        <a class="page-link" href="javascript:void(0)" ng-click="confirmed({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId})"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorConfirmed.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="confirmed({ page: paginatorConfirmed.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesConfirmed" class="page-item {{ paginatorConfirmed.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="confirmed({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorConfirmed.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="confirmed({ page: paginatorConfirmed.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="confirmed({ page: paginatorConfirmed.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorConfirmed.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorConfirmed.pageCount > 0 ? paginatorConfirmed.page : 0 }} out of {{ paginatorConfirmed.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="disapproved">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      
                        <button id="pagePrint" ng-click="printDisapproved()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      
                      <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> TYPE </th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> DATE </th>
                          <th class="text-center"> TIME </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasDisapproved">
                          <td class="text-center">{{ (paginatorDisapproved.page - 1 ) * paginatorDisapproved.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.type }}</td>
                          <td class="text-center">{{ data.student_name }}</td>
                          <td class="text-center">{{ data.date }}</td>
                          <td class="text-center">{{ data.time }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 4" class="label label-success"> CONFIRMED </span>
                            <span ng-if="data.status == 3" class="label label-danger"> CANCELLED </span>
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              
                              <a id="pageView" href="#/guidance/admin-counseling-appointment/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasDisapproved == null || datasDisapproved == ''">
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
                        <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId})"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorDisapproved.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: paginatorDisapproved.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesDisapproved" class="page-item {{ paginatorDisapproved.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="disapproved({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorDisapproved.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: paginatorDisapproved.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="disapproved({ page: paginatorDisapproved.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorDisapproved.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorDisapproved.pageCount > 0 ? paginatorDisapproved.page : 0 }} out of {{ paginatorDisapproved.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="cancelled">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!-- <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a> -->
                      
                        <button id="pagePrint" ng-click="printCancelled()" class="btn btn-print  btn-min"><i class="fa fa-print"></i> PRINT</button>
                      
                      <button type="button" class="btn btn-warning  btn-min" ng-click="reload()"><i class="fa fa-refresh"></i> RELOAD </button>
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
                          <th class="text-center"> CONTROL NO. </th>
                          <th class="text-center"> TYPE </th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> DATE </th>
                          <th class="text-center"> TIME </th>
                          <th class="text-center"> STATUS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasCancelled">
                          <td class="text-center">{{ (paginatorCancelled.page - 1 ) * paginatorCancelled.limit + $index + 1 }}</td>
                          <td class="text-center">{{ data.code }}</td>
                          <td class="text-center">{{ data.type }}</td>
                          <td class="text-center">{{ data.student_name }}</td>
                          <td class="text-center">{{ data.date }}</td>
                          <td class="text-center">{{ data.time }}</td>
                          <td class="w90px text-center">
                            <span ng-if="data.status == 4" class="label label-success"> CONFIRMED </span>
                            <span ng-if="data.status == 3" class="label label-danger"> CANCELLED </span>
                            <span ng-if="data.status == 2" class="label label-danger"> DISAPPROVED </span>
                            <span ng-if="data.status == 1" class="label label-primary"> APPROVED </span>
                            <span ng-if="data.status == 0" class="label label-warning"> PENDING </span>
                          </td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              
                              <a id="pageView" href="#/guidance/admin-counseling-appointment/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                              
                            </div>
                          </td>
                        </tr>
                        <tr ng-if="datasCancelled == null || datasCancelled == ''">
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
                        <a class="page-link" href="javascript:void(0)" ng-click="cancelled({ page: 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId})"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorCancelled.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="cancelled({ page: paginatorCancelled.page - 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesCancelled" class="page-item {{ paginatorCancelled.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="cancelled({ page: page.number, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorCancelled.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="cancelled({ page: paginatorCancelled.page + 1, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="cancelled({ page: paginatorCancelled.pageCount, search: searchTxt,date:dateToday,startDate: startDate,endDate: endDate, office_id: office_id, position_id: position_id,employmentStatusId : employmentStatusId })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorCancelled.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorCancelled.pageCount > 0 ? paginatorCancelled.page : 0 }} out of {{ paginatorCancelled.pageCount }}</sup>
                    </div>
                  </div>
                </div>
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
              <select class="form-control input-sm" ng-model="search.filterBy">
                <option value="date">DATE</option>
                <option value="today">TODAY</option>
                <option value="month">MONTH</option>
                <option value="this-month">THIS MONTH</option>
                <option value="custom-range">CUSTOM RANGE</option>
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
