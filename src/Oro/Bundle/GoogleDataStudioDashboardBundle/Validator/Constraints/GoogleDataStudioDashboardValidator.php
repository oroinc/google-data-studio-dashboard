<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Validator\Constraints;

use Oro\Bundle\DashboardBundle\Entity\Dashboard;
use Symfony\Component\Validator\Constraint;
use Oro\Bundle\GoogleDataStudioDashboardBundle\DashboardType\GoogleDataStudoDashboardTypeConfigProvider;
use Symfony\Component\Validator\ConstraintValidator;

class GoogleDataStudioDashboardValidator extends ConstraintValidator
{
    private const DATA_STUDIO_URL_START = 'https://datastudio.google.com/embed/reporting/';

    private const DATA_STUDIO_URL_EMBED_PATTERN =
        '/^https:\/\/datastudio\.google\.com\/embed\/reporting[a-zA-Z0-9\/\-_]*$/';

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
            if (!$value->getDashboardType()) {
                $this->context->buildViolation($constraint->blankMessage)
                    ->atPath('type')
                    ->addViolation();
            } elseif ($value->getDashboardType()->getId() === GoogleDataStudoDashboardTypeConfigProvider::TYPE_NAME) {
                if (!$value->getEmbedUrl()) {
                    $this->context->buildViolation($constraint->blankMessage)
                        ->atPath('embed_url')
                        ->addViolation();
                } elseif (!preg_match(self::DATA_STUDIO_URL_EMBED_PATTERN, $value->getEmbedUrl())) {
                    $this->context->buildViolation(
                        $constraint->patternMessage,
                        ['%urlStart%' => self::DATA_STUDIO_URL_START]
                    )
                        ->atPath('embed_url')
                        ->addViolation();
                }
            }
        }
    }
}
