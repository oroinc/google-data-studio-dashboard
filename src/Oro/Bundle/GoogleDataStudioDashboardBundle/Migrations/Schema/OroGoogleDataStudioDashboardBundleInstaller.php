<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Oro\Bundle\EntityBundle\EntityConfig\DatagridScope;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\GoogleDataStudioDashboardBundle\Model\DashboardEnums;
use Oro\Bundle\GoogleDataStudioDashboardBundle\Model\DashboardFields;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * ORO installer for GoogleDataStudioDashboardBundle.
 */
class OroGoogleDataStudioDashboardBundleInstaller implements Installation, ExtendExtensionAwareInterface
{
    /**
     * @var ExtendExtension
     */
    protected $extendExtension;

    /**
     * {@inheritdoc}
     */
    public function setExtendExtension(ExtendExtension $extendExtension): void
    {
        $this->extendExtension = $extendExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion(): string
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries): void
    {
        $table = $schema->getTable('oro_dashboard');

        $this->extendExtension->addEnumField(
            $schema,
            $table,
            DashboardFields::TYPE,
            DashboardEnums::DASHBOARD_TYPE_CODE,

            false,
            false,
            [
                'extend'    => [
                    'is_extend' => true,
                    'owner'     => ExtendScope::OWNER_CUSTOM,
                ],
                'datagrid'  => ['is_visible' => DatagridScope::IS_VISIBLE_TRUE, 'show_filter' => true],
                'form'      => ['is_enabled' => true],
                'view'      => ['is_displayable' => false, 'priority' => 2],
                'merge'     => ['display' => false],
                'dataaudit' => ['auditable' => false]
            ]
        );

        $table->addColumn(
            DashboardFields::EMBED_URL,
            Types::STRING,
            [
                'notnull'     => false,
                'length'      => 8190,
                'oro_options' => [
                    'extend'    => [
                        'is_extend' => true,
                        'owner'     => ExtendScope::OWNER_CUSTOM,
                    ],
                    'datagrid'  => ['is_visible' => DatagridScope::IS_VISIBLE_FALSE, 'show_filter' => false],
                    'form'      => ['is_enabled' => true],
                    'view'      => ['is_displayable' => false, 'priority' => 1],
                    'merge'     => ['display' => false],
                    'dataaudit' => ['auditable' => false]
                ]
            ]
        );
    }
}
