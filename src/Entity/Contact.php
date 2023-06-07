<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank]
    private string $lastname;
    #[Assert\NotBlank]
    private string $firstname;
    #[Assert\NotBlank]
    private string $email;
    #[Assert\NotBlank]
    private string $phone;
    #[Assert\NotBlank]
    private string $subjet;
    #[Assert\NotBlank]
    private string $content;

    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getSubjet(): string
    {
        return $this->subjet;
    }
    public function setSubjet(string $subjet): self
    {
        $this->subjet = $subjet;

        return $this;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
