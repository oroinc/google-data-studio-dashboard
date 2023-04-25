<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Migrations\Data\ORM;

use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardTypeFixture;
use Oro\Bundle\GoogleDataStudioDashboardBundle\DashboardType\GoogleDataStudoDashboardTypeConfigProvider;

class AddGoogleDataStudioDashboardType extends AbstractDashboardTypeFixture
{
    /**
     * {@inheritDoc}
     */
    protected function getDashboardTypeIdentifier(): string
    {
        return GoogleDataStudoDashboardTypeConfigProvider::TYPE_NAME;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDashboardTypeLabel(): string
    {
        return 'Google Data Studio';
    }
}
