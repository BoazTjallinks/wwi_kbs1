<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Abdullah, Boaz, Jesse, Jordy, Kahn, Ton
 * login functions for project
 */

ob_start();

class auth
{
    private $session;
    private $username;
    private $password;
    private $db;


    public function __construct()
    {
        $this->db = new database();
    }

    private function generateSession($usertoken)
    {
        // gen_session('isLoggedIn', $usertoken);
        $_SESSION['isloggedIn'] = $usertoken;
    }

    public function register($username, $password, $repeat)
    {
        if (empty($username) || empty($password) || empty($repeat)) {                          
             return showSwall('Something went wrong!', "Please fill all fields!", "error", "");
        }

        if ($password !== $repeat) {                     
            return showSwall('Something went wrong!', "The confirm password confirmation does not match.", "error", "");
        }
                
        $this->username = $username;
        $this->password = hashString($password);
        
        $checklogin = $this->db->DBQuery('SELECT * FROM webCustomer WHERE wCustomerEmail = ? AND wCustomerPassword = ?', [$this->username, $this->password]);

        if ($checklogin == '0 results found!') {
            $regist = $this->db->DBQuery('INSERT INTO webCustomer (wCustomerEmail, wCustomerPassword, wCustomerPerms) value (?, ?, ?)', [$this->username, $this->password]);        

            if ($regist == '0 results found!') {      
                return showSwall('Something went wrong!', "Can not register.", "error", "");
            }
            else {
                print_r($regist);
                // echo $this->login($username, hashString($password));
            }   
        }
        else {
             return showSwall('Something went wrong!', "Can not register.", "error", "");
        }
    }

    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            return 'Please fill all fields!';
        }

        $this->username = $username;
        $this->password = hashString($password);

        $result =  $this->db->DBQuery('SELECT * FROM webCustomer WHERE wCustomerEmail = ? AND wCustomerPassword = ?', [$this->username, $this->password]);;

        $this->generateSession(mysqli_fetch_assoc($result)['wCustomerID']);

        return showSwall('Good job!', "Successfully logged in!", "success", "/home");
    }
    
    public function logout()
    {
        session_destroy();
        session_regenerate_id(true);
        
    }
}