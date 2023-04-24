<?php

namespace App\Entity;

use App\Repository\TaxNumberPatternRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: TaxNumberPatternRepository::class)]
class TaxNumberPattern
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $pattern = null;

    #[ORM\ManyToOne(inversedBy: 'taxNumberPatterns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    public function __toString(): string
    {
        return (string)$this->pattern;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if ($this->pattern !== null) {
            // suppress E_WARNING temporarily for invalid regex
            set_error_handler(static fn() => true, E_WARNING);
            if (preg_match($this->pattern, '') === false) {
                $context->buildViolation('This expression is not a valid RegEx with delimiters')
                    ->atPath('pattern')
                    ->addViolation();
            }
            restore_error_handler();
        }
    }
}
