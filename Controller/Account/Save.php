<?php

namespace Vendor\Module\Controller\Account;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use \Magento\Framework\App\Action\Context;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        private Context $context,
        private Session $customerSession,
        private CustomerRepositoryInterface $customerRepository,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();
        try {
            $customerId = $this->customerSession->getCustomer()->getId();
            $customer = $this->customerRepository->getById($customerId);
            $customer->setCustomAttribute('hobby', $postData['hobby']);
            $this->customerRepository->save($customer);
            $this->messageManager->addSuccessMessage(__("Save Data"));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('please try again. Form Not Submit'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
