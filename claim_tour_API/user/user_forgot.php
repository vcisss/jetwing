<?php 
require_once(__DIR__ .'/../query/query.php');
require_once(__DIR__ .'/../base/base.php');
require_once(__DIR__ .'/../tools/phpMailer.php');

class user_forgot extends base{

    // begin variable declaration
    protected $qry;
    private $mail;
    private $arr_forgot_pass    = array(
                                            'person_first_name',
                                            'business_name',
                                            'username_full'
                                        );
    protected $table_set = "";

    // variable for management attribute

    function __construct() 
    {
        $this->qry  = new query();
        $this->setup_table();

        $this->mail = new eXMail();
    }

    //get sender name for email
    private function getDataSender()
    {
        $dataArr    = array(
                                "username"  => "posmo.mobile@gmail.com",
                                "password"  => "Recom789",
                                "name"      => "no-reply@posmo.co.id - POSMO"
                            );
        return $dataArr;
    }

    //get email template from database email_template
    private function getEmailTemplate($id=0)
    {
        $text_query = "SELECT subject_mail subject, body_mail body FROM `pos_simple_register`.`email_template` WHERE id = ? ";
        $json       = array($id);
        return $this->qry->select_query($text_query,$json);
    }

    //process body email dynamic
    private function processBodyEmailDynamic($arr_tmp=array(),$emailTemplate=array(),$data=array())
    {
        foreach ($arr_tmp as $val) {
            if(is_numeric($data[$val]))
                $value_data = number_format($data[$val]);
            else
                $value_data = $data[$val];

            $emailTemplate[0]['body'] = str_replace("[".$val."]", $value_data, $emailTemplate[0]['body']);
        }

        return $emailTemplate;
    }

    private function searchDB($json=""){
        $data       = $json['data'][1];
        $json_db    = array("none");
        if (($pos = strpos($data, "@")) !== FALSE) { 
            $json_db = array(substr($data, $pos+1));
        }

        $table      = '`pos_simple_register`.`company_data`';
        $cond       = ' AND name = ?';
        $data       = 'db_name';

        $data_tmp   = $this->qry->select_all($table, $cond, $json_db, $data);

        if(count($data_tmp) == 0 || $data_tmp[0][$data] == ""){
            return 0;
        }
        else{
            return $data_tmp[0][$data];
        }
    }

    function forgot_password($json){
        $db_tmp = $this->searchDB($json);
        if($db_tmp === 0){
            return 0;
        }

        $json           = array($json['data'][0],$json['data'][1]);
        $emailTemplate  = $this->getEmailTemplate(2);
        $recipientData  = $this->qry->select_all("`".$db_tmp."`.`users`"," AND email = ? AND username = ? ",$json,
                                                "name person_first_name, username username_full,email");

        if(count($recipientData) == 0 || $recipientData[0]['email'] == ""){
            return 0;
        }

        $businessData   = $this->qry->select_all("`".$db_tmp."`.`preference`"," AND id = ? ",array('1'),"company");
        $recipientData[0]['business_name'] = $businessData[0]['company'];
        $senderData     = $this->getDataSender();
        $arr_tmp        = $this->arr_forgot_pass;

        $pass_val       = strtoupper(substr(md5(mt_rand(0,9999)),0,10));
        $emailTemplate[0]['body']   = str_replace("[new password]", $pass_val, $emailTemplate[0]['body']);

        $emailTemplate  = $this->processBodyEmailDynamic($arr_tmp,$emailTemplate,$recipientData[0]);
        $mailResult     = $this->mail->sendEmail($emailTemplate[0],$recipientData,$senderData,"forgot password",$db_tmp);

        if($mailResult[0]['result'] === 200){
            $this->afterSendSuccessForgot($json[1],$pass_val,$db_tmp);
            return 1;
        }
    }

    private function afterSendSuccessForgot($username="",$password="",$db_name="")
    {
        $query  = "update `". $db_name ."`.`users` set password = '$password' where username = '$username'";
        $this->qry->custQuery($query);
    }
}
?>