<?php

class Ip_CancelOrders_Block_Sales_Order_Info_Buttons extends Mage_Sales_Block_Order_Info_Buttons
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('cancelorders/sales/order/info/buttons.phtml');
    }

}