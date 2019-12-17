<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Boaz, Jesse, Jordy, Kahn, Ton
 * This file parses all database functions
 */


class database 
{
    private $servername = 'school.blltjallinks.nl';
    private $username = 'kbs';
    private $password = 'b$ZR^13v^s5I';
    private $dbname = 'wideworldimporters';
    private $connection;

    /**
     * Construcs mysql connection
     * @return mixed
     */
    public function __construct()
    {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname, 3306);
    
        if (mysqli_connect_error($this->connection)) {
            die("Connection failed: " . mysqli_connect_error($this->connection));
        }
    }

    /**
     * Mysql check for result
     * @param mixed Result data
     * @return mixed Data or error
     */
    private function returnQuery($result)
    {
        try {
            if (!$result || mysqli_num_rows($result) > 0) {
                
                $returnValue = array();
                while($row = mysqli_fetch_assoc($result))
                {
                    array_push($returnValue, $row);
                }

                return $returnValue;

            } else {
                return '0 results found!';
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Dynamic database functiothe correct page and displayes this for the user. If not it redirects to a 404 pagen
     * @param string $query - Database Query
     * @param array $param - All parameters for bind params
     * @example $database->DBQuery('SELECT * FROM stockitems WHERE RecommendedRetailPrice BETWEEN ? AND ?', [135, 340]);
     * @usage $database->DBquery(QUERY, VALUE ARRAY);
     * @return mixed
     */
    public function DBQuery(string $query, array $param) 
    {   
        $stmt = $this->connection->prepare($query);
        $types = str_repeat('s', count($param));
        $stmt->bind_param($types, ...$param);
        $stmt->execute();

        $result = mysqli_stmt_get_result($stmt);
        return $this->returnQuery($result);
        
    }

    /**
     * Closes mysqli connection
     */
    public function closeConnection()
    {
        try {
            mysqli_close($this->connection);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}