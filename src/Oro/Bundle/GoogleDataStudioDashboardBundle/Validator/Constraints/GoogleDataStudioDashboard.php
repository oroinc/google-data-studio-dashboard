<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class GoogleDataStudioDashboard extends Constraint
{
    public string $blankMessage = 'oro.oro_google_data_studio_dashboard.validator.constraints.blank';

    public string $patternMessage = 'oro.oro_google_data_studio_dashboard.validator.constraints.pattern';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT];
    }
}
