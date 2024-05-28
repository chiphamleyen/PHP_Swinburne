<?php
class HitCounter
{
    private $conn;
    private $table;

    function __construct($host, $username, $password, $dbname, $tablename)
    {
        $this->conn = @mysqli_connect($host, $username, $password, $dbname)
            or die('<p>CONNECTION FAILED: ' . mysqli_connect_error() . '</p>');
        $this->table = $tablename;
    }

    function getHits()
    {
        $sqlquery = 'SELECT * FROM ' . $this->table;
        $result = $this->conn->query($sqlquery) or die('Failed to get hits');
        $record = $result->fetch_assoc();
        $result->free_result();
        return $record['hits'];
    }

    function setHits()
    {
        $addHits = $this->getHits() + 1;
        $sqlquery = 'UPDATE ' . $this->table . ' SET hits = ' . $addHits . ' WHERE id = 1;';
        $this->conn->query($sqlquery) or die('Failed to set hits');
    }

    function closeConnection()
    {
        $this->conn->close();
    }

    function startOver()
    {
        $sqlquery = 'UPDATE hitcounter SET hits = 0 WHERE id = 1;';
        $this->conn->query($sqlquery);
    }
}
?>