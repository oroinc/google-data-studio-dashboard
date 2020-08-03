<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Model;

/**
 * Storage of enum values for field "type".
 */
final class DashboardEnums
{
    public const DASHBOARD_TYPE_CODE = 'dashboard_type';

    public const TYPE_WIDGETS = 'widgets';
    public const TYPE_GOOGLE_DATA_STUDIO = 'google_data_studio';

    public const DASHBOARD_TYPES = [
        self::TYPE_WIDGETS => 'Widgets',
        self::TYPE_GOOGLE_DATA_STUDIO => 'Google Data Studio',
    ];
}
