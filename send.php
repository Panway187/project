<?php
namespace bot;
class send
{
    private ParentModel $ParentModel;

    public function __construct()
    {
        $this->ParentModel = new ParentModel();

    }

    private function sendMessage():void
    {
        $messages = $this->ParentModel->fromTable('out_messages', 'message_id, chat_id, message');
        foreach ($messages as $value){
            $params = [
                'chat_id' => $value['chat_id'],
                'text'    => $value['chat_id']
            ];
            $messageId = $value['message_id'];
            file_get_contents('https://api.telegram.org/bot'.TOKEN.'/sendMessage?'.http_build_query($params));
            $this->ParentModel->changeProcessed($messageId, 'out_messages');
        }
    }

}
