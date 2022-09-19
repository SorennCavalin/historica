<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Age::class, mappedBy: 'pays')]
    private Collection $ages;

    #[ORM\OneToMany(mappedBy: 'origin', targetEntity: User::class)]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'pays')]
    private Collection $events;

    #[ORM\OneToMany(mappedBy: 'Pays', targetEntity: Ville::class, orphanRemoval: true)]
    private Collection $villes;


    public function __construct()
    {
        $this->ages = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Age>
     */
    public function getAges(): Collection
    {
        return $this->ages;
    }

    public function addAge(Age $age): self
    {
        if (!$this->ages->contains($age)) {
            $this->ages->add($age);
            $age->addPay($this);
        }

        return $this;
    }

    public function removeAge(Age $age): self
    {
        if ($this->ages->removeElement($age)) {
            $age->removePay($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setOrigin($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOrigin() === $this) {
                $user->setOrigin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addPay($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removePay($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ville>
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes->add($ville);
            $ville->setPays($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        if ($this->villes->removeElement($ville)) {
            // set the owning side to null (unless already changed)
            if ($ville->getPays() === $this) {
                $ville->setPays(null);
            }
        }

        return $this;
    }
}
