<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTranscriptRepository")
 */
class UserTranscript
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userTranscripts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transcript", inversedBy="userTranscripts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transcript;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $paragraphs = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $attempt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTranscript(): Transcript
    {
        return $this->transcript;
    }

    public function setTranscript(Transcript $transcript): self
    {
        $this->transcript = $transcript;

        return $this;
    }

    public function getParagraphs(): ?array
    {
        return $this->paragraphs;
    }

    public function setParagraphs(?array $paragraphs): self
    {
        $this->paragraphs = $paragraphs;

        return $this;
    }

    public function getAttempt(): ?string
    {
        return $this->attempt;
    }

    public function setAttempt(?string $attempt): self
    {
        $this->attempt = $attempt;

        return $this;
    }

    public function __toString()
    {
        return sprintf('%s-%s', $this->getUser(), $this->getTranscript());
    }

}
