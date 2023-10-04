<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use App\Model\Table\SettingsTable;
use Cake\ORM\TableRegistry;

class GlobalComponent extends Component {

  public function monthlyApartelleBalance(){

    $this->ApartelleRegistrations = TableRegistry::getTableLocator()->get('ApartelleRegistrations');

    $this->StudentLedgers = TableRegistry::getTableLocator()->get('StudentLedgers');

    $this->Apartelles = TableRegistry::getTableLocator()->get('Apartelles');

    $students_renting = $this->ApartelleRegistrations->find()

      ->where([

        'visible' => 1,

        'approve' => 1,

        'active' => 1

      ])

    ->all();

    $c_start = date('Y-m', strtotime(date('Y-m-d'))).'-01';

    $month_end = date('Y-m-d',(strtotime('-1 day',strtotime ($c_start))));

    if(count($students_renting) > 0){

      foreach ($students_renting as $key => $value) {

        $student_id = $value['student_id'];

        $apartelle_id = $value['apartelle_id'];

        $tmp = $this->StudentLedgers->find()

          ->where([

            'student_id' => $student_id,

            'visible' => 1,

            'period' => $month_end

          ])

        ->count();

        if($tmp == 0){

          $apartelle = $this->Apartelles->find()

            ->where([

              'id' => $apartelle_id,

              'visible' => 1,

            ])

          ->first();
        
          $studentLedgerEntity = $this->StudentLedgers->newEntity([

            'student_id' => $student_id,

            'balance' => $apartelle['price'] > 0 ? $apartelle['price'] : null,

            'remarks' => 'Apartelle/Dormitory Balance',

            'period' => $month_end

          ]);
          
          $this->StudentLedgers->save($studentLedgerEntity);

        }

      }

    }

  }

  public function OfficeReference($type = null){

    $this->OfficeReferences = TableRegistry::getTableLocator()->get('OfficeReferences');

    $data['OfficeReference'] = $this->OfficeReferences->find()

      ->where([

        'visible' => 1,

        'sub_module' => $type

      ])

      ->first();

    if(count($data) > 0) {

      return $data;

    }

    else { return null; }

  }

  public function Settings($setting){

    $settingsTable = new SettingsTable();

    $data = $settingsTable->find()

      ->where(['code' => $setting])

    ->first();

    if ($data !== null) {

      return $data->value;

    } else {

      return null;

    }

  }

  public function EnrollmentSettings($setting){

      $this->EnrollmentSetting = ClassRegistry::init('EnrollmentSetting');

      $data = $this->EnrollmentSetting->find('first', array(

        'conditions'=>array(

          'EnrollmentSetting.code'=>$setting

        )

      ));

      if(count($data) > 0) {

          return $data['EnrollmentSetting']['value'];

      }

      else { return null; }

  }

  public function BranchSettings($setting){

    $this->Branch = ClassRegistry::init('Branch'); 

    $this->Setting = ClassRegistry::init('Setting'); 

    $this->BranchSetting = ClassRegistry::init('BranchSetting'); 

    $id = $this->Setting->find('first',array('conditions'=>array('code'=>$setting)));

    $data = $this->BranchSetting->find('first',array(

      'conditions'=>array(

        'BranchSetting.branchId' => $this->Branch->checkBranch('id'),

        'BranchSetting.settingId' => $id['Setting']['id']          

      )));



    if(count($data) > 0) {

          return $data['BranchSetting']['value'];

      }

      else { return null; }

  } 

