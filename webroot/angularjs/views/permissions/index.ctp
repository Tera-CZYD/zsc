<?php if (hasAccess('permission management/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h5 class="header-title">PERMISSION MANAGEMENT</h5>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <?php if (hasAccess('permission management/add', $currentUser)): ?>
                <a href="#/permissions/add" class="btn btn-primary btn-min modal-form"><i class="fa fa-plus"></i> NEW PERMISSION </a>
              <?php endif ?> 
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control search" ng-enter="search(searchTxt)" placeholder="SEARCH HERE" ng-model="searchTxt">
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
                  <td class="w50px">#</td>
                  <th class="text-center">MODULE</th>
                  <th class="text-center">ACTION</th>
                  <th class="w90px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="permission in datas">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="text-center uppercase">{{ permission.module }}</td>
                  <td class="text-center uppercase">{{ permission.action }}</td>
                  <td class="text-center">
                    <div class="btn-group btn-group-xs">  
                      <?php if (hasAccess('permission management/edit', $currentUser)): ?>
                      <a href="#/permissions/edit/{{ permission.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                      <?php endif ?> 
                      <?php if (hasAccess('permission management/delete', $currentUser)): ?>
                      <a href="javascript:void(0)" class="btn btn-danger no-border-radius" ng-click="remove(permission)"><i class="fa fa-trash"></i></a>
                      <?php endif ?>
                    </div>
                  </td>
                </tr>
                <tr ng-if="datas == ''">
                  <td colspan="6" class="text-center">No data available</td>
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
<?php endif ?>