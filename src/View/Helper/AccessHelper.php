<?php 

namespace App\View\Helper;

use Cake\View\Helper;

class AccessHelper extends Helper{

  public function hasAccess($code, $user){

    $result = false;

    if ($user->toArray()['roleId'] == 1) {

      $result = true;

    } 

    if (isset($user->toArray()['user_permissions'])) {

      if (in_array($code, $user->toArray()['user_permissions'])) {

        $result = true;

      }

    }  

    return $result;

  }

}