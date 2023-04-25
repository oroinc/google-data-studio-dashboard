<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Form\Extension;

use Oro\Bundle\DashboardBundle\Entity\Dashboard;
use Oro\Bundle\DashboardBundle\Form\Type\DashboardType;
use Oro\Bundle\GoogleDataStudioDashboardBundle\DashboardType\GoogleDataStudoDashboardTypeConfigProvider;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Implements next logic:
 *   - set "type" and "embedUrl" the same as cloned Dashboard has
 *   - don't show field "embedUrl" when "type" is not "Google Data Studio"
 *   - don't allow changing of "type" on edit form
 *   - set "name" to "google_data_studio" when "type" is "Google Data Studio"
 */
class DashboardTypeExtension extends AbstractTypeExtension
{
    public const GOOGLE_DATA_STUDIO_DASHBOARD_NAME = 'google_data_studio';

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var Dashboard $dashboard */
            $dashboard = $event->getData();
            if ($dashboard->getStartDashboard()) {
                $dashboard->setEmbedUrl($dashboard->getStartDashboard()->getEmbedUrl());
            }

            if ($dashboard->getDashboardType() && $dashboard->getDashboardType()->getId() === GoogleDataStudoDashboardTypeConfigProvider::TYPE_NAME) {
                $dashboard->setName(self::GOOGLE_DATA_STUDIO_DASHBOARD_NAME);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        /** @var Dashboard $dashboard */
        $dashboard = $view->vars['value'];
        $view->children['embed_url']->vars['required'] = true;

        if (!$dashboard->getDashboardType() || $dashboard->getDashboardType()->getId() !== GoogleDataStudoDashboardTypeConfigProvider::TYPE_NAME) {
            $view->children['embed_url']->vars['attr']['class'] = 'hide';
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [DashboardType::class];
    }
}
