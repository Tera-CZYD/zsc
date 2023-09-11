<?php if (hasAccess('organization information/index', $currentUser)): ?>
<div class="row">
	<div class="col-lg-12 mt-3">
	  <div class="card">
	    <div class="card-body">
	      <h4 class="header-title">ORGANIZATION INFORMATION</h4>
	      <div class="clearfix"></div><hr>
	      <div class="single-table mb-5">
	        <div class="table-responsive">
	          <table class="table table-bordered text-center">
	            <thead>
								<tr class="bg-info">
									<th style="width:180px">NAME</th>
									<th>VALUE</th>
									<th style="width:30px"></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="data in datas">
									<td class="text-left uppercase">{{ data.name }}</td>
									<td class="text-left uppercase">
										<span ng-hide="editmode">{{ data.value }}</span>
										<input type="text" class="form-control input-sm" ng-show="editmode" ng-model="data.value" />
									</td>
									<td>
										<div class="btn-group btn-group-xs">
											<span>
												<button type="submit" ng-hide="editmode" ng-click="editmode = true" class="btn btn-primary  btn-xs no-border-radius" title="EDIT VALUE"><i class="fa fa-pencil"></i></button>
											</span>
			                <span> 
			                	<button type="submit" ng-show="editmode" ng-click="editmode = false; updateValue(data)" title="SAVE VALUE" class="btn btn-success no-border-radius btn-xs"><i class="fa fa-check"></i></button>
			                </span>	
										</div>
									</td>
								</tr>
							</tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<?php endif ?>