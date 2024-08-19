<?php
namespace bot;
use mysqli;
class ParentModel
{
    protected mysqli $dbLink;
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
    public function fromTable(string $table, string $column): array
    {
        $sql = "SELECT  " . $column . " FROM " . $table . " WHERE processed=0";
        $answer = $this->dbLink->query($sql);
        return $answer->fetch_all(MYSQLI_ASSOC);
    }

    public function fromResponses(string $table, string $column, string $table2, string $column2): array
    {
        $sql = "SELECT " . $table . "." . $column . ", " . $table2 . "." . $column2 ." 
                    FROM " . $table . " JOIN " . $table2 . " ON " . $table2 . ".`message_id` = " . $table . ".`message_id` 
                    WHERE " . $table2 . ".`processed`=0";
        $answer = $this->dbLink->query($sql);
        return $answer->fetch_all(MYSQLI_ASSOC);
    }

    public function toTable(string $table, array $params):void
    {
        $columns = array_keys($params);
        $columns = array_map(function($column) {
            return "`" . $column . "`";
        }, $columns);
        $columns = implode(',', $columns); //перевод в строку
        $values = array_values($params);
        $values = array_map(function($value) {
            return "'" . $value . "'";
        }, $values);
        $values = implode(',', $values);
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
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