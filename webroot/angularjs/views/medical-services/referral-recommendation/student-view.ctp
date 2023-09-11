<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW REFERRAL RECOMMENDATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">

                <tr>
                  <th class="text-right" style="width:15%"> CONTROL NUMBER : </th>
                  <td class="italic">{{ data.ReferralRecommendation.code }}</td>
                </tr>
                <tr>
                  <th class="text-right" style="width:15%"> PATIENT NAME : </th>
                  <td class="italic">{{ data.ReferralRecommendation.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.ReferralRecommendation.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COMPLAINTS : </th>
                  <td class="italic">{{ data.ReferralRecommendation.complaints }}</td>
                </tr> 
                <tr>
                  <th class="text-right"> RECOMMENDATIONS : </th>
                  <td class="italic">{{ data.ReferralRecommendation.recommendations }}</td>
                </tr>
              </table>
            </div> 
          </div>
          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">

            

 


              <a href="#/medical-services/referral-recommendation/student-edit/{{ data.ReferralRecommendation.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
        
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.ReferralRecommendation.id )"><i class="fa fa-print"></i> PRINT REFERRAL RECOMMENDATION </button>

              <button class="btn btn-danger btn-min" ng-click="remove(data.ReferralRecommendation)"><i class="fa fa-trash"></i> DELETE </button>
    
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
