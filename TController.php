<?php
namespace bot;
use bot\ParentController;
use bot\TModel;
class TController extends ParentController
{
    private \bot\TModel $TModel;
    public function __construct()
    {
        $this->TModel = new TModel();
        $this->processMessages();
        $this->processResponses();

    }



    public function processResponses()
    {
        $response = $this->TModel->fromTable('in_messages', 'chat_id', 'responses', 'message_id`, `response');
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