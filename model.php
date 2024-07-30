<?php
namespace bot;
use mysqli;
class TModel
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

    public function fromTable(string $table): array
    {
        if ($table === 'in_messages'){
            $sql = "SELECT  message_id, chat_id, message FROM in_messages WHERE processed=0";
        }elseif ($table === 'responses'){
            $sql = "SELECT `in_messages`.`chat_id`, `responses`.`message_id`, `response` 
                    FROM `in_messages` JOIN `responses` ON `responses`.`message_id` = `in_messages`.`message_id` 
                    WHERE `responses`.`processed`=0";
        }else{
            throw new InvalidArgumentException("Unknown table: $table");
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