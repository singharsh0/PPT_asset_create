<?php

namespace App\Entity;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ApiPlatform\Core\Annotation\ApiFilter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\AssetManagerMasterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use public\bundles\ApiPlatform\fonts;
use ApiPlatform\Core\Annotation\ApiProperty;


/**
 * @ORM\Entity(repositoryClass=AssetManagerFileDetailsRepository::class)
 
//  * normalizationContext={"groups" = {"read"}},
//  *   denormalizationContext={"groups" = {"write"}},
//  *   collectionOperations={
//  *     "get",
//  *     "post" = {
//  *       "controller" = SuperheroCoverController::class,
//  *       "deserialize" = false,
//  *     },
//  *   },
//  *   itemOperations={
//  *     ...
//  *   }
 
 */

class AssetManagerFileDetails
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $asset_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover_image_file_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover_image_path;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_date;

    /** 
      * @Assert\NotBlank(message="Please, upload the photo.") 
      * @Assert\File(mimeTypes={ "image/png", "image/jpeg" }) 
    */ 
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetId(): ?int
    {
        return $this->asset_id;
    }

    public function setAssetId(?int $asset_id): self
    {
        $this->asset_id = $asset_id;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(?string $file_path): self
    {
        $this->file_path = $file_path;

        return $this;
    }

    public function getCoverImageFileName(): ?string
    {
        return $this->cover_image_file_name;
    }

    public function setCoverImageFileName(?string $cover_image_file_name): self
    {
        $this->cover_image_file_name = $cover_image_file_name;

        return $this;
    }

    public function getCoverImagePath(): ?string
    {
        return $this->cover_image_path;
    }

    public function setCoverImagePath(?string $cover_image_path): self
    {
        $this->cover_image_path = $cover_image_path;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(?\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }
    // public function __toString() { 
    //     return (string) $this->asset_id; 
    //     }

    public function getPhoto() { 
        return $this->photo; 
     } 
     public function setPhoto($photo) { 
        $this->photo = $photo; 
        return $this; 
     } 
}
