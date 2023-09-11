<?php if (hasAccess('report admission/scholarship evaluation', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">SCHOLARSHIP EVALUATIONS</h4>
        <div class="clearfix"></div><hr>
        <!-- nav tab start -->
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-8 col-xs-12" style="margin-bottom: 2px;padding-left: 0px">
                <a href="javascript:void(0)" class="btn btn-success  btn-min" ng-click="advance_search()"><i class="fa fa-search"></i> ADVANCE SEARCH</a>
                <?php if (hasAccess('report admission/scholarship evaluation', $currentUser)): ?>
                <button ng-click="printConfirmed()" class="btn btn-print  btn-min"><i class="fa fa-print"></i>PRINT</button>
                <?php endif ?>
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
                    <th class="text-center"> CONTROL NO. </th>
                    <th class="text-center"> STUDENT NAME </th>
                    <th class="text-center"> DATE APPLIED </th>
                    <th class="text-center"> PROGRAM </th>
                    <th class="text-center"> SCHOLARSHIP NAME </th>
                    <th class="text-center"> AGE </th>
                    <th class="text-center"> SEX </th>
                    <th class="text-center"> STATUS </th>
                  </tr>
                </thread>
                <tbody>
                  <tr ng-repeat="data in datasConfirmed">
                    <td class="text-center">{{ (paginatorConfirmed.page - 1 ) * paginatorConfirmed.limit + $index + 1 }}</td>
                    <td class="text-center">{{ data.code }}</td>
                    <td class="text-center">{{ data.student_name }}</td>
                    <td class="text-center">{{ data.date }}</td>
                    <td class="text-center">{{ data.program }}</td>
                    <td class="text-center">{{ data.scholarship_name }}</td>
                    <td class="text-center">{{ data.age }}</td>
                    <td class="text-center">{{ data.sex }}</td>
                    <td class="text-center">CONFIRMED</td>
                  </tr>
                  <tr ng-show="datasConfirmed == null || datasConfirmed == ''">
                    <td colspan="9">No available data</td>
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
                <li class="page-item prevPage {{ !paginatorConfirmed.prevPage? 'disabled':'' }}">
                  <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorConfirmed.page - 1, search: searchTxt })">&laquo;</a>
                </li>
                <li ng-repeat="page in pagesConfirmed" class="page-item {{ paginatorConfirmed.page == page.number ? 'active':''}}">
                  <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
                </li>
                <li class="page-item nextPage {{ !paginatorConfirmed.nextPage? 'disabled':'' }}">
                  <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorConfirmed.page + 1, search: searchTxt })">&raquo;</a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="javascript:void(0)" ng-click="load({ page: paginatorConfirmed.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub></a>
                </li>
              </ul>
              <div class="clearfix"></div>
              <div class="text-center" ng-show="paginatorConfirmed.pageCount > 0">
                <sup class="text-primary">Page {{ paginatorConfirmed.pageCount > 0 ? paginatorConfirmed.page : 0 }} out of {{ paginatorConfirmed.pageCount }}</sup>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<?php echo $this->element('modals/advance-search/advance-search-date') ?>