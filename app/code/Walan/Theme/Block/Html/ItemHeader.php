<?php
namespace Walan\Theme\Block\Html;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;

class ItemHeader extends \Magento\Framework\View\Element\Template
{

    protected $_session;

    public function __construct(
        Template\Context $context,
        \Magento\Customer\Model\Session $session,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->_session = $session;
    }


    public function isLoggedIn() {
        return $this->_session->isLoggedIn();
    }
}