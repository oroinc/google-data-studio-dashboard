<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class GoogleDataStudioDashboard extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This value should not be blank.';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return [self::CLASS_CONSTRAINT];
    }
}
