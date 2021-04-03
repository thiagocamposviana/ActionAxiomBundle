<?php

namespace Mugo\ActionAxiomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MugoWordSynonym
 *
 * @ORM\Table(name="mugo_word_synonym")
 * @ORM\Entity
 */
class MugoWordSynonym
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer", nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="word", type="string", length=255, nullable=false)
     */
    private $word;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=15, nullable=false)
     */
    private $language;

    /**
     * @var int|null
     *
     * @ORM\Column(name="antonyms_code", type="integer", nullable=true)
     */
    private $antonymsCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

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

    public function getAntonymsCode(): ?int
    {
        return $this->antonymsCode;
    }

    public function setAntonymsCode(?int $antonymsCode): self
    {
        $this->antonymsCode = $antonymsCode;

        return $this;
    }


}
