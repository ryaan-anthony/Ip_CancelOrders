<?php

class Ip_CancelOrders_Block_Sales_Order_History extends Mage_Sales_Block_Order_History
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('cancelorders/sales/order/history.phtml');
    }

}