<?php
require_once 'Mage/Customer/controllers/AccountController.php';
class Ip_CancelOrders_Customer_AccountController extends Mage_Customer_AccountController
{

    const XML_PATH_EMAIL_CANCEL_TEMPLATE               = 'sales_email/order/cancel_template';
    const XML_PATH_EMAIL_CANCEL_BCC                    = 'sales_email/order/cancel_bcc';

    public function cancelorderAction()
    {
        $order_id = $this->getRequest()->getParam('order');
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order')->load($order_id);
        if($order->getCustomerId() == $this->_getSession()->getCustomerId()){
            if($order->canCancel()){
                $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
                $this->sendTransactional($order);
                $this->_getSession()->addSuccess('Your order has been canceled.');
            } else {
                $this->_getSession()->addError('This order can not be canceled.');
            }
        } else {
            $this->_getSession()->addError('You do not have permission to edit this order.');
        }
        $this->_redirect('*/*/');
        return;
    }


    protected function sendTransactional(Mage_Sales_Model_Order $order)
    {
        $storeId = $this->getStoreId();
        $mailer = Mage::getModel('core/email_template_mailer');
        /** @var Mage_Core_Model_Email_Info $emailInfo */
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($order->getCustomerEmail(), $order->getCustomerName());
        foreach($this->_getEmails() as $email){
            $emailInfo->addBcc($email);
        }
        $mailer->addEmailInfo($emailInfo);
        $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_CANCEL_TEMPLATE, $storeId);
        $mailer->setSender(Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
                'order'        => $order
            )
        );
        $mailer->send();
    }

    protected function _getEmails()
    {
        $data = Mage::getStoreConfig(self::XML_PATH_EMAIL_CANCEL_BCC, $this->getStoreId());
        if (!empty($data)) {
            return explode(',', $data);
        }
        return array();
    }

    public function getStoreId()
    {
        return Mage::app()->getStore()->getId();
    }

}