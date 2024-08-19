<?php
namespace bot;
//use bot\ParentModel;

abstract class ParentController
{
    private ParentModel $ParentModel;

    public function __construct()
    {
        $this->ParentModel = new ParentModel();

    }

    public function processMessages()
    {
        $messages = $this->ParentModel->fromTable('in_messages', 'message_id, chat_id, message');
        foreach ($messages as $value) {
            $messageId = $value['message_id'];
            //$chatId[] = $value['chat_id'];
            $message = $value['message'];
            if ($message == "What's the weather like?") {
                $marker = 2;
            } else {
                $marker = 1;
            }
            $params = [
                'message_id' => $messageId,
                'ready_requests' => addslashes($message),
                'marker' => $marker
            ];
            $this->ParentModel->toTable('requests', $params);
            $this->ParentModel->changeProcessed($messageId, 'in_messages');
        }
    }
}