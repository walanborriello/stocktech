<?php

namespace Walan\Theme\Block\Header;


class DirectLink extends \Magento\Framework\View\Element\Html\Link{
    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        return '<a ' . $this->getLinkAttributes() . ' >' . $this->escapeHtml($this->getLabel()) . '</a>';
    }
}