  public function paymentSchedule($data = array()){

    $result = array();

    

    $amount = isset($data['amount']) ? $data['amount'] : 0;

    $interestType = isset($data['interestType']) ? $data['interestType'] : 'annual';

    $interest = isset($data['interest']) ? $data['interest'] : 0;

    

    $paymentType = isset($data['paymentType']) ? $data['paymentType'] : 3;

    $months = isset($data['months']) ? $data['months'] : 0;

    $years = isset($data['years']) ? $data['years'] : 0;

    

    $type = isset($data['type']) ? $data['type'] : 1;

    $typeSub = isset($data['typeSub']) ? $data['typeSub'] : 1;

    

    

    $totalMonths = $months + ($years/12);

    $interestRate = $interestType == 'annual'? $interest : $interest*12;

    

    

    if($paymentType == 1){

      $paymentCount = $totalMonths * 4;

      $interestRate = ($interestRate/12)/4;

    }elseif($paymentType == 2){

      $paymentCount = $totalMonths * 2;

      $interestRate = ($interestRate/12)/2;

    }elseif($paymentType == 3){

      $paymentCount = $totalMonths * 1;

      $interestRate = ($interestRate/12);

    }elseif($paymentType == 4){

      $paymentCount = $totalMonths/4;

      $interestRate = ($interestRate/4);

    }elseif($paymentType == 5){

      $paymentCount = $totalMonths/6;

      $interestRate = ($interestRate/2);

    }elseif($paymentType == 6){

      $paymentCount = $totalMonths/12;

      $interestRate = $interestRate;

    }

    

    

    if($type == 1){

      

      $totalInterest = $amount * (($paymentCount*$interestRate)/100);

      $principal = $amount/$paymentCount;

      $interest = $totalInterest/$paymentCount;

      $installment = $principal + $interest;

      

      for($i=1; $i<=$paymentCount; $i++){

        $balance = $amount - ($principal * $i);

        $data = array(

          'balance'=>$balance,

          'principal'=>$principal,

          'interest'=>$interest,

          'penalty'=>0,

          'installment'=>$installment

        );

        $result[] = $data;

      }

      

    }elseif($type == 2){

      

      if($typeSub == 1){

        $amountPerPayment =  (($interestRate/100) * $amount * (pow(1 + ($interestRate/100), $paymentCount))) / ((pow(1 + ($interestRate/100), $paymentCount)) - 1);

        $totalBalance = $amount;

        for($i=1; $i<=$paymentCount; $i++){

          

          $interest =  $totalBalance * $interestRate/100;

          $principal = $amountPerPayment - $interest;

          $balance = $totalBalance - $principal;

          

          $data = array(

            'balance'=>$balance,

            'principal'=>$principal,

            'interest'=>$interest,

            'penalty'=>0,

            'installment'=>$amountPerPayment

          );

          $totalBalance -= $principal;

          

          $result[] = $data;

        }

      }elseif($typeSub == 2){

        $principal =  $amount/$paymentCount;

        $totalBalance = $amount;

        for($i=1; $i<=$paymentCount; $i++){

          

          $interest =  $totalBalance * $interestRate/100;

          $amountPerPayment = $principal + $interest;

          $balance = $totalBalance - $principal;

          

          $data = array(

            'balance'=>$balance,

            'principal'=>$principal,

            'interest'=>$interest,

            'penalty'=>0,

            'installment'=>$amountPerPayment

          );

          $totalBalance -= $principal;

          

          $result[] = $data;

        }

      }elseif($typeSub == 3){

        $totalInterest = $amount * (($paymentCount*$interestRate)/100);

        $principal = $amount/$paymentCount;

        $interest = $totalInterest/$paymentCount;

        $installment = $principal + $interest;

        

        for($i=1; $i<=$paymentCount; $i++){

          $balance = $amount - ($principal * $i);

          $data = array(

            'balance'=>$balance,

            'principal'=>$principal,

            'interest'=>$interest,

            'penalty'=>0,

            'installment'=>$installment

          );

          $result[] = $data;

        }

      }

    }

    

    return $result;

  }





  // public function TotalArr($arrs = array(), $field){

  //   $total = 0;

  //   foreach($arrs as $arr){

  //     $total += $arr[$field];

  //   }

  //   return $total;

  // }

}