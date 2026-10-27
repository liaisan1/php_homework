<?php

namespace App\Entity;

use App\Validator\PasswordComplexity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[UniqueEntity(fields: ['email'], message: 'Этот email уже зарегистрирован')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Введите email')]
    #[Assert\Email(message: 'Некорректный email')]
    private ?string $email = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Введите имя')]
    #[Assert\Length(
        min: 2,
        max: 30,
        minMessage: 'Имя должно содержать минимум 2 символа.',
        maxMessage: 'Имя должно содержать максимум 30 символов.'
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}-]+$/u',
        message: 'Имя может содержать только буквы и дефисы'
    )]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(message: 'Введите пароль')]
    #[PasswordComplexity]
    private ?string $plainPassword = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? '';
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
}