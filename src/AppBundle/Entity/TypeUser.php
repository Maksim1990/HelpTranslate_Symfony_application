<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeUser
 *
 * @ORM\Table(name="type_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeUserRepository")
 */
class TypeUser
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
     * @ORM\Column(name="user_type", type="string", length=255)
     */
    private $userType;

    /**
     * @var string
     *
     * @ORM\Column(name="language_type", type="string", length=255)
     */
    private $languageType;

    /**
     * @var string
     *
     * @ORM\Column(name="language_level", type="string", length=255)
     */
    private $languageLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="is_available", type="string", length=255)
     */
    private $isAvailable;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

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
     * @return TypeUser
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
     * Set userType
     *
     * @param string $userType
     *
     * @return TypeUser
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }



    /**
     * Set languageLevel
     *
     * @param string $languageLevel
     *
     * @return TypeLevel
     */
    public function setLanguageLevel($languageLevel)
    {
        $this->languageLevel = $languageLevel;

        return $this;
    }

    /**
     * Get languageLevel
     *
     * @return string
     */
    public function getLanguageLevel()
    {
        return $this->languageLevel;
    }

    /**
     * Set languageType
     *
     * @param string $languageType
     *
     * @return TypeUser
     */
    public function setLanguageType($languageType)
    {
        $this->languageType = $languageType;

        return $this;
    }

    /**
     * Get languageType
     *
     * @return string
     */
    public function getLanguageType()
    {
        return $this->languageType;
    }

    /**
     * Set isAvailable
     *
     * @param string $isAvailable
     *
     * @return TypeUser
     */
    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * Get isAvailable
     *
     * @return string
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
    }
    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Todo
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Set updatedAt
     *
     * @param \DateTime $createdAt
     *
     * @return Image
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

