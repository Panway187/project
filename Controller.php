<?php
namespace bot;
use bot\TModel;
class RequestController
{
    private \bot\TModel $TModel;
    public function __construct()
    {
        $this->TModel = new TModel();
        $this->processMessages();
        $this->processResponses();

    }

    public function processMessages()
    {
        $messages = $this->TModel->fromTable('in_messages');
        foreach ($messages as  $value) {
            $messageId = $value['message_id'];
            //$chatId[] = $value['chat_id'];
            $message = json_encode($value['message']);
            $params = [
                'message_id' => $messageId,
                'ready_requests' => $message
            ];
            $this->TModel->toTable('requests', $params);
            $this->TModel->changeProcessed($messageId, 'in_messages');
        }
    }

    public function processResponses()
    {
        $response = $this->TModel->fromTable('responses');
        foreach ($response as  $value) {
            $messageId = $value['message_id'];
            $chatId = $value['chat_id'];
            $message = $value['response'];   //и обработка JSON от API
            $params =[
                'message_id' => $messageId,
                'message' => $message,
                'chatId' => $chatId
            ];
            $this->TModel->toTable('out_messages', $params);
            $this->TModel->changeProcessed($messageId, 'responses');
        }
    }
}