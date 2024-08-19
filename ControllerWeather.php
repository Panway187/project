<?php
namespace bot;
class ControllerWeather extends ParentController
{
    private WeatherModel $weatherModel;

    public function __construct()
    {
        parent::__construct();
        $this->weatherModel = new weatherModel();
        $this->processMessages();
        //parent::processMessages();
        $this->processRequests();
    }
    public function processRequests()
    {
        $requests = $this->weatherModel->fromResponses(
            'in_messages',
            'chat_id',
            'requests',
            'message_id, 
            ready_requests, 
            marker'
        );
        foreach ($requests as $value) {
            $marker = $value['marker'];
            $messageId = $value['message_id'];
            $answer = ['good', 'normal', 'bad'];
            $key = array_rand($answer, 1);
            $message = $answer[$key];
            if ($marker == 2) {
                $params = [
                    'message_id' => $value['message_id'],
                    'message' => $message,
                    'chat_id' => $value['chat_id'],
                ];
                $this->weatherModel->toTable('out_messages', $params);
                $this->weatherModel->changeProcessed($messageId, 'requests');
            }
        }


    }
}