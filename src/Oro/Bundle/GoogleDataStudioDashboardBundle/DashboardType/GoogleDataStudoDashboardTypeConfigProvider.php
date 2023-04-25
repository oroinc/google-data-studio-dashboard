<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\DashboardType;

use Oro\Bundle\DashboardBundle\DashboardType\DashboardTypeConfigProviderInterface;
use Oro\Bundle\DashboardBundle\Entity\Dashboard;

class GoogleDataStudoDashboardTypeConfigProvider implements DashboardTypeConfigProviderInterface
{
    public const TYPE_NAME = 'google_data_studio';

    /**
     * {@inheritDoc}
     */
    public function isSupported(?string $dashboardType): bool
    {
        return self::TYPE_NAME === $dashboardType;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(Dashboard $dashboard): array
    {
        return ['twig' => '@OroGoogleDataStudioDashboard/Index/default.html.twig'];
    }
}
