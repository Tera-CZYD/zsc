<?php if (hasAccess('user management/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title"> USER MANAGEMENT </h4>
        <div class="row">
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <!-- nav tab start -->
          <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="cursor: pointer;">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" data-target ="#user" role="tab">USER</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#faculty" role="tab">FACULTY</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#student" role="tab">STUDENT</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#dean" role="tab">DEAN</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" data-target ="#vice" role="tab">VICE PRESIDENT</a>
              </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">

              <div class="tab-pane fade show active" id="user">
                <div class="clearfix"></div><hr>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                      <?php if (hasAccess('user management/add', $currentUser)): ?>
                        <a href="#/users/add" class="btn btn-primary btn-sm btn-min"><i class="fa fa-plus"></i> ADD NEW </a>
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
                      <thead>
                        <tr class="bg-info">
                          <th class="text-center w50px">#</th>
                          <th class="text-center">USERNAME</th>
                          <th class="text-center">NAME</th>
                          <th class="text-center">STATUS</th>
                          <th class="text-center">ROLE</th>
                          <th class="text-center" style="width: 120px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in datas">
                          <td class="text-center">{{ (paginator.page - 1) * paginator.limit +  $index + 1 }}</td>
                          <td>{{ data.username }}</td>
                          <td class="uppercase">{{ data.name }}</td>
                          <td>{{ data.active? 'ACTIVE':'NOT ACTIVE' }}</td>
                          <td class="uppercase">{{ data.role }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                            <?php if (hasAccess('user management/view', $currentUser)): ?>
                              <a href="#/users/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                            <?php endif ?> 
                            <?php if (hasAccess('user management/edit', $currentUser)): ?>
                              <a href="#/users/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                            <?php endif ?> 
                            <?php if (hasAccess('user management/delete', $currentUser)): ?>
                              <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>                           
                            <?php endif ?>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="datas == ''">
                          <td colspan="6" class="text-center">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="user({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="user({ page: paginator.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="user({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="user({ page: paginator.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="user({ page: paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
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
                <div class="row">
                  <div class="col-md-12">
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
                          <th class="text-center w50px">#</th>
                          <th class="text-center">USERNAME</th>
                          <th class="text-center">NAME</th>
                          <th class="text-center">STATUS</th>
                          <th class="text-center">ROLE</th>
                          <th class="text-center" style="width: 120px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in employee_data">
                          <td class="text-center">{{ (employee_paginator.page - 1) * employee_paginator.limit +  $index + 1 }}</td>
                          <td>{{ data.username }}</td>
                          <td class="uppercase">{{ data.name }}</td>
                          <td>{{ data.active? 'ACTIVE':'NOT ACTIVE' }}</td>
                          <td class="uppercase">{{ data.role }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <?php if (hasAccess('users/view', $currentUser)): ?>
                                <a href="#/users/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('users/edit', $currentUser)): ?>
                                <a href="#/users/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <?php endif ?> 
                              <?php if (hasAccess('users/delete', $currentUser)): ?> 
                                <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>                     
                              <?php endif ?>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="employee_data == ''">
                          <td colspan="6" class="text-center">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !employee_paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: employee_paginator.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in employee_pages" class="page-item {{ employee_paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="employee({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !employee_paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: employee_paginator.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: employee_paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="employee_paginator.pageCount > 0">
                      <sup class="text-primary">Page {{ employee_paginator.pageCount > 0 ? employee_paginator.page : 0 }} out of {{ employee_paginator.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="student">
                <div class="clearfix"></div><hr>
                <div class="row">
                  <div class="col-md-12">
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
                          <th class="text-center w50px">#</th>
                          <th class="text-center">USERNAME</th>
                          <th class="text-center">NAME</th>
                          <th class="text-center">STATUS</th>
                          <th class="text-center">ROLE</th>
                          <th class="text-center" style="width: 120px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in student_data">
                          <td class="text-center">{{ (student_paginator.page - 1) * student_paginator.limit +  $index + 1 }}</td>
                          <td>{{ data.username }}</td>
                          <td class="uppercase">{{ data.name }}</td>
                          <td>{{ data.active? 'ACTIVE':'NOT ACTIVE' }}</td>
                          <td class="uppercase">{{ data.role }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <?php if (hasAccess('users/view', $currentUser)): ?>
                                <a href="#/users/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('users/edit', $currentUser)): ?>
                                <a href="#/users/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <?php endif ?> 
                              <?php if (hasAccess('users/delete', $currentUser)): ?> 
                                <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>                     
                              <?php endif ?>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="student_data == ''">
                          <td colspan="6" class="text-center">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !student_paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in student_pages" class="page-item {{ student_paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="employee({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !student_paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="student_paginator.pageCount > 0">
                      <sup class="text-primary">Page {{ student_paginator.pageCount > 0 ? student_paginator.page : 0 }} out of {{ student_paginator.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="dean">
                <div class="clearfix"></div><hr>
                <div class="row">
                  <div class="col-md-12">
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
                          <th class="text-center w50px">#</th>
                          <th class="text-center">USERNAME</th>
                          <th class="text-center">NAME</th>
                          <th class="text-center">STATUS</th>
                          <th class="text-center">ROLE</th>
                          <th class="text-center" style="width: 120px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in dean_data">
                          <td class="text-center">{{ (dean_paginator.page - 1) * dean_paginator.limit +  $index + 1 }}</td>
                          <td>{{ data.username }}</td>
                          <td class="uppercase">{{ data.name }}</td>
                          <td>{{ data.active? 'ACTIVE':'NOT ACTIVE' }}</td>
                          <td class="uppercase">{{ data.role }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <?php if (hasAccess('users/view', $currentUser)): ?>
                                <a href="#/users/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('users/edit', $currentUser)): ?>
                                <a href="#/users/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <?php endif ?> 
                              <?php if (hasAccess('users/delete', $currentUser)): ?> 
                                <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>                     
                              <?php endif ?>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="dean_data == ''">
                          <td colspan="6" class="text-center">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !student_paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in student_pages" class="page-item {{ student_paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="employee({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !student_paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="student_paginator.pageCount > 0">
                      <sup class="text-primary">Page {{ student_paginator.pageCount > 0 ? student_paginator.page : 0 }} out of {{ student_paginator.pageCount }}</sup>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade show" id="vice">
                <div class="clearfix"></div><hr>
                <div class="row">
                  <div class="col-md-12">
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
                          <th class="text-center w50px">#</th>
                          <th class="text-center">USERNAME</th>
                          <th class="text-center">NAME</th>
                          <th class="text-center">STATUS</th>
                          <th class="text-center">ROLE</th>
                          <th class="text-center" style="width: 120px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="data in vice_data">
                          <td class="text-center">{{ (vice_paginator.page - 1) * vice_paginator.limit +  $index + 1 }}</td>
                          <td>{{ data.username }}</td>
                          <td class="uppercase">{{ data.name }}</td>
                          <td>{{ data.active? 'ACTIVE':'NOT ACTIVE' }}</td>
                          <td class="uppercase">{{ data.role }}</td>
                          <td>
                            <div class="btn-group btn-group-xs">
                              <?php if (hasAccess('users/view', $currentUser)): ?>
                                <a href="#/users/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a>
                              <?php endif ?> 
                              <?php if (hasAccess('users/edit', $currentUser)): ?>
                                <a href="#/users/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                              <?php endif ?> 
                              <?php if (hasAccess('users/delete', $currentUser)): ?> 
                                <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>                     
                              <?php endif ?>
                            </div>
                          </td>
                        </tr>
                        <tr ng-show="vice_data == ''">
                          <td colspan="6" class="text-center">No available data</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
                      </li>
                      <li class="page-item prevPage {{ !student_paginator.prevPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.page - 1, search: searchTxt })">&laquo;</a>
                      </li>
                      <li ng-repeat="page in student_pages" class="page-item {{ student_paginator.page == page.number ? 'active':''}}" >
                        <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="employee({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                      </li>
                      <li class="page-item nextPage {{ !student_paginator.nextPage? 'disabled':'' }}">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.page + 1, search: searchTxt })">&raquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" ng-click="employee({ page: student_paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="text-center" ng-show="student_paginator.pageCount > 0">
                      <sup class="text-primary">Page {{ student_paginator.pageCount > 0 ? student_paginator.page : 0 }} out of {{ student_paginator.pageCount }}</sup>
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
</div>
<?php endif ?>