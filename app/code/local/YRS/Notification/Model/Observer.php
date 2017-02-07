<?php
class YRS_Notification_Model_Observer {

    public function Admin_Notification($observer) {
		$check_enable=Mage::helper('notification')->EnableDisable();
		$notify_emails=Mage::helper('notification')->getnotificationEmails();
		
		$order = $observer->getEvent()->getOrder();
		if($order->getId() && $check_enable==true)
		{
			$order_id=$order->getIncrementId();
			$template_id = 'order_custom_notification';	
			$email_array=explode(',',$notify_emails);
			if(count($email_array)>1)
			{
				$array_email=$email_array;
			}else{
				$array_email=$notify_emails;
			}			
			$customer_name   = 'Recipient';
			
			$email_template  = Mage::getModel('core/email_template')->loadDefault($template_id);
			
			$custom_variable = 'has been placed successfully';
		
			$email_template_variables = array(
				'custom_variable' => $custom_variable,			
				'order_id' => $order_id			
			);		
			
			$sender_name = Mage::getStoreConfig(Mage_Core_Model_Store::XML_PATH_STORE_STORE_NAME);		
			$sender_email = Mage::getStoreConfig('trans_email/ident_general/email');
			$processedTemplate = $email_template->getProcessedTemplate($email_template_variables);

			$mail = Mage::getModel('core/email')
					 ->setToName($customer_name)
					 ->setToEmail($array_email)
					 ->setBody($processedTemplate)
					 ->setSubject('New Order Placed Notification')
					 ->setFromEmail($sender_email)
					 ->setFromName($sender_name)
					 ->setType('html');
					try{
						
						$mail->send();
						//Mage::getSingleton('core/session')->addSuccess("New Order Placed Successfully");	 
					 }
					 catch(Exception $error)
					 {
						Mage::getSingleton('core/session')->addError($error->getMessage());						 
						 //echo $error->getMessage();
						// return false;
					 }
		}
        
    }
	

}
?>