<?php

namespace Kiwari\Handler;

class SendCarousel
{
    public static function request($accessToken, int $roomId, string $message)
    {
        return Request::post(Url::POST_MESSAGE, [
            'Accept' => 'application/json'
        ], Body::form([
            'access_token' => $accessToken,
            'type' => 'carousel',
            'topic_id' => $roomId,
            'comment' => $message,
            // 'payload' => 
        ]));
    }
}
// # carousel
// {
//     "cards": [
//         {
//             "image": "http://url.com/gambar.jpg",
//             "title": "Atasan Blouse Tunik Wanita Baju Muslim Worie Longtop",
//             "description": "Oleh sippnshop\n96% (666 feedback)\nRp 49.000.00,-\nBUY 2 GET 1 FREE!!!",
//             "default_action": {
//                 "type": "postback",
//                 "postback_text": "Load more", // required only when type is postback
//                 "payload": {
//                     "url": "http://url.com/baju?id=123&track_from_chat_room=123",
//                     "method": "get",
//                     "payload": null
//                 }
//             },
//             "buttons": [
//                 {
//                     "label": "button1",
//                     "type": "postback",
//                     "postback_text": "Load more",
//                     "payload": {
//                         "url": "http://somewhere.com/button1",
//                         "method": "get",
//                         "payload": null
//                     }
//                 },
//                 {
//                     "label": "button2",
//                     "type": "link",
//                     "payload": {
//                         "method": "get", 
//                         "url": "http://somewhere.com/button2?id=123"
//                     }
//                 }
//             ]
//         }
//     ]
// }