<?php
require_once 'Mage/Customer/controllers/AccountController.php';
class Ip_CancelOrders_Customer_AccountController extends Mage_Customer_AccountController
{


    public function cancelorderAction()
    {
        $order_id = $this->getRequest()->getParam('order');
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order')->load($order_id);
        if($order->getCustomerId() == $this->_getSession()->getCustomerId()){
            if($order->canCancel()){
                $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
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


}