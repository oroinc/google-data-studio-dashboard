<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Validator\Constraints;

use Oro\Bundle\DashboardBundle\Entity\Dashboard;
use Oro\Bundle\GoogleDataStudioDashboardBundle\Model\DashboardEnums;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class GoogleDataStudioDashboardValidator extends ConstraintValidator
{
    /**
     * @param Dashboard|object $value
     * @param GoogleDataStudioDashboard    $constraint
     *
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!$value instanceof Dashboard) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Value must be instance of "%s", "%s" given',
                    Dashboard::class,
                    is_object($value) ? get_class($value) : gettype($value)
                )
            );
        }

        if (!$value->getStartDashboard()) {
            if (!$value->getType()) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('type')
                    ->addViolation();
            } elseif (
                $value->getType()->getId() === DashboardEnums::TYPE_GOOGLE_DATA_STUDIO
                && !$value->getEmbedUrl()
            ) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('embed_url')
                    ->addViolation();
            }
        }
    }
}
