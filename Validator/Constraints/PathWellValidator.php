<?php

namespace Donato\PathWellBundle\Validator\Constraints;

use Donato\PathWellBundle\Validator\PathWellTopologiesInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PathWellValidator extends ConstraintValidator
{
    /**
     * @var ExecutionContextInterface
     */
    protected $context;

    /** @var  PathWellTopologiesInterface */
    private $topologies;

    /** @var bool */
    private $enabled;

    /**
     * PathWellValidator constructor.
     * @param PathWellTopologiesInterface $topologies
     * @param bool $enabled
     */
    public function __construct(PathWellTopologiesInterface $topologies, $enabled)
    {
        $this->topologies = $topologies;
        $this->enabled = $enabled;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!($constraint instanceof PathWell)) {
            return;
        }

        if (false === $this->enabled) {
            return;
        }

        $topology = $this->passwordToPathWellTopology($value);
        foreach ($this->topologies->getBlacklist() as $rule) {
            if (preg_match("#^{$rule}$#", $topology) === 1) {
                $this->context->buildViolation($constraint->message)
                    ->setTranslationDomain('validators')
                    ->addViolation();

                return;
            }
        }
    }

    private function passwordToPathWellTopology($password)
    {
        $password = preg_replace('/[a-z]/', 'l', $password);
        $password = preg_replace('/[A-Z]/', 'u', $password);
        $password = preg_replace('/[0-9]/', 'd', $password);
        $password = preg_replace('/[^lud]/', 's', $password);

        return $password;
    }

}
