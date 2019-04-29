<?php

namespace Kiwari;

use InvalidArgumentException;
use Kiwari\Handler\SendText;
use Kiwari\Handler\SendDocument;
use Kiwari\Handler\SendButton;
use Kiwari\Handler\Uploader;

class Kiwari
{
    private $accessToken;
    private $enableLog = false;
    private $decodedMessage;

    public function __construct(string $accessToken = null) 
    {
        if ($accessToken == null) {
            throw new InvalidArgumentException("Please setup ACCESS_TOKEN first");
        }

        $this->accessToken = $accessToken;
    }
    
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function enableLog(bool $enableLog)
    {
        $this->enableLog = $enableLog;
    }

    public function isEnableLog()
    {
        return $this->enableLog;
    }

    public function run()
    {
        $rawData = file_get_contents('php://input');

        $this->decodedMessage = json_decode($rawData, true);
        $this->writeLog($rawData);
    }

    private function writeLog($rawData, $logFilename = 'kiwari-bot')
    {
        if ($this->enableLog) {
            $tmpPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'logs';
            if (!file_exists($tmpPath)) {
                mkdir($tmpPath);
            }
            $tmpFile = $tmpPath . DIRECTORY_SEPARATOR . $logFilename . '.log';
            file_put_contents($tmpFile, '[' . date('Y-m-d H:i:s') . '] ' . $rawData . "\n", FILE_APPEND);
        }
    }

    public function getSender()
    {
        return $this->decodedMessage['from'];
    }

    public function getMyAccount()
    {
        return $this->decodedMessage['my_account'];
    }

    public function getChatRoom()
    {
        return $this->decodedMessage['chat_room'];
    }

    public function getMessage()
    {
        return $this->decodedMessage['message'];
    }

    public function sendButton(int $roomId, string $text = 'no text', array $btns = [])
    {
        if ($roomId < 1) {
            throw new InvalidArgumentException("ROOM_ID can't be 0 [zero]");
        }

        $response = SendButton::request($this->getAccessToken(), $roomId, $text, $btns);
        
        $this->writeLog(json_encode($response), 'send-button');
        
        return $response;
    }

    public function sendCard()
    {

    }

    public function sendCarousel()
    {

    }

    public function sendCustom()
    {

    }

    public function sendDocument(int $roomId, $fileUrl, $caption = null)
    {
        if ($roomId < 1) {
            throw new InvalidArgumentException("ROOM_ID can't be 0 [zero]");
        }

        $response =  SendDocument::request($this->getAccessToken(), $roomId, $fileUrl, $caption);

        $this->writeLog(json_encode($response), 'send-button');

        return $response;
    }

    public function sendImage()
    {

    }

    public function sendLocation()
    {

    }

    public function sendReply()
    {

    }

    public function sendText(int $roomId = 0, string $message = '')
    {
        if ($roomId < 1) {
            throw new InvalidArgumentException("ROOM_ID can't be 0 [zero]");
        }

        $response = SendText::request($this->getAccessToken(), $roomId, $message);

        $this->writeLog(json_encode($response), 'send-text');

        return $response;
    }

    public function upload($filePath)
    {
        $response = Uploader::upload($this->getAccessToken(), $filePath);

        $this->writeLog(json_encode($response), 'upload');

        return $response;
    }
}
