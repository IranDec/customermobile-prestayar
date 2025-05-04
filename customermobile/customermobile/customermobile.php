<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomerMobile extends Module
{
    public function __construct()
    {
        $this->name = 'customermobile';
        $this->version = '1.0.0';
        $this->author = 'Mohammad Babaei';
        $this->authorwebsite = 'https://adschi.com';
        $this->need_instance = 0;
        $this->ps_versions_compliant = ['1.7.8.11'];
        parent::__construct();
        $this->displayName = $this->l('Customer Mobile Module');
        $this->description = $this->l('Adds customer mobile number to psylogin_customers_mobile table when a new address is added.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionObjectAddressAddAfter');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookActionObjectAddressAddAfter($params)
    {
        if (isset($params['object']) && $params['object'] instanceof Address) {
            $address = $params['object'];
            $customer_id = (int)$address->id_customer;
            $mobile_number = pSQL($address->phone_mobile);

            // بررسی وجود شماره موبایل
            if (!empty($mobile_number)) {
                // بررسی وجود مشتری در جدول
                $sql = 'SELECT * FROM `'._DB_PREFIX_.'psylogin_customers_mobile` WHERE `mobile_id_customer` = '.(int)$customer_id;
                $existing = Db::getInstance()->getRow($sql);

                // اگر مشتری وجود نداشت، اطلاعات را اضافه کن
                if (!$existing) {
                    $data = array(
                        'mobile_id_customer' => $customer_id,
                        'mobile_number' => $mobile_number,
                        'mobile_valid' => 1,
                        'mobile_email' => '',
                        'mobile_created' => date('Y-m-d H:i:s'),
                        'mobile_updated' => date('Y-m-d H:i:s')
                    );
                    Db::getInstance()->insert('psylogin_customers_mobile', $data);
                }
            }
        }
    }
}