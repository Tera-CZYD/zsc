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
  handleAccess('pageIndex', 'student clearance/index', currentUser);
  // handleAccess('pageAdd', 'student clearance/add', currentUser);
  handleAccess('pagePrint', 'student clearance/print', currentUser);
  handleAccess('pageView', 'student clearance/view', currentUser);
  // handleAccess('pageEdit', 'student clearance/edit', currentUser);
  // handleAccess('pageDelete', 'student clearance/delete', currentUser);
  handleAccess('pageClear', 'student clearance/clear', currentUser);
  handleAccess('pageEmail', 'student clearance/email', currentUser);

</script>

<div class="row" id="pageIndex">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">STUDENT CLEARANCE</h4>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-4">
            <div class="form-group">
              <label> FILTER BY SUBJECT </label>
              <select class="form-control" ng-model="course_id" ng-options="opt.id as opt.value for opt in enrolled_course" ng-change = "getEnrolledCourse(course_id)">
                <option value=""></option>
              </select>
            </div>
          </div> 

          <div class="clearfix"></div><hr>
        <!-- nav tab start -->
          <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" data-target ="#pending" role="tab">PENDING</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#incomplete" role="tab">INCOMPLETE</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#cleared" role="tab">CLEARED</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">

              <div class="tab-pane fade show active" id="pending">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!--
                      <a id="pageAdd" href="#/faculty/student-clearance/faculty-add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
                       -->
                      <button id="pagePrint" ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i>PRINT</button>
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
                <div class="clearfix"></div>
                <hr>
                <div class="single-table mb-5">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thread>
                        <tr class="bg-info">
                          <th class="text-center w30px">#</th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> SUBJECT </th>
                          <th class="text-center"> REMARKS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.student_name }}</td>
                          <td class="text-center"> {{ data.course }}</td>
                          <td class="text-center">{{ data.remarks  != null ? data.remarks : 'N/A' }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a id="pageView" href="#/faculty/student-clearance/faculty-view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <a id="pageEmail" href="javascript:void(0)" ng-click="sendMail(data)" class="btn btn-info" title="SEND EMAIL"><i class="fa fa-envelope"></i></a>
                              <a id="pageClear" href="javascript:void(0)" ng-click="clearStudent(data)" class="btn btn-warning" title="CLEAR STUDENT"><i class="fa fa-check"></i></a>
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
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="pending({ page: 1 })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="pending({ page: paginator.page - 1 })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="pending({ page: page.number })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="pending({ page: paginator.page + 1 })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="pending({ page: paginator  })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorCleared.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorCleared.pageCount > 0 ? paginatorCleared.page : 0 }} out of {{ paginatorCleared.pageCount }}</sup>
                    </div>
                  </div>
                </div> 
              </div>

              <div class="tab-pane fade show" id="incomplete">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <!--
                      <a id="pageAdd" href="#/faculty/student-clearance/faculty-add" class="btn btn-primary  btn-min"><i class="fa fa-plus"></i> ADD</a>
                       -->
                      <button id="pagePrint" ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i>PRINT</button>
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
                <div class="clearfix"></div>
                <hr>
                <div class="single-table mb-5">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thread>
                        <tr class="bg-info">
                          <th class="text-center w30px">#</th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> SUBJECT </th>
                          <th class="text-center"> REMARKS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasIncomplete">
                          <td class="text-center">{{ (paginatorIncomplete.page - 1 ) * paginatorIncomplete.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.student_name }}</td>
                          <td class="text-center"> {{ data.course }}</td>
                          <td class="text-center">{{ data.remarks  != null ? data.remarks : 'N/A' }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a id="pageView" href="#/faculty/student-clearance/faculty-view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <a id="pageEmail" href="javascript:void(0)" ng-click="sendMail(data)" class="btn btn-info" title="SEND EMAIL"><i class="fa fa-envelope"></i></a>
                              <a id="pageClear" href="javascript:void(0)" ng-click="clearStudent(data)" class="btn btn-warning" title="CLEAR STUDENT"><i class="fa fa-check"></i></a>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasIncomplete == null || datasIncomplete == ''">
                          <td colspan="10">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="incomplete({ page: 1 })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorIncomplete.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="incomplete({ page: paginatorIncomplete.page - 1 })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesIncomplete" class="page-item {{ paginatorIncomplete.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="incomplete({ page: page.number })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorIncomplete.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="incomplete({ page: paginatorIncomplete.page + 1 })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="incomplete({ page: paginatorIncomplete  })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorIncomplete.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorIncomplete.pageCount > 0 ? paginatorIncomplete.page : 0 }} out of {{ paginatorIncomplete.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="cleared">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <button id="pagePrint" ng-click="print()" class="btn btn-print  btn-min"><i class="fa fa-print"></i>PRINT</button>
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
                <div class="clearfix"></div>
                <hr>
                <div class="single-table mb-5">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thread>
                        <tr class="bg-info">
                          <th class="text-center w30px">#</th>
                          <th class="text-center"> STUDENT NAME </th>
                          <th class="text-center"> SUBJECT </th>
                          <th class="text-center"> REMARKS </th>
                          <th class="w90px"></th>
                        </tr>
                      </thread>
                      <tbody>
                        <tr ng-repeat="data in datasCleared">
                          <td class="text-center">{{ (paginator.page - 1 ) * paginator.limit + $index + 1 }}</td>
                          <td class="text-left">{{ data.student_name }}</td>
                          <td class="text-center"> {{ data.course }}</td>
                          <td class="text-center">{{ data.remarks  != null ? data.remarks : 'N/A' }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <a id="pageView" href="#/faculty/student-clearance/faculty-view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datasCleared == null || datasCleared == ''">
                          <td colspan="10">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="cleared({ page: 1 })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginatorCleared.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="cleared({ page: paginatorCleared.page - 1 })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pagesCleared" class="page-item {{ paginatorCleared.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="cleared({ page: page.number })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginatorCleared.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="cleared({ page: paginatorCleared.page + 1 })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="cleared({ page: paginatorCleared  })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="paginatorCleared.pageCount > 0">
                      <sup class="text-primary">Page {{ paginatorCleared.pageCount > 0 ? paginatorCleared.page : 0 }} out of {{ paginatorCleared.pageCount }}</sup>
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
