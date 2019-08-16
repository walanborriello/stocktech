<?php

namespace Walan\Theme\Block\Header;

use Magento\Catalog\Model\Category;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Catalog\Model\CategoryRepository as CategoryRepositoryMagento;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;

class Menu extends \Magento\Framework\View\Element\Template{

    protected $_template = "header/menu.phtml";

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoriesCollection;

    protected $_getconfig;

    protected $_helper;
    /**
     * @var View
     */
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var CategoryRepositoryMagento
     */
    private $categoryRepository;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepositoryInterface;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var array
     */
    private $allCategories = false;
    private $allCategoriesCache = false;

    /**
     * @param \Magento\Framework\View\Element\Template\Context
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CategoryRepositoryMagento $categoryRepository
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     * @param Session $session
     * @param array
     */
    //    public function __construct(
    //        \Magento\Framework\View\Element\Template\Context $context,
    //        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesCollectionFactory,
    //        \Walan\Theme\Helper\Data $helper,
    //        SearchCriteriaBuilder $searchCriteriaBuilder,
    //        CategoryRepositoryMagento $categoryRepository,
    //        CategoryRepositoryInterface $categoryRepositoryInterface,
    //        Session $session,
    //        array $data = []
    //    )
    //    {
    //        $this->_categoriesCollection = $categoriesCollectionFactory;
    //        $this->_helper = $helper;
    //        parent::__construct($context, $data);
    //        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    //        $this->categoryRepository = $categoryRepository;
    //        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    //        $this->session = $session;
    //        die("aaa");
    //    }


    public function __construct(Template\Context $context, Session $session, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoriesCollectionFactory, array $data = []){
        parent::__construct($context, $data);
        $this->session = $session;
        $this->_categoriesCollection = $categoriesCollectionFactory;
    }


    /**
     * retrieve rootCategories
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     */
    public function getRootCategories(){
        return $this->_categoriesCollection
            ->create()
            ->addFieldToSelect("name")
            ->addFieldToFilter('level', 2)
            ->addFieldToFilter('parent_id', $this->_storeManager->getStore()->getRootCategoryId())
            ->setPageSize(10)
            ->setOrder('category_position', 'ASC');
    }
    //
    //    /**
    //     * return child categories by a given categotry
    //     * @param  \Magento\Catalog\Model\Category
    //     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
    //     */
    //    public function getChildrenCategories(\Magento\Catalog\Model\Category $category)
    //    {
    //
    //        return $this->_categoriesCollection
    //            ->create()
    //            ->addFieldToSelect('name')
    //            ->addFieldToSelect('image')
    //            ->addFieldToFilter('parent_id', $category->getId())
    //            ->setOrder('category_position', 'ASC');
    //
    //    }
    //
    //
    //    /**
    //     * Returns the configuration by name in admin panel
    //     * for Menu
    //     *.
    //     * @param string $configuration
    //     * @return string|null
    //     */
    //    public function getConfigMenu($configuration)
    //    {
    //
    //        return $this->_helper->getConfig($configuration);
    //    }
    //
    //
    //    /**
    //     * Returns the image URL by name in admin panel
    //     * for Menu
    //     *
    //     *
    //     * @param $image
    //     * @return string
    //     */
    //    public function getConfigMenuImage($image)
    //    {
    //
    //        $imageName = $this->_helper->getConfig($image);
    //        if (isset($imageName) && ($imageName != "") && ($imageName !== null)) {
    //            $prefix = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
    //                . "theme" . DIRECTORY_SEPARATOR . "configuration" . DIRECTORY_SEPARATOR . "menu" . DIRECTORY_SEPARATOR;
    //            return $prefix . $imageName;
    //
    //        }
    //        return null;
    //    }
    //
    //
        public function getAllCategory()
        {
            list($allCategory, $cache) = []; //$this->view->getAllCategory();
            return ['asd' => 'asd'];
        }

    public function getAllCategoryByParam($children){
        return [];
    }


    /**
     * Check User logged
     * @return bool
     */
    public function checkLoggedIn(){
        return $this->session->isLoggedIn();
    }

}
