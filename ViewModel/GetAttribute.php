<?php

declare(strict_types=1);

namespace Vendor\Module\ViewModel;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Vendor\Module\Model\Constant;

/**
 * Class Get custom customer attribute 'Hobby'
 */
class GetAttribute implements ArgumentInterface
{
    /**
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        private Session $customerSession,
        private CustomerRepositoryInterface $customerRepository
    ) {
    }

    /**
     * Get attribute hobby from customer session
     *
     * @return string
     */
    public function getHobbyAttribute(): string
    {
        return $this->getCustomer()->getCustomAttribute(Constant::HOBBY_ATTRIBUTE)->getValue();
    }

    /**
     * Check Is exist attribute 'hobby'
     *
     * @return bool
     */
    public function isHobbyExist(): bool
    {
        if (!$this->getCustomer()) {
            return false;
        }

        return (bool)$this->getCustomer()->getCustomAttribute(Constant::HOBBY_ATTRIBUTE);
    }

    /**
     * Get Current customer by session
     *
     * @return null|CustomerInterface
     */
    private function getCustomer(): ?CustomerInterface
    {
        if ($this->customerSession->getCustomer() && $this->customerSession->getCustomer()->getId() !== 0) {
            try {
                return $this->customerRepository->getById($this->customerSession->getCustomer()->getId());
            } catch (LocalizedException) {
                return null;
            }
        }

        return null;
    }
}
