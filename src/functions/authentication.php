<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Abdullah, Boaz, Jesse, Jordy, Kahn, Ton
 * login functions for project
 */

// ob_start();

// class auth
// {
//     private $session;
//     private $username;
//     private $password;
//     private $db;


//     public function __construct()
//     {
//         $this->db = new database();
//     }

//     private function generateSession($usertoken)
//     {
//         // gen_session('isLoggedIn', $usertoken);
//         $_SESSION['isloggedIn'] = $usertoken;
//     }

//     public function register($username, $password, $repeat)
//     {
//         if (empty($username) || empty($password) || empty($repeat)) {
//             return '<script> swal({ title: "Something went wrong!", text: "Please fill all fields!", icon: "error",  }).then(function(){ 
//                 location.replace("");
//                 }
//              ); </script>';
//         }

//         if ($password !== $repeat) {
//             return '<script> swal({ title: "Something went wrong!", text: "The confirm password confirmation does not match.", icon: "error", }).then(function(){ 
//                 location.replace("");
//                 }
//              ); </script>';
//         }
                
//         $this->username = $username;
//         $this->password = hashString($password);
        
//         $checklogin = $this->db->getLogin($this->username, $this->password);
//         if ($checklogin == '0 results found!') {
//             $regist = $this->db->registerUser($this->username, $this->password);        

//             if ($regist == '0 results found!') {
//                 return '<script> swal({ title: "Something went wrong!", text: "Can not register.", icon: "error", }).then(function(){ 
//                     location.replace("");
//                     }
//                  ); </script>';
//             }
//             else {
//                 echo $this->login($username, hashString($password));
//             }   
//         }
//         else {
//             return '<script> swal({ title: "Something went wrong!", text: "Can not register.", icon: "error", }).then(function(){ 
//                     location.replace("");
//                 }
//              ); </script>';
//         }
//     }

//     public function login($username, $password)
//     {
//         if (empty($username) || empty($password)) {
//             return 'Please fill all fields!';
//         }

//         $this->username = $username;
//         $this->password = hashString($password);

//         $result = $this->db->getLogin($this->username, $this->password);

//         $this->generateSession(mysqli_fetch_assoc($result)['wCustomerID']);

//         return '<script> swal({ title: "Good job!", text: "Successfully logged in!", icon: "success", }).then(function(){ 
//             location.replace("");
//             }
//             ); </script>';
// }
//     public function logout()
//     {
//         session_destroy();
//         session_regenerate_id(true);
//         return '<script> swal({ title: "Good job!", text: "Successfully logged out!", icon: "success", }).then(function(){ 
//             location.replace("/home");
//             }
//          );  </script>';
//     }
// }