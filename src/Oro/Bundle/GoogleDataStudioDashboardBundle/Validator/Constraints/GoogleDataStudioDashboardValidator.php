<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Validator\Constraints;

use Oro\Bundle\DashboardBundle\Entity\Dashboard;
use Oro\Bundle\GoogleDataStudioDashboardBundle\Model\DashboardEnums;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class GoogleDataStudioDashboardValidator extends ConstraintValidator
{
    public const DATA_STUDIO_URL_EMBED_PATTERN = '/^https:\/\/datastudio\.google\.com\/embed\/reporting[a-zA-Z0-9\/\-_]*$/';

    /**
     * @param Dashboard|object $value
     * @param GoogleDataStudioDashboard $constraint
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
                $this->context->buildViolation($constraint->blankMessage)
                    ->atPath('type')
                    ->addViolation();
            } elseif ($value->getType()->getId() === DashboardEnums::TYPE_GOOGLE_DATA_STUDIO) {
                if (!$value->getEmbedUrl()) {
                    $this->context->buildViolation($constraint->blankMessage)
                        ->atPath('embed_url')
                        ->addViolation();
                } elseif (!preg_match(self::DATA_STUDIO_URL_EMBED_PATTERN, $value->getEmbedUrl())) {
                    $this->context->buildViolation($constraint->patternMessage)
                        ->atPath('embed_url')
                        ->addViolation();
                }
            }
        }
    }
}
