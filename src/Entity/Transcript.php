<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TranscriptRepository")
 */
class Transcript
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $filename;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $attempt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

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

    public function getFirstCharacters($n) {
        return array_map(function ($x) use ($n) { return mb_substr($x, 0, $n); }, explode("\n", $this->getText()));
    }

    public function getParagraphs(): array {
        return array_filter(explode("\n", $this->getText()), function($s) { return $s; });
    }

    public function getRp() {
        return ['id' => $this->getId()];
    }
}
