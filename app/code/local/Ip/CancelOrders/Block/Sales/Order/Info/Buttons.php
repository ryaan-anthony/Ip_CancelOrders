<?php

class Ip_CancelOrders_Block_Sales_Order_Info_Buttons extends Mage_Sales_Block_Order_Info_Buttons
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('cancelorders/sales/order/info/buttons.phtml');
    }

    public function getCancelUrl(Mage_Sales_Model_Order $order)
    {
        return Mage::getUrl('customer/account/cancelorder', array('order' => $order->getId()));
    }

    public function areYouSure()
    {
        return addslashes(Mage::getStoreConfig('sales/cancellations/are_you_sure'));
    }

}