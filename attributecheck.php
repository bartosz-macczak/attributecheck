<?php
class attributecheck extends Module
{
    public function __construct()
    {
        $this->name = 'attributecheck';
        $this->tab = 'content_management';
        $this->version = '0.1';
        $this->author = 'Bartosz Ma�czak';
        $this->displayName = 'Find zero-prices attributes.';
        $this->description = 'With this module, you will find zero-prices attributes';
        $this->bootstrap = true;
        parent::__construct();
    }

    public function install()
    {
        parent::install();
        $this->installDB();
        return true;
    }
    
    public function uninstall()
    {
        parent::uninstall();
        $this->uninstallDB();
        return true;
    }
    
    public function installDB()
    {
	return Db::getInstance()->execute('
	CREATE TABLE `'._DB_PREFIX_.'ATTRIBUTE_CHECK` (
	`id_attribute_check` int(10) NOT NULL auto_increment,
	`id_product` numeric(9,2),
	`id_attribute_impact` numeric(9,2),
	PRIMARY KEY( `id_attribute_check` )
	) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');
    }

    public function uninstallDB()
    {
	return Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'ATTRIBUTE_CHECK`;');
    }

    
    public function processConfiguration()
    {
        if (Tools::isSubmit('mymod_pc_form'))
        {
            $enable_option = Tools::getValue('enable_option');
            Configuration::updateValue('MYMOD_OPTION', $enable_option);
            $this->context->smarty->assign('confirmation', 'ok');
        }
    }

    function testAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }

    public function getContent()
    {
        $this->processConfiguration();
        $this->assignConfiguration();
        $this->downData();
        return $this->display(__FILE__, 'getContent.tpl');
    }

    public function assignConfiguration()
    {
        $enable_option = Configuration::get('MYMOD_OPTION');
        $this->context->smarty->assign('enable_option', $enable_option);
    }

    public function downData()
    {
        $attribPrice = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'attribute_impact');
        $this->context->smarty->assign('attribPrice', $attribPrice);
        $basePrice = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'product');
        $this->context->smarty->assign('base', $basePrice);
        foreach ($attribPrice as $base)
        {
            foreach ($attribPrice as $attr)
            {
                if($attr['id_product'] == $base['id_product'])
                {
                   $this->checkZero($base['price'], $attr['price'], $base['id_product'], $attr['id_attribute_impact']);
                }
            }
        }
    }
    
    public function checkZero($base, $attr, $base_id, $attr_id)
    {
        $price=$base+$attr;
        if($price == 0)
            {
                Db::getInstance()->insert('attribute_check', array(
                    'id_product' => (int)$base_id,
                    'id_attribute_impact' => (int)$attr_id,
                ));
            }
    }

    
    
}
?>