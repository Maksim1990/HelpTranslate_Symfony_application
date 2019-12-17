<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Translator
 *
 * @ORM\Table(name="translator")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TranslatorRepository")
 */
class Translator
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="input_lang", type="string", length=255)
     */
    private $inputLang;

    /**
     * @var string
     *
     * @ORM\Column(name="input_word", type="string", length=255)
     */
    private $inputWord;

    /**
     * @var string
     *
     * @ORM\Column(name="output_lang", type="string", length=255)
     */
    private $outputLang;

    /**
     * @var string
     *
     * @ORM\Column(name="output_word", type="string", length=255)
     */
    private $outputWord;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Translator
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set inputLang
     *
     * @param string $inputLang
     *
     * @return Translator
     */
    public function setInputLang($inputLang)
    {
        $this->inputLang = $inputLang;

        return $this;
    }

    /**
     * Get inputLang
     *
     * @return string
     */
    public function getInputLang()
    {
        return $this->inputLang;
    }

    /**
     * Set inputWord
     *
     * @param string $inputWord
     *
     * @return Translator
     */
    public function setInputWord($inputWord)
    {
        $this->inputWord = $inputWord;

        return $this;
    }

    /**
     * Get inputWord
     *
     * @return string
     */
    public function getInputWord()
    {
        return $this->inputWord;
    }

    /**
     * Set outputLang
     *
     * @param string $outputLang
     *
     * @return Translator
     */
    public function setOutputLang($outputLang)
    {
        $this->outputLang = $outputLang;

        return $this;
    }

    /**
     * Get outputLang
     *
     * @return string
     */
    public function getOutputLang()
    {
        return $this->outputLang;
    }

    /**
     * Set outputWord
     *
     * @param string $outputWord
     *
     * @return Translator
     */
    public function setOutputWord($outputWord)
    {
        $this->outputWord = $outputWord;

        return $this;
    }

    /**
     * Get outputWord
     *
     * @return string
     */
    public function getOutputWord()
    {
        return $this->outputWord;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Translator
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Translator
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

