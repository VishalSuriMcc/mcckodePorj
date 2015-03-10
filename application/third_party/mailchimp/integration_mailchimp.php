<?php

/**
 * testing temp id = 0e2bcb885f
 * web_id = 66405
 */

/* main file includes */
require 'Mailchimp.php';

class integratedmailchip extends Mailchimp{
    public $gen_listId = null;
    private $mailChipRegisterKey = '41ad31a35efb1e1c51bc63d492828836-us10';
    private $generalListName = 'CS Creation Station';
    Private $gen_list_detail = array();    
    
    public function __construct() {
        try{
            parent::__construct($this->mailChipRegisterKey);
            $this->getAllList();            
            return $this;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    
    /**
     * string apikey, 
     * string id, 
     * struct email, 
     * struct merge_vars, 
     * string email_type, 
     * bool double_optin, 
     * bool update_existing, 
     * bool replace_interests, 
     * bool send_welcome
     */
    public function subscribe($email = null){
        try{
            if(!empty($email)){
                $compGenlist = $this->call('lists/subscribe', array('apikey' => $this->mailChipRegisterKey,
                                                               'id' => $this->gen_listId,
                                                                'email' => array('email' => $email)
                                                        ));
            }else{
                $message_str = 'Email can never by empty';
                throw new Exception($message_str);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function getAllList(){
        try{
            $compGenlist = $this->call('lists/list', array('apikey' => $this->mailChipRegisterKey,
                                                    'list_name' => $this->generalListName
                                                    ));
            foreach($compGenlist['data'] as $listdet){
                $this->gen_list_detail[$listdet['name']] = $listdet;
            }
            $this->gen_listId =  $this->gen_list_detail[$this->generalListName]['id'];            
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    
    public function getCampaignsDet(){
        try{
            return $this->call('campaigns/list', array('apikey' => $this->mailChipRegisterKey));
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
    
    public function sendTestingCampaign(){
        try{
            return $this->call('campaigns/send-test', 
                                    array(  'apikey' => $this->mailChipRegisterKey,
                                            'cid' => '0e2bcb885f',
                                            'test_emails' => array('vishalsuri.mcc@gmail.com'),
                                    )
                                );
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}