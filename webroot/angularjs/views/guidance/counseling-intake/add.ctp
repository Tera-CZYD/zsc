<?php if (hasAccess('counseling intake/add', $currentUser)) : ?>
  <div class="row">
    <div class="col-lg-12 mt-3">
      <div class="card">
        <div class="card-body">
          <div class="header-title">ADD NEW COUNSELING INTAKE </div>
          <div class="clearfix"></div>
          <hr>
          <form id="form">
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label> SEARCH STUDENT </label><label style="font-size:10px;color:gray;" class="pull-right">Press Enter to search</label>
                  <input type="text" class="form-control search uppercase" placeholder="TYPE STUDENT HERE" ng-model="searchTxt" ng-enter="searchStudent({ search: searchTxt })">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label> STUDENT <i class="required">*</i></label>
                  <table class="table table-bordered">
                    <tr>
                      <td style="{{ data.CounselingIntake.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="uppercase">{{ data.CounselingIntake.student_name }}</td>
                      <td style="{{ data.CounselingIntake.student_name == undefined ? 'padding:15px':'padding:5px !important'}}" class="w30px" ng-hide="data.CounselingIntake.student_name == undefined">
                        <button class="btn btn-xs btn-sm  btn-danger" ng-click="data.CounselingIntake.student_name = null; data.CounselingIntake.student_id = null;" ng-init="data.CounselingIntake.student_id = null"><i class="fa fa-times"></i></button>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>

              <!-- <div class="col-md-6">
                <div class="form-group">
                  <label> COURSE <i class="required">*</i></label>
                  <select selectize ng-model="data.CounselingIntake.course_id" ng-options="opt.id as opt.value for opt in course" ng-change="getCourse(data.CounselingIntake.course_id)" data-validation-engine="validate[required]">
                    <option value=""></option>
                  </select>
                </div>
              </div> -->

              <div class="col-md-6">
                <div class="form-group">
                  <label> PROGRAM <i class="required">*</i></label>
                  <select selectize ng-options="opt.id as opt.value for opt in college_program" ng-model="data.CounselingIntake.course_id" data-validation-engine="validate[required]">
                  <option value=""></option></select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> YEAR LEVEL <i class="required">*</i></label>
                  <select class="form-control" ng-model="data.CounselingIntake.year_level_term" data-validation-engine="validate[required]">
                    <option value=""></option>
                    <option value="FIRST YEAR">FIRST YEAR</option>
                    <option value="SECOND YEAR">SECOND YEAR</option>
                    </option>
                    <option value="THIRD YEAR">THIRD YEAR</option>
                    <option value="FOURTH YEAR">FOURTH YEAR</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> CONTACT NO <i class="required">*</i></label>
                  <input type="text" class="form-control" ng-model="data.CounselingIntake.contact_no" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> DATE OF BITH <i class="required">*</i></label>
                  <input type="text" class="form-control datepicker" ng-model="data.CounselingIntake.birth_date" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> CURRENT ADDRESS <i class="required">*</i></label>
                  <input type="text" class="form-control" ng-model="data.CounselingIntake.address" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> PLACE OF BIRTH <i class="required">*</i></label>
                  <input type="text" class="form-control" ng-model="data.CounselingIntake.birth_place" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> DATE <i class="required">*</i></label>
                  <input type="text" class="form-control datepicker" ng-model="data.CounselingIntake.date" data-validation-engine="validate[required]">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label> REMARKS <i class="required">*</i></label>
                  <input type="text" class="form-control" ng-model="data.CounselingIntake.remarks" data-validation-engine="validate[required]">
                </div>
              </div>


            </div>
          </form>


          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label>BEHAVIOR <i class="required">*</i></label>
                <div class="table-responsive px-5">

                  <table class="table">
                    <h6>Check any of the following behaviors that apply to you:</h6>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[0]">
                      </th>
                      <th>Overeat</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[1]">
                      </th>
                      <th>Suicidal attempts</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[2]">
                      </th>
                      <th>Take drugs</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[3]">
                      </th>
                      <th>Insomnia</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[4]">
                      </th>
                      <th>Compulsions</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[5]">
                      </th>
                      <th>Smoking</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[6]">
                      </th>
                      <th>Odd behavior</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[7]">
                      </th>
                      <th>Withdrawal</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[8]">
                      </th>
                      <th>Lack of Motivation</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[9]">
                      </th>
                      <th>Eating problems</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[10]">
                      </th>
                      <th>Procrastination</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[11]">
                      </th>
                      <th>Sleep disturbance</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[12]">
                      </th>
                      <th>Loss of Control</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[13]">
                      </th>
                      <th>Aggressive behavior</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.behave[14]">
                      </th>
                      <th>Others...</th>
                    </tr>

                  </table>
                </div>
                  <div class="col-md-9 pt-5"></div>
                  <div class="col-md-3" ng-show="data.CounselingIntakeSub.behave[14] ==true">
                    <input type="text" class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.CounselingIntakeSub.otherBehave">
                  </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label>FEELINGS <i class="required">*</i></label>
                <div class="table-responsive px-5">

                  <table class="table">
                    <h6>Check any of the following behaviors that apply to you:</h6>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[0]">
                      </th>
                      <th>Angry</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[1]">
                      </th>
                      <th>Guilty</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[2]">
                      </th>
                      <th>Unhappy</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[3]">
                      </th>
                      <th>Annoyed</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[4]">
                      </th>
                      <th>Happy</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[5]">
                      </th>
                      <th>Bored </th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[6]">
                      </th>
                      <th>Sad</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[7]">
                      </th>
                      <th>Conflicted</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[8]">
                      </th>
                      <th>Restless</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[9]">
                      </th>
                      <th>Depressed</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[10]">
                      </th>
                      <th>Regretful</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[11]">
                      </th>
                      <th>Lonely</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[13]">
                      </th>
                      <th>Anxious</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[14]">
                      </th>
                      <th>Jealous</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[15]">
                      </th>
                      <th>Contented</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[16]">
                      </th>
                      <th>Fearful</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[17]">
                      </th>
                      <th>Hopeful</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[18]">
                      </th>
                      <th>Excited</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[19]">
                      </th>
                      <th>Panicky</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[20]">
                      </th>
                      <th>Helpless</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[21]">
                      </th>
                      <th>Envious</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[22]">
                      </th>
                      <th>Energetic</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[23]">
                      </th>
                      <th>Relaxed</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[24]">
                      </th>
                      <th>Tense</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[25]">
                      </th>
                      <th>Hopeless</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[26]">
                      </th>
                      <th>Optimistic</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.feel[27]">
                      </th>
                      <th>Others:</th>
                      <!-- <th><input  ng-show="data.CounselingIntakeSub.feel[27] ==true" type="text" class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.RequestForm.otherBehaveVal"></th> -->
                    </tr>
                    
                  </table>
                </div>
                <div class="col-md-9 pt-5"></div>
                  <div class="col-md-3" ng-show="data.CounselingIntakeSub.feel[27] ==true">
                    <input type="text" class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.CounselingIntakeSub.otherFeel">
                  </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12 mt-4">
              <div class="form-group">
                <label>PHYSICAL <i class="required">*</i></label>
                <div class="table-responsive px-5">

                  <table class="table">
                    <h6>Check any of the following behaviors that apply to you:</h6>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[0]">
                      </th>
                      <th>Headaches</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[1]">
                      </th>
                      <th>Stomach trouble</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[2]">
                      </th>
                      <th>Skin problems</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[3]">
                      </th>
                      <th>Dizziness</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[4]">
                      </th>
                      <th>Tics</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[5]">
                      </th>
                      <th>Dry mouth</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[6]">
                      </th>
                      <th>Palpitations </th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[7]">
                      </th>
                      <th>Fatigue </th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[8]">
                      </th>
                      <th>Muscle spasms</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[9]">
                      </th>
                      <th>Itchy skin</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[10]">
                      </th>
                      <th>Chest pains</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[11]">
                      </th>
                      <th>Tensions</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[12]">
                      </th>
                      <th>Back pain</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[13]">
                      </th>
                      <th>Rapid heartbeat</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[14]">
                      </th>
                      <th>Numbness</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[15]">
                      </th>
                      <th>Sexual disturbances</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[16]">
                      </th>
                      <th>Unable to relax</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[17]">
                      </th>
                      <th>Fainting spells</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[18]">
                      </th>
                      <th>Bowel disturbances</th>

                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[19]">
                      </th>
                      <th>Visual disturbances</th>
                    </tr>

                    <tr>
                      <th> <input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[20]">
                      </th>
                      <th>Hearing problems</th>

                      <th><input icheck type="checkbox" class="form-control" autocomplete="false" ng-model="data.CounselingIntakeSub.phy[21]">
                      </th>
                      <th>Others:</th>
                      <th colspan="5"><input  ng-show="data.CounselingIntakeSub.phy[21] ==true" type="text" class="form-control" placeholder="Please Specify" autocomplete="false" ng-model="data.CounselingIntakeSub.otherPhysical"></th>
                    </tr>

                  </table>
                </div>
                
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
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.school" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.school" value="2" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input type="text" class="form-control" ng-model="data.CounselingIntake.schoolYes">
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
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.home" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.home" value="2" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input type="text" class="form-control" ng-model="data.CounselingIntake.homeYes">
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
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouse" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouse" value="2" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    If YES, do you have problems in the boarding house?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouseProb" value="1"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.bhouseProb" value="2"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input type="text" class="form-control" ng-model="data.CounselingIntake.bhouseYes">
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Is there something bothering you right now?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.bother" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.bother" value="2"  data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-5">
                    If YES, please specify: 
                    <input type="text" class="form-control" ng-model="data.CounselingIntake.botherYes">
                  </h6>
                </div>
                <div class="col-md-12">
                  <h6 class="radio-inline mx-3">
                    Do you wish to talk further to your Guidance Counselor?
                    <i class="required">*</i>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.guidance" value="1" data-validation-engine="validate[required]"> YES
                    </label>
                    <label class="radio-inline mx-2">
                      <input type="radio" autocomplete="false" ng-model="data.CounselingIntake.guidance" value="2" data-validation-engine="validate[required]"> NO
                    </label>
                  </h6>
                </div>
              </div>
            </div>
          </div>
          


          <div class="clearfix"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="pull-right">
                <button class="btn btn-primary btn-min" id="save" ng-click="save();"><i class="fa fa-save"></i> SAVE </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="modal fade" id="searched-student-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ADVANCE SEARCH</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered vcenter table-striped table-condensed">
              <thead>
                <tr>
                  <th class="w30px">#</th>
                  <th class="text-center">STUDENT NUMBER</th>
                  <th class="text-center">NAME</th>
                  <th class="w30px"></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="student in students">
                  <td>{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
                  <td class="uppercase text-center">{{ student.code }}</td>
                  <td class="uppercase text-center">{{ student.name }}</td>
                  <td>
                    <input icheck type="radio" ng-init="student.selected = false" ng-model="student.selected" name="iCheck" ng-selected="student.selected = true" ng-change="selectedStudent(student)">
                  </td>
                </tr>
              </tbody>
              <tfoot ng-show="paginator.pageCount > 0">
                <tr>
                  <td colspan="4" class="text-center">
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="pagination justify-content-center">
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&laquo;&laquo;</sub></a>
                          </li>
                          <li class="page-item prevPage {{ !paginator.prevPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&laquo;</a>
                          </li>
                          <li ng-repeat="page in pages" class="page-item {{ paginator.page == page.number ? 'active':''}}" >
                            <a class="page-link" href="javascript:void(0)" class="text-center" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">{{ page.number }}</a>
                          </li>
                          <li class="page-item nextPage {{ !paginator.nextPage? 'disabled':'' }}">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})">&raquo;</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" ng-click="searchStudent({ page: 1 ,search: searchTxtStudent})"><sub>&raquo;&raquo;</sub> </a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="text-center" ng-show="paginator.pageCount > 0">
                          <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>  
      </div> 

      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
          <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="studentData(employee.id)" data-dismiss="modal"><i class="fa fa-check"></i> OK</button>
        </div> 
        
      </div>
    </div>  
  </div><!-- /.modal-content -->
</div>

<style type="text/css">
  th {
    white-space: nowrap;
  }

  td {
    white-space: nowrap;
  }
</style>