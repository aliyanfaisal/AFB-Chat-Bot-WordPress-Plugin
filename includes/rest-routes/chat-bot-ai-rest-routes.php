<?php



add_action('rest_api_init', function () {
    register_rest_route('ai_chat_bot', '/get-matched-data', array(
        'methods' => 'POST',
        'callback' =>  'ai_chat_bot_match_msgs',
        'permission_callback' => ''
    ));


    register_rest_route('ai_chat_bot', '/send-email-user', array(
        'methods' => 'POST',
        'callback' =>  'ai_chat_bot_send_email_user',
        'permission_callback' => ''
    ));

    register_rest_route('ai_chat_bot', '/send-email-admin', array(
        'methods' => 'POST',
        'callback' =>  'ai_chat_bot_send_email_admin',
        'permission_callback' => ''
    ));


    register_rest_route('ai_chat_bot', '/send-to-whatsapp', array(
        'methods' => 'POST',
        'callback' =>  'ai_chat_bot_send_to_whatsapp',
        'permission_callback' => ''
    ));


    register_rest_route('ai_chat_bot', '/send-feedback', array(
        'methods' => 'POST',
        'callback' =>  'ai_chat_bot_send_feedback',
        'permission_callback' => ''
    ));
});



function ai_chat_bot_match_msgs($req)
{
    $msg = $_POST['msg'];;
    try {

        // INITTIATE DATABASE
        $chatBotDB = getChatBotDB();

        $custom_msgs = $chatBotDB->getValue("chatbot_custom_messages");
        $custom_msgs = $custom_msgs['code'] == 200 ? $custom_msgs['data']->meta_value : "";
        $custom_msgs = unserialize($custom_msgs);
        if ($custom_msgs) {
            $matchedMsgs = [];
            foreach ($custom_msgs as $msgx) {
                $tags = str_replace(", ", ",", strtolower($msgx['tags']));

                $tags = str_replace(" ,", ",", $tags);

                $str1 = explode(" ", strtolower($msg));
                $str2 = explode(",", $tags);
                $diffArr = str_compare($str1, $str2);
                // echo json_encode([sizeof($str1)]); exit;
                // echo json_encode($diffArr); exit;
                if (sizeof($diffArr) < sizeof($str1)) {
                    $matchedMsgs[] = $msgx['message'];
                }
            }
        } else {
            echo json_encode([]);
            exit;
        }
        // echo json_encode([$custom_msgs]); exit;

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    echo json_encode($matchedMsgs);
    exit;
}



function str_compare($str1Arr, $str2Arr)
{
    $diff = array_diff($str1Arr, $str2Arr);
    return ($diff);
}




function ai_chat_bot_send_email_user($req)
{
    $req = $_POST;

    $msg = $req['msgs'];

    // //     $req['msgs']=json_decode($req['msgs']);
    //     foreach ($req['msgs'] as $key => $data) {
    //         $msg .= "<b>" . str_contains(strtolower($key), "user") ? "You" : "Bot" . " </b>: {$data} <br>";
    //     }

    $to = $req['send_to'];
    $subject = 'Your Messages With Chatbot';
    $body = 'List of Your messages Sent To You On Your Request. Thank You <br><br><hr>' . $msg;

    $headers[] = 'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        echo json_encode(['Sent SuccessFully']);
    } else {
        echo json_encode(['Email Sent Failed']);
    }
}



function ai_chat_bot_send_email_admin($req)
{
    $req = $_POST;
    

    $userData = $req['user_data'];
    $msg = $req['msgs'];


    $to = $req['send_to'];
    $subject = $req['subject']?? 'User\'s Messages With Chatbot';
    $body = 'User Information: <br> ' . $userData . '<br> <hr> List of Your messages Sent <br><hr>' . $msg;

    $headers[] = 'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        echo json_encode(['Sent SuccessFully']);
    } else {
        echo json_encode(['Email Sent Failed']);
    }
}




function ai_chat_bot_send_feedback(){
    $req=$_POST;

    $userData = $req['user_data'];
    $msg = $req['msgs'];


    $to = $req['send_to'];
    $subject = 'User\'s Messages With Chatbot';
    $body = 'User Information: <br> ' . $userData . '<br> <hr> List of Your messages Sent <br><hr>' . $msg;

    $headers[] = 'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        echo json_encode(['Sent SuccessFully']);
    } else {
        echo json_encode(['Email Sent Failed']);
    }
}