<?php

class SMS {

    //declare protected values
    //provide nedeed daya here
    protected $API_USERNAME = 'your API user name'; //user name from onewaysms api

    protected $API_PASSWORD = 'your API password'; //api password

    protected $sender = ''; // sender name

    protected $GW_URL = 'http://gateway80.onewaysms.ph/api2.aspx?'; //gateway 


    /**
    * func : sample code given by the api provider
    * @return json message and code [0 = fail, 1 = success];
    */
    private function gw_send_sms($sms_to, $message)
    {

        $query_string = "apiusername=" . $this->API_USERNAME . "&apipassword=" . $this->API_PASSWORD;
        $query_string .= "&senderid=" . rawurlencode($this->sender) . "&mobileno=" . rawurlencode($sms_to);
        $query_string .= "&message=" . rawurlencode(stripslashes($message)) . "&languagetype=1";

        //concatinate url and the query string
        $url = "{$this->GW_URL}{$query_string}";
        $fd = @implode('', file($url));

        if (!$fd) {
            return [
                'message' => 'no contact with gateway',
                'code'    => 0
            ];
        }

        if ($fd < 0) {
            return [
                'message' => "Please refer to API on Error : {$fd}",
                'code'    => 0
            ];
        }

        return [
            'message' => "Success with MT ID : {$fd}",
            'code'    => 1
        ];
    }

     /**
     Function: Send SMS
     * Description: this is the one to use in controllers to accept input data
     * and send sms
     * @param contact_number : recepient number
     * @param message : text or the message body of the sms
     * @return array contain response code and message from api
     */
    public function sendSMS($contact_number, $message)
    {
        return $this->gw_send_sms($contact_number, $message);
    }

}