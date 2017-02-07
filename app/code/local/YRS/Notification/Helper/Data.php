<?php

class YRS_Notification_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function EnableDisable()
    {
       return Mage::getStoreConfig("sales/notification_group/notification_enable");  
    }
	public function getnotificationEmails()
    {
       $data= Mage::getStoreConfig("sales/notification_group/notification_email");  
    }
}