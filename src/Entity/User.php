<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
#[ORM\HasLifecycleCallbacks]
class User
{

    /**
     * User id.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * User Email.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email = null;

    /**
     * User name.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    /**
     * User age.
     *
     * @var int|string|null
     */
    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Assert\Type(type: ['integer', 'digit'])]
    #[Assert\NotBlank]
    private int|string|null $age = null;

    /**
     * User phone number.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex('/^\+?[78][0-9]+$/')]
    #[Assert\Length(max: 13)]
    private ?string $phone = null;

    /**
     * User birthday.
     *
     * @var \DateTimeInterface|string|null
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\Date]
    private \DateTimeInterface|string|null $birthday = null;

    /**
     * User sex.
     *
     * @var string|null
     */
    #[ORM\Column(length: 6)]
    #[Assert\Choice(['male', 'female'])]
    #[Assert\NotBlank]
    private ?string $sex = null;

    /**
     * Date the entity was created.
     *
     * @var \DateTimeInterface|null
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    /**
     * Date the entity was updated.
     *
     * @var \DateTimeInterface|null
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * Get user id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get user email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set property.
     *
     * @param string|null $email
     *
     * @return \App\Entity\User
     */
    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get user name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set property.
     *
     * @param string|null $name
     *
     * @return \App\Entity\User
     */
    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get property.
     *
     * @return int|string|null
     */
    public function getAge(): int|string|null
    {
        return $this->age;
    }

    /**
     * Set property.
     *
     * @param int|string|null $age
     *
     * @return \App\Entity\User
     */
    public function setAge(int|string|null $age): static
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get property.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set property.
     *
     * @param string|null $phone
     *
     * @return \App\Entity\User
     */
    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get property.
     *
     * @return \DateTimeInterface|string|null
     */
    public function getBirthday(): \DateTimeInterface|string|null
    {
        return $this->birthday;
    }

    /**
     * Set property.
     *
     * @param \DateTimeInterface|string|null $birthday
     *
     * @return \App\Entity\User
     */
    public function setBirthday(\DateTimeInterface|string|null $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Gets the creation date.
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * Sets the creation date
     *
     * @param \DateTimeImmutable $created_at
     *
     * @return \App\Entity\User
     */
    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Gets the update date.
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * Sets the update date.
     *
     * @param \DateTimeImmutable $updated_at
     *
     * @return \App\Entity\User
     */
    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get property.
     *
     * @return string|null
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * Set property.
     *
     * @param string|null $sex
     *
     * @return \App\Entity\User
     */
    public function setSex(?string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Sets the birthday before saving.
     *
     * @return void
     * @throws \Exception
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setBirthdayRightFormat(): void
    {
        if ($this->birthday && !$this->birthday instanceof \DateTimeInterface) {
            $this->birthday = new \DateTime($this->birthday);
        }
    }

}
