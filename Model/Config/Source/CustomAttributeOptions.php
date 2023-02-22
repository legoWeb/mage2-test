<?php

declare(strict_types=1);

namespace Vendor\Module\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class with options for Customer attribute called Hobby Attribute
 */
class CustomAttributeOptions extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions(): array
    {
        return [
            ['value' => '', 'label' => __('Choose option')],
            ['value' => 'yoga', 'label' => __('Yoga')],
            ['value' => 'traveling', 'label' => __('Traveling')],
            ['value' => 'hiking', 'label' => __('Hiking')],
        ];
    }
}
