<?php
namespace bot;
use mysqli;
class ParentModel
{
    private mysqli $dbLink;
    public function __construct()
    {
        $this->connect();
    }

    public function connect():void
    {
        $this->dbLink = new mysqli(SERVER_NAME, USER_NAME, PASSWORD, BD_NAME);
        if ($this->dbLink->connect_error) {
            die("Connection failed: " . $this->dbLink->connect_error);
        }

    }
    public function fromTable(string $table, string $column, string $table2 = '', string $column2 = ''): array
    {
        if ($table === 'in_messages' || $table === 'requests'){
            $sql = "SELECT  " . $column . " FROM " . $table . " WHERE processed=0";
        }elseif ($table2 === 'responses'){
            $sql = "SELECT " . $table . "." . $column . ", " . $table2 . "." . $column2 ." 
                    FROM " . $table . " JOIN " . $table2 . " ON " . $table2 . ".`message_id` = " . $table . ".`message_id` 
                    WHERE " . $table2 . ".`processed`=0";
        }else{
            die("Connection failed: " . $this->dbLink->connect_error);
        }
        $answer = $this->dbLink->query($sql);
        return $answer->fetch_all(MYSQLI_ASSOC);
    }


    public function toTable(string $table, array $params):void
    {
        $columns = array_keys($params);
        $values = array_values($params);
        $columns = array_map(function($column) {
            return "`" . $column . "`";
        }, $columns);
        $values = array_map(function($value) {
            return "'" . $value . "'";
        }, $values);
        $columns = implode(',', $columns); //перевод в строку
        $values = implode(',', $values);
        $sql = "INSERT INTO " . $table . "(" . $columns . ") VALUES (" . $values . ")";
        $this->dbLink->query($sql);
    }
    public function changeProcessed(int $messageId, string $table):void
    {
        $sql = "UPDATE " . $table . " SET processed=1 WHERE message_id=?";
        $stmt = $this->dbLink->prepare($sql);
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
    }

    public function __destruct()
    {
        $this->dbLink->close();
    }
}