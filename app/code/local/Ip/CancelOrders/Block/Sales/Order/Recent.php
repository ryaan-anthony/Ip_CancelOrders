<?php

class Ip_CancelOrders_Block_Sales_Order_Recent extends Mage_Sales_Block_Order_Recent
{

    public function getCancelUrl(Mage_Sales_Model_Order $order)
    {
        return Mage::getUrl('customer/account/cancelorder', array('order' => $order->getId()));
    }

}