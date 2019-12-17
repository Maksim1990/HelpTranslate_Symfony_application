<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Testimonial
 *
 * @ORM\Table(name="testimonial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TestimonialRepository")
 */
class Testimonial
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="testimonials")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     * @ORM\Column(name="user_profile_id", type="integer")
     */
    private $userProfileId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_profile_type", type="string", length=255)
     */
    private $userProfileType;

    /**
     * @var string
     *
     * @ORM\Column(name="user_type", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime" , nullable=true)
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
     * Set userProfileId
     *
     * @param integer $userProfileId
     *
     * @return Testimonial
     */
    public function setUserProfileId($userProfileId)
    {
        $this->userProfileId = $userProfileId;

        return $this;
    }

    /**
     * Get userProfileId
     *
     * @return int
     */
    public function getUserProfileId()
    {
        return $this->userProfileId;
    }

    /**
     * Set userType
     *
     * @param string $userType
     *
     * @return Testimonial
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
     * Set userProfileType
     *
     * @param string $userProfileType
     *
     * @return Testimonial
     */
    public function setUserProfileType($userProfileType)
    {
        $this->userProfileType = $userProfileType;

        return $this;
    }

    /**
     * Get userProfileType
     *
     * @return string
     */
    public function getUserProfileType()
    {
        return $this->userProfileType;
    }

    /**
     * Set languageType
     *
     * @param string $languageType
     *
     * @return Testimonial
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
     * Set inputWord
     *
     * @param string $description
     *
     * @return Testimonial
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Testimonial
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
     * @return Rating
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Testimonial
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
