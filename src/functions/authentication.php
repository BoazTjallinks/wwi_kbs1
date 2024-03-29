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

    public function register($username, $password, $repeat, $customerCountry, $customerStreetNumber, $customerStreetPostal, $customerName, $customerStreetName, $customerStreetCity)
    {
        if (empty($username) || empty($password) || empty($repeat) || empty($customerCountry) || empty($customerStreetNumber) || empty($customerStreetPostal) || empty($customerName)|| empty($customerStreetCity)|| empty($customerStreetName)) {
            return showSwall('Something went wrong!', "Please fill all fields!", "error", "");
        }

        if ($password !== $repeat) {
            return showSwall('Something went wrong!', "The confirm password confirmation does not match.", "error", "");
        }
                
        $this->username = $username;
        $this->password = hashString($password);
        
        $checklogin = $this->db->DBQuery('SELECT * FROM webCustomer WHERE wCustomerEmail = ? AND wCustomerPassword = ?', [$this->username, $this->password]);
        // print_r($checklogin);

        if ($checklogin == '0 results found!') {
            // $regist = $this->db->DBQuery('INSERT INTO webCustomer (wCustomerEmail, wCustomerPassword, wCustomerPerms) value (?, ?, ?)', [$this->username, $this->password, '1']);
            $regist = $this->db->DBQuery('INSERT INTO webCustomer (wCustomerEmail, wCustomerPassword, wCustomerPerms, wCustomerCountry, wCustomerStreetNumber, wCustomerStreetPostal, wCustomerName, wCustomerCity, wCustomerStreetname)  value (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$this->username, $this->password, '1', $customerCountry, $customerStreetNumber, $customerStreetPostal, $customerName, $customerStreetCity, $customerStreetName]);
            // INSERT INTO webCustomer (wCustomerEmail, wCustomerPassword, wCustomerPerms, wCustomerCountry, wCustomerStreetNumber, wCustomerStreetPostal, wCustomerName)
            if ($regist == '0 results found!') {
                return showSwall('Something went wrong!', "Can not register.", "error", "");
            } else {
                echo $this->login($username, hashString($password));
            }
        } else {
            return showSwall('Something went wrong!', "Can not register.", "error", "");
        }
    }

    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            // return 'Please fill all fields!';
            return showSwall('Something went wrong!', "Please fill all fields!", "error", "");
        }

        $this->username = $username;
        $this->password = hashString($password);

        $result =  $this->db->DBQuery('SELECT * FROM webCustomer WHERE wCustomerEmail = ? AND wCustomerPassword = ?', [$this->username, $this->password]);

        if ($result == '0 results found!') {
            return showSwall('Error!', "Username or password is wrong!", "error", "");
        } else {
            $this->generateSession($result[0]['wCustomerID']);
            return showSwall('Good job!', "Successfully logged in!", "success", "");
        }
    }
    
    public function logout()
    {
        unset($_SESSION['isloggedIn']);
    }
}
