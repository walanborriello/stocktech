<?php

namespace Walan\Theme\Helper;

use Magento\Sales\ViewModel\Customer\AddressFormatter;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * General Helper for Theme Reply
 *
 *
 * @package Reply\Theme\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Base path for config of Vittoria configuration.
     * @const CONFIGURATION
     */
    const CONFIGURATION = "vittoria_base/";
    const CREATE = 'create';
    const NEWSLETTER = 'newsletters';
    const SIGNINCUSTOMER = 'signincustomers';

    protected $_logger;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $_scopeConfig
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $_storeManager
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var ImageModel
     */
    protected $_imageModel;
    protected $request;


    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder,
        AddressFormatter $addressFormatter,
        \Magento\Framework\App\Request\Http $request
    )
    {

        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
        $this->addressFormatter = $addressFormatter;
        $this->request = $request;

    }


    /**
     * getConfig
     *
     * Gets the configuration needed for Vittoria Menu
     * Returns it if exists, null if not
     *
     * @param $config
     * @return mixed|null
     */
    public function getConfig($config)
    {
        return $this->_scopeConfig->getValue(self::CONFIGURATION . $config, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }


    public function getWebsites()
    {
        return $this->_storeManager->getWebsites();
    }

    public function getWebsiteId()
    {

        return $this->_storeManager->getStore()->getWebsiteId();
    }

    public function getSuggestedDimensions()
    {
        return array(
            0 => array("WKOR", "1020*2080"),
            1 => array("Other", "2033*2393"),
            2 => array("", ""),
            3 => array("Basic Information About Background Video", ":"),
            4 => array("", ""),
            5 => array("- ", "Il file video deve essere un file con estensione .mp4 e con codifica h264;"),
            6 => array("- ", "Evitare video molto “movimentati” in modo da non disturbare troppo la lettura degli elementi grafici e testuali in overlay ;"),
            7 => array("- ", "Il file deve avere una dimensione massima di 2MB ;")
        );
    }

    public function getSuggestedChars()
    {


        return [
            ['Homepage title slider' => '83'],
            ['Homepage subtitle slider' => '85'],
            ['Button label hover video' => '15'],
            ['Vittoria banner' => '276'],
            ['Press Description' => '181']
        ];
    }

    public function getReviewsLink()
    {
        return $this->_urlBuilder->getUrl('review/review/index');
    }


    public function getVisibilityHelpFaq(){
        $return = true;
        $action = $this->request->getActionName();
        $controller = $this->request->getControllerName();
        $module = $this->request->getModuleName();
        if($action == self::CREATE && $controller == self::NEWSLETTER && $module == self::SIGNINCUSTOMER){
            $return = false;
        }
        return $return;
    }
}