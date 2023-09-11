<?php if (hasAccess('counseling intake/view', $currentUser)): ?>
<div class="row">
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="header-title">VIEW COUNSELING INFORMATION</div>
        <div class="clearfix"></div><hr>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th class="text-right" style="width:15%"> STUDENT NAME : </th>
                  <td class="italic">{{ data.CounselingIntake.student_name }}</td>
                </tr>
                <tr>
                  <th class="text-right"> COURSE & YEAR LEVEL : </th>
                  <td class="italic"> {{data.CollegeProgram.code}} - {{ data.CounselingIntake.year_level_term }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CONTACT NO : </th>
                  <td class="italic">{{ data.CounselingIntake.contact_no }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE OF BIRTH : </th>
                  <td class="italic">{{ data.CounselingIntake.birth_date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> CURRENT ADDRESS : </th>
                  <td class="italic">{{ data.CounselingIntake.address }}</td>
                </tr>
                <tr>
                  <th class="text-right"> PLACE OF BIRTH : </th>
                  <td class="italic">{{ data.CounselingIntake.birth_place }}</td>
                </tr>
                <tr>
                  <th class="text-right"> DATE : </th>
                  <td class="italic">{{ data.CounselingIntake.date }}</td>
                </tr>
                <tr>
                  <th class="text-right"> REMARKS : </th>
                  <td class="italic">{{ data.CounselingIntake.remarks }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-md-12 mt-4">
                <div class="form-group">
                  <label>BEHAVIOR <i class="required">*</i></label>
                  <div class="table-responsive px-5">
                    <table class="table">
                      
                      <tr>
                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[0]">
                        </th>
                        <th>Overeat</th>

                        <th><input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[1]">
                        </th>
                        <th>Suicidal attempts</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[2]">
                        </th>
                        <th>Take drugs</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[3]">
                        </th>
                        <th>Insomnia</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[4]">
                        </th>
                        <th>Compulsions</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[5]">
                        </th>
                        <th>Smoking</th>

                        <th><input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[6]">
                        </th>
                        <th>Odd behavior</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[7]">
                        </th>
                        <th>Withdrawal</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[8]">
                        </th>
                        <th>Lack of Motivation</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[9]">
                        </th>
                        <th>Eating problems</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[10]">
                        </th>
                        <th>Procrastination</th>

                        <th><input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[11]">
                        </th>
                        <th>Sleep disturbance</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[12]">
                        </th>
                        <th>Loss of Control</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[13]">
                        </th>
                        <th>Aggressive behavior</th>

                        <th> <input icheck type="checkbox" disabled = "true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[14]">
                        </th>
                        <th>Others..</th>
                      </tr>

                    </table>
                  </div>
                  <div class="col-md-9 pt-5"></div>
                  <div class="col-md-3" ng-show="data.CounselingIntakeSub.behave[14] ==true">
                    <input disabled type="text" class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.CounselingIntakeSub.otherBehave">
                  </div>
                </div>
              </div>

              <div class="col-md-12 mt-4">
                <div class="form-group">
                  <label>FEELINGS <i class="required">*</i></label>
                  <div class="table-responsive px-5">
                    <table class="table">

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true"  class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[0]">
                        </th>
                        <th>Angry</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[1]">
                        </th>
                        <th>Guilty</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[2]">
                        </th>
                        <th>Unhappy</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[3]">
                        </th>
                        <th>Annoyed</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[4]">
                        </th>
                        <th>Happy</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[5]">
                        </th>
                        <th>Bored </th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[6]">
                        </th>
                        <th>Sad</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[7]">
                        </th>
                        <th>Conflicted</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[8]">
                        </th>
                        <th>Restless</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[9]">
                        </th>
                        <th>Depressed</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[10]">
                        </th>
                        <th>Regretful</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[11]">
                        </th>
                        <th>Lonely</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[13]">
                        </th>
                        <th>Anxious</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[14]">
                        </th>
                        <th>Jealous</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[15]">
                        </th>
                        <th>Contented</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[16]">
                        </th>
                        <th>Fearful</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[17]">
                        </th>
                        <th>Hopeful</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[18]">
                        </th>
                        <th>Excited</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[19]">
                        </th>
                        <th>Panicky</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[20]">
                        </th>
                        <th>Helpless</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[21]">
                        </th>
                        <th>Envious</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[22]">
                        </th>
                        <th>Energetic</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[23]">
                        </th>
                        <th>Relaxed</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[24]">
                        </th>
                        <th>Tense</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[25]">
                        </th>
                        <th>Hopeless</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[26]">
                        </th>
                        <th>Optimistic</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[27]">
                        </th>
                        <th>Others:</th>
                      </tr>

                    </table>
                  </div>
                  <div class="col-md-9 pt-5"></div>
                  <div class="col-md-3" ng-show="data.CounselingIntakeSub.feel[27] ==true">
                    <input type="text" disabled class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.CounselingIntakeSub.otherFeel">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 mt-4">
                <div class="form-group">
                  <label>PHYSICAL <i class="required">*</i></label>
                  <div class="table-responsive px-5">
                    <table class="table">

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[0]">
                        </th>
                        <th>Headaches</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[1]">
                        </th>
                        <th>Stomach trouble</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[2]">
                        </th>
                        <th>Skin problems</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[3]">
                        </th>
                        <th>Dizziness</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[4]">
                        </th>
                        <th>Tics</th>
                      </tr>

                      <tr>
                      <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[5]">
                        </th>
                        <th>Dry mouth</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[6]">
                        </th>
                        <th>Palpitations </th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[7]">
                        </th>
                        <th>Fatigue </th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[8]">
                        </th>
                        <th>Muscle spasms</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[9]">
                        </th>
                        <th>Itchy skin</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[10]">
                        </th>
                        <th>Chest pains</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[11]">
                        </th>
                        <th>Tensions</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[12]">
                        </th>
                        <th>Back pain</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[13]">
                        </th>
                        <th>Rapid heartbeat</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[14]">
                        </th>
                        <th>Numbness</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[15]">
                        </th>
                        <th>Sexual disturbances</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[16]">
                        </th>
                        <th>Unable to relax</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[17]">
                        </th>
                        <th>Fainting spells</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[18]">
                        </th>
                        <th>Bowel disturbances</th>

                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[19]">
                        </th>
                        <th>Visual disturbances</th>
                      </tr>

                      <tr>
                        <th> <input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[20]">
                        </th>
                        <th>Hearing problems</th>

                        <th><input icheck type="checkbox" disabled="true" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[21]">
                        </th>
                        <th>Others:</th>
                        <th colspan="5"><input disabled ng-show="data.CounselingIntakeSub.phy[21] ==true" type="text" class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.CounselingIntakeSub.otherPhysical"></th>
                      </tr>

                    </table>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label>PRESENT SITUATION</label><br>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Do you have problems at school?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.school" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.school" value="0" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input disabled type="text" class="form-control" ng-model="data.CounselingIntake.schoolYes">
                  </h6>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-2">
              <div class="form-group">
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Do you have problems at home?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.home" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.home" value="0" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input disabled type="text" class="form-control" ng-model="data.CounselingIntake.homeYes">
                  </h6>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-2">
              <div class="form-group">
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Do you stay in a boarding house?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouse" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouse" value="0" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    If YES, do you have problems in the boarding house?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouseProb" value="1"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouseProb" value="0"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input disabled type="text" class="form-control" ng-model="data.CounselingIntake.bhouseYes">
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Is there something bothering you right now?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.bother" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.bother" value="0"  data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input disabled type="text" class="form-control" ng-model="data.CounselingIntake.botherYes">
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Do you wish to talk further to your Guidance Counselor?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.guidance" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input disabled type="radio" autocomplete="false" ng-model="data.CounselingIntake.guidance" value="0" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
              </div>
            </div>
          </div>
          


          <div class="col-md-12">
            <div class="clearfix"></div><hr>
          </div>
          <div class="col-md-12">
            <div class="pull-right">
              <?php if (hasAccess('counseling intake/edit', $currentUser)): ?>
                <a href="#/guidance/counseling-intake/edit/{{ data.CounselingIntake.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT </a>
               <?php endif ?>
               <?php if (hasAccess('counseling intake/print', $currentUser)): ?>
              <button type="button" class="btn btn-info  btn-min" ng-click="print(data.CounselingIntake.id )"><i class="fa fa-print"></i> PRINT COUNSELING INTAKE </button>
              <?php endif ?>
              <?php if (hasAccess('counseling intake/delete', $currentUser)): ?> 
                <button class="btn btn-danger btn-min" ng-click="remove(data.CounselingIntake)"><i class="fa fa-trash"></i> DELETE </button>
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
