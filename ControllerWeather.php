<?php
namespace bot;
use bot\ParentController;
use bot\WeatherModel;
class ControllerWeather extends ParentController
{
    private \bot\weatherModel $weatherModel;

    public function __construct()
    {
        $this->weatherModel = new weatherModel();
        $this->processMessages();
        $this->processRequests();
    }

    public function processRequests()
    {
        $requests = $this->weatherModel->fromTable('in_messages', 'chat_id', 'requests', 'message_id, ready_requests, marker');
        foreach ($requests as $value) {
            $marker = $value['marker'];
            if ($marker == 2) {
                $messageId = $value['message_id'];
                $chatId = $value['chat_id'];
                $ready_requests = $value['ready_requests'];
                $params = [
                    'message_id' => $messageId,
                    'message' => $ready_requests,
                    'chatId' => $chatId,
                ];
                $this->weatherModel->toTable('out_messages', $params);
                $this->weatherModel->changeProcessed($messageId, 'requests');
            }
        }


    }
}