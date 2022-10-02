<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use App\Entity\UserOwnInterface;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Put(),
    ],
    normalizationContext: ['groups' => []],
    denormalizationContext: ['groups' => []],
)] 
class Company implements UserOwnInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:client:restricted', 'write:client:restricted','read:client:extended', 'write:client:extended'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $siren = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:client:restricted', 'write:client:restricted', 'read:client:extended', 'write:client:extended'])]
    private ?string $activityArea = null;

    #[Groups(['read:client:extended', 'write:client:extended'])]
    #[ORM\Column(length: 255)]
    private ?string $Address = null;

    #[Groups(['read:client:extended', 'write:client:extended'])]
    #[ORM\Column(length: 5)]
    private ?string $cp = null;

    #[Groups(['read:client:extended', 'write:client:extended'])]
    #[ORM\Column(length: 100)]
    private ?string $city = null;

    #[Groups(['read:client:extended', 'write:client:extended'])]
    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[Groups(['read:client:extended', 'write:client:extended'])]
    #[ORM\Column(length: 5, nullable: true)]
    private ?string $nic = null;
    
    #[ORM\ManyToOne(inversedBy: 'company',targetEntity: User::class, cascade:['persist'])]
    private ?User $user = null;

    #[ORM\Column]
    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?int $userId = null;

    public function detail(): ?Company
    {
        return $this->compagny;
    }

    public function __toString()
    {
        return $this->name;
    }

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

    public function getSiren(): ?int
    {
        return $this->siren;
    }

    public function setSiren(int $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getActivityArea(): ?string
    {
        return $this->activityArea;
    }

    public function setActivityArea(string $activityArea): self
    {
        $this->activityArea = $activityArea;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNic(): ?string
    {
        return $this->nic;
    }

    public function setNic(?string $nic): self
    {
        $this->nic = $nic;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
