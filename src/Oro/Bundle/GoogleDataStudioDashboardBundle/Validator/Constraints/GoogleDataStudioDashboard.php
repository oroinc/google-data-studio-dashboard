<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class GoogleDataStudioDashboard extends Constraint
{
    public string $blankMessage = 'This value should not be blank.';

    public string $patternMessage = 'This value is not valid. Url should start with "https://datastudio.google.com/embed/reporting/"';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT];
    }
}
