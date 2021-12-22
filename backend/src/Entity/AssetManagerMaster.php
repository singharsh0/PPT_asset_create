<?php

namespace App\Entity;


use Symfony\Contracts\HttpClient\HttpClientInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use OpenApi\Annotations as OA;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AssetManagerMasterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use public\bundles\ApiPlatform\fonts;

/**
 * @ORM\Entity(repositoryClass=AssetManagerMasterRepository::class)
 * @OA\Schema()
 */

class AssetManagerMaster
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @OA\Property(ref="#/components/schemas/product_id")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $effective_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiration_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifier;

    /**
     * @ORM\Column(type="date")
     */
    private $created_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $steward;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEffectiveDate(): ?\DateTimeInterface
    {
        return $this->effective_date;
    }

    public function setEffectiveDate(\DateTimeInterface $effective_date): self
    {
        $this->effective_date = $effective_date;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(?\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getSteward(): ?string
    {
        return $this->steward;
    }

    public function setSteward(?string $steward): self
    {
        $this->steward = $steward;

        return $this;
    }
}
