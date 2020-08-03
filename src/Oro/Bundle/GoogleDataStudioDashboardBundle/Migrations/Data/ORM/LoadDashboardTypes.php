<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Migrations\Data\ORM;

use Oro\Bundle\EntityExtendBundle\Migration\Fixture\AbstractEnumFixture;
use Oro\Bundle\GoogleDataStudioDashboardBundle\Model\DashboardEnums;

class LoadDashboardTypes extends AbstractEnumFixture
{
    /**
     * {@inheritdoc}
     */
    protected function getData(): array
    {
        return DashboardEnums::DASHBOARD_TYPES;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultValue(): ?string
    {
        return DashboardEnums::TYPE_WIDGETS;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEnumCode(): string
    {
        return DashboardEnums::DASHBOARD_TYPE_CODE;
    }
}
