<?php if (hasAccess('apartelle/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW APARTELLE INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.Apartelle.code }}</td>
                </tr>
                <tr>
                  <th class="text-right"> BUILDING NO. </th>
                  <td class="italic">{{ data.Apartelle.building_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ROOM NO. </th>
                  <td class="italic">{{ data.Apartelle.room_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PRICE : </th>
                  <td class="italic">{{ data.Apartelle.price | number : 2 }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CAPACITY : </th>
                  <td class="italic">{{ data.Apartelle.capacity }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DESCRIPTION : </th>
                  <td class="italic">{{ data.Apartelle.description }}</td>
                </tr>
                <tr>
              </table>
            </div> 
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <h5>Uploaded Images</h5>
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12 table-wrapper">
            <div class="col-md-4" ng-repeat="image in apartelleImage">
              <img src="{{ image.imageSrc }}" width="100%" style="border-radius : 2px; margin-bottom : 10px; z-index: : 1;"  ng-click="viewImage(image.imageSrc)">
            </div>
          </div>

          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('apartelle/edit', $currentUser)): ?>
                <a href="#/corporate-affairs/apartelle/edit/{{ data.Apartelle.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
              <?php endif ?>
              
              <?php if (hasAccess('apartelle/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.Apartelle)"><i class="fa fa-trash"></i> DELETE </button>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>

<div class="modal fade" id="view-image-modal">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <img src="{{ image }}" width="100%" height="100%" style="border-radius : 2px; margin-bottom : 10px">
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group btn-group-sm pull-right btn-min">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"> CANCEL</button>
        </div>
      </div>
    </div>
  </div>
</div>