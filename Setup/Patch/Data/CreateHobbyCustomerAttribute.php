<?php

declare(strict_types=1);

namespace Vendor\Module\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;
use Vendor\Module\Model\Constant;
use Vendor\Module\Model\Config\Source\CustomAttributeOptions;

/**
 * Added Hobby customer attribute
 */
class CreateHobbyCustomerAttribute implements DataPatchInterface
{
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private CustomerSetupFactory $customerSetupFactory,
        private AttributeSetFactory $attributeSetFactory,
        private LoggerInterface $logger
    ) {
    }

    /**
     * Adding customer attribute
     *
     * @return void
     */
    public function apply(): void
    {
        try {
            $this->moduleDataSetup->getConnection()->startSetup();
            /** @var CustomerSetup $customerSetup */
            $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
            $customerEavConfig = $customerSetup->getEavConfig();
            $customerEntity = $customerEavConfig->getEntityType(Customer::ENTITY);
            $attributeSetId = (int)$customerEntity->getDefaultAttributeSetId();
            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = (int)$attributeSet->getDefaultGroupId($attributeSetId);
            $customerSetup->addAttribute(
                Customer::ENTITY,
                Constant::HOBBY_ATTRIBUTE,
                [
                    'label' => 'Hobby',
                    'type' => 'varchar',
                    'input' => 'select',
                    'source' => CustomAttributeOptions::class,
                    'required' => false,
                    'visible' => true,
                    'default' => '',
                    'user_defined' => true,
                    'position' => 250,
                    'system' => false,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );

            $customerAttribute = $customerEavConfig->getAttribute(
                Customer::ENTITY,
                Constant::HOBBY_ATTRIBUTE
            );
            $customerAttribute->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer']
            ]);

            /** Use deprecated save method, because AttributeRepository doesn't save used_in_forms value */
            $customerAttribute->save();

            $this->moduleDataSetup->getConnection()->endSetup();
        } catch (LocalizedException $localizedException) {
            $this->logger->error($localizedException->getMessage(), $localizedException->getParameters());
        }
    }

    /**
     * Reverting the patch
     *
     * @return void
     */
    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->removeAttribute(Customer::ENTITY, Constant::HOBBY_ATTRIBUTE);
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get aliases
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Get patch dependencies
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
