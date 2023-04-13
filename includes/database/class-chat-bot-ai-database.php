<?php

class ChatBotDatabase
{

    protected $wpdb;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb =  $wpdb;
    }



    public function getAll()
    {

        $res = $this->wpdb->get_results("select * from " . $this->wpdb->prefix . "ai_chat_bot");

        $ress = [];
        foreach ($res as $key => $value) {
            $ress[$value->meta_key] = $value->meta_value;
        }
        return $res ?  [
            "code" => 200,
            "data" => $ress
        ] :
            [
                "code" => 400,
                "data" => null
            ];
    }

    public function getValue($meta_key)
    {

        $res = $this->wpdb->get_results("select * from " . $this->wpdb->prefix . "ai_chat_bot  where meta_key='" . $meta_key . "'");
        return $res ?  [
            "code" => 200,
            "data" => $res[0]
        ] :
            [
                "code" => 400,
                "data" => null
            ];
    }


    public function getValues($meta_key)
    {

        $res = $this->wpdb->get_results("select * from " . $this->wpdb->prefix . "ai_chat_bot  where meta_key='" . $meta_key . "'");

        return $res ?  [
            "code" => 200,
            "data" => $res
        ] :
            [
                "code" => 400,
                "data" => []
            ];
    }


    function checkExist($meta_key)
    {
        global $wpdb;
        $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}ai_chat_bot  WHERE meta_key = '{$meta_key}' ");
        return $rowcount;
    }


    function insertOrUpdate($meta_key, $meta_value)
    {
        if ($this->checkExist($meta_key) > 0) {
            // UDPATE
            $this->wpdb->update(
                $this->wpdb->prefix . "ai_chat_bot",
                [
                    "meta_value" => $meta_value
                ],
                [
                    "meta_key" => $meta_key
                ]
            );
        } else {
            // INSERT
            $this->wpdb->insert(
                $this->wpdb->prefix . "ai_chat_bot",
                [
                    "meta_value" => $meta_value,
                    "meta_key" => $meta_key
                ]
            );
        }
    }
}
