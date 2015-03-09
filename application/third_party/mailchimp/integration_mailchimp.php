<?php

/* main file includes */
require 'Mailchimp.php';

class integratedmailchip extends Mailchimp{
            
    private $mailChipRegisterKey = '41ad31a35efb1e1c51bc63d492828836-us10';
    private $generalListName = 'CS Creation Station';
    Private $gen_list_detail = array();
    
    public function __construct() {                
        parent::__construct($this->mailChipRegisterKey);
        return $this;
    }
    
    public function getAllList(){
        try{
            $compGenlist = $this->call('lists/list', array('apikey' => $this->mailChipRegisterKey,
                                                    'list_name' => $this->generalListName
                                                    ));
            foreach($compGenlist['data'] as $listdet){
                $this->gen_list_detail[$listdet['name']] = $listdet;
            }
            return $this->gen_list_detail;
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
}