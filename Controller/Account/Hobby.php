<?php

declare(strict_types=1);

namespace Vendor\Module\Controller\Account;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

/**
 * Class for rendering Hobby edit page
 */
class Hobby extends AbstractAccount
{
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        private Context $context,
        private PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Rendering hobby page
     *
     * @return Page
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Hobby'));
        return $resultPage;
    }
}
