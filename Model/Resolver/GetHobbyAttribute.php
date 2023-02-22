<?php

declare(strict_types=1);

namespace Vendor\Module\Model\Resolver;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Vendor\Module\Model\Constant;

/**
 * Class resolver GraphQl
 */
class GetHobbyAttribute implements ResolverInterface
{
    /**
     * Resolver for GraphQl query
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     *
     * @return array|null
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /** @var CustomerInterface $customer */
        $customer = $value['model'];

        /* Get customer custom attribute value */
        if ($customer->getCustomAttribute(Constant::HOBBY_ATTRIBUTE)) {
            $customerAttributeVal = $customer->getCustomAttribute(Constant::HOBBY_ATTRIBUTE)->getValue();
        } else {
            $customerAttributeVal = null;
        }

        return $customerAttributeVal;
    }
}
