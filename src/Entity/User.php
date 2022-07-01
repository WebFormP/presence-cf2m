<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: "UNIQ_8D93D649F85E0677", columns: ["username"])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        type: 'integer',
        unique: true,
        options: [
            "unsigned" => true,
        ],
    )]
    private int $id;

    #[ORM\Column(
        type: 'string',
        length: 180,
        unique: true,
    )]
    private string $username;

    #[ORM\Column(
        type: 'json',
    )]
    private array $roles = [];

    #[ORM\Column(
        type: 'string',
    )]
    private string $password;

    #[ORM\Column(
        type: 'string',
        length: 100,
    )]
    private string $thename;

    #[ORM\Column(
        type: 'string',
        length: 100,
    )]
    private string $thesurname;

    #[ORM\Column(
        type: 'string',
        length: 180,
        unique: true,
    )]
    private string $themail;

    #[ORM\Column(
        type: 'string',
        length: 25,
        unique: true,
    )]
    private string $theuid;

    #[ORM\Column(
        type: 'integer',
        options: [
            "unsigned" => true,
            "default"  => 0,
        ],
    )]
    private int $thestatus;

    #[ORM\Column(
        type: 'string',
        length: 11,
        unique: true,
    )]
    private string $thenationalid;

    #[ORM\OneToMany(
        mappedBy: 'userid',
        targetEntity: Inscription::class,
    )]
    private $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getUsername() : ?string
    {
        return $this->username;
    }

    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier() : string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles() : array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() : void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // error not null
        // $this->theuid = null;
    }

    public function getThename() : ?string
    {
        return $this->thename;
    }

    public function setThename(string $thename) : self
    {
        $this->thename = $thename;

        return $this;
    }

    public function getThesurname() : ?string
    {
        return $this->thesurname;
    }

    public function setThesurname(string $thesurname) : self
    {
        $this->thesurname = $thesurname;

        return $this;
    }

    public function getThemail() : ?string
    {
        return $this->themail;
    }

    public function setThemail(?string $themail) : self
    {
        $this->themail = $themail;

        return $this;
    }

    public function getTheuid() : ?string
    {
        return $this->theuid;
    }

    public function setTheuid(string $theuid) : self
    {
        $this->theuid = $theuid;

        return $this;
    }

    public function getThestatus() : ?int
    {
        return $this->thestatus;
    }

    public function setThestatus(int $thestatus) : self
    {
        $this->thestatus = $thestatus;

        return $this;
    }

    public function getThenationalid() : ?string
    {
        return $this->thenationalid;
    }

    public function setThenationalid(string $thenationalid) : self
    {
        $this->thenationalid = $thenationalid;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setUserid($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getUserid() === $this) {
                $inscription->setUserid(null);
            }
        }

        return $this;
    }
}
