<?php

class Application_Model_User {
     public function generateloginReport($data) {
           
            $contents = file_get_contents('http://192.168.100.212:1111/IVRMIS/UserLogin?username='.$data['id'].'&password='.$data['pass'].'');
            return $contents;
}
  public function generateforgotpassReport($data){
                  $contents = file_get_contents('http://192.168.100.212:1111/IVRMIS/ForgotPassword?emailAddress='.$data['id'].'');
                  return $contents;
                  
                  
                  }
                   public function generateforgotpass1Report($data){
                   
                   }
           
}
