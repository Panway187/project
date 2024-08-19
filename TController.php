<?php
namespace bot;
class TController extends ParentController
{
    private TModel $TModel;
    public function __construct()
    {
        parent::__construct();
        $this->TModel = new TModel();
        parent::processMessages();
        //$this->processMessages();
        $this->processResponses();

    }

    public function processResponses()
    {
        $response = $this->TModel->fromResponses(
            'in_messages',
            'chat_id',
            'responses',
            'message_id`, 
            `response'
        );
        foreach ($response as  $value) {
            $messageId = $value['message_id'];
            $chatId = $value['chat_id'];
            $message = $value['response'];   //и обработка JSON от API
            $params =[
                '`message_id`' => $messageId,
                '`message`' => $message,
                '`chat_id`' => $chatId
            ];
            $this->TModel->toTable('out_messages', $params);
            $this->TModel->changeProcessed($messageId, 'responses');
        }
    }
}