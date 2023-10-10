<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW SCHOOL TRANSFER REQUEST</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right"> SERIAL NUMBER : </th>
                  <td class="italic">{{ data.Transferee.serial_number }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> FIRST NAME : </th>
                  <td class="italic">{{ data.Transferee.first_name }}</td>
                </tr>
                 <tr>
                  <th class="text-right" style="width:15%"> MIDDLE NAME : </th>
                  <td class="italic">{{ data.Transferee.middle_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> LAST NAME : </th>
                  <td class="italic">{{ data.Transferee.last_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> YEAR LEVEL : </th>
                  <td class="italic">{{ data.YearLevelTerm.year }}</td>
                </tr>
                <tr>
                  <th class="text-right"> EMAIL : </th>
                  <td class="italic">{{ data.Transferee.email }}</td>
                </tr>
                <tr>
                  <th class="text-right"> ADDRESS : </th>
                  <td class="italic">{{ data.Transferee.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO. : </th>
                  <td class="italic">{{ data.Transferee.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> GENDER : </th>
                  <td class="italic">{{ data.Transferee.gender }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.Transferee.date }}</td>
                </tr>
              </table>
            </div> 

            <div class="clearfix"></div><hr>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info">
                      <th class = "text-left" colspan="2">UPLOADED FILES</th>
                    </tr>
                    <tr>
                      <th class="w30px text-center">#</th>
                      <th class="text-center">FILE NAME</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="image in transfereeImage">
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="uppercase text-left">
                        <a href="{{ image.imageSrc }}">{{ image.name }}</a>
                      </td>
                    </tr>
                    <tr ng-if = "transfereeImage == ''">
                      <td class="text-center" colspan="2">No data available . . .</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
                <a href="#/registrar/transferee/edit/{{ data.Transferee.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>

                <button class="btn btn-danger btn-min" ng-click="remove(data.Transferee)"><i class="fa fa-trash"></i> DELETE </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  th {
    white-space: nowrap;
  }
  td {
    white-space: nowrap;
  }
</style>
