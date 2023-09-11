<?php if (hasaccess('backup manager/index', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">BACK-UP MANAGER </h4>
        <div class="clearfix"></div><hr>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
              <a class="btn btn-primary btn-min modal-form" href="javascript:void(0)" ng-click="export()"><i class="fa fa-download"></i> BACKUP NOW</a>
              <button type="button" class="btn btn-warning btn-min" ng-click="load()"><i class="fa fa-refresh"></i> RELOAD </button>
            </div>
            <div class="col-md-4 col-xs-12 pull-right">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
  	          	<input type="text" class="form-control search datepicker" placeholder="SEARCH HERE" ng-model="searchTxt" ng-change="search(searchTxt)">
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
  								<th class="w50px">#</th>
  								<th class="text-center">FILENAME</th>
  								<th class="text-center">USER</th>
  								<th class="text-center" style="width: 120px"></th>
  							</tr>
  						</thead>
  						<tbody>
  							<tr ng-repeat="data in datas">
  								<td class="text-center">{{  (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
  								<td class="text-left">
                    <a href="{{ data.src }}">{{ data.filename }}</a>
  								</td>
  								<td class="text-left">{{  data.full_name }}</td>
  								<td>
  									<div class="btn-group btn-group-xs">
  										<?php if (hasAccess('backups/delete', $currentUser)): ?>
  										<a href="javascript:void(0)" ng-click="remove(data,$index)" class="btn btn-danger no-border-radius" title="DELETE"><i class="fa fa-trash"></i></a>
  									  <?php endif ?>
  									</div>
  								</td>
  							</tr>
  	            <tr ng-if="datas==null || datas==''">
  	              <td colspan="4">No data available.</td>
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