<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields={"email","username"}, message="This one is already taken")
 */
class User implements UserInterface
{



    /**
     * @ORM\OneToMany(targetEntity="Testimonial", mappedBy="user")
     */
    private $testimonials;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="user")
     */
    private $ratings;

    /**
     * @ORM\OneToOne(targetEntity="Image", mappedBy="user")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
     */
    private $messages;


    /**
     * @ORM\OneToMany(targetEntity="Opinion", mappedBy="user")
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="userSender")
     */
    private $messageSingle;

    public function __construct()
    {
        $this->testimonials = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->messageSingle = new ArrayCollection();
    }



    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return [
            'ROLE_USER'
        ];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
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


    /**
     * Add testimonial
     *
     * @param \AppBundle\Entity\Testimonial $testimonial
     *
     * @return User
     */
    public function addTestimonial(\AppBundle\Entity\Testimonial $testimonial)
    {
        $this->testimonials[] = $testimonial;

        return $this;
    }

    /**
     * Remove testimonial
     *
     * @param \AppBundle\Entity\Testimonial $testimonial
     */
    public function removeTestimonial(\AppBundle\Entity\Testimonial $testimonial)
    {
        $this->testimonials->removeElement($testimonial);
    }

    /**
     * Get testimonials
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTestimonials()
    {
        return $this->testimonials;
    }

    /**
     * Add rating
     *
     * @param \AppBundle\Entity\Rating $rating
     *
     * @return User
     */
    public function addRating(\AppBundle\Entity\Rating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \AppBundle\Entity\Rating $rating
     */
    public function removeRating(\AppBundle\Entity\Rating $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return User
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add messageSingle
     *
     * @param \AppBundle\Entity\Message $messageSingle
     *
     * @return User
     */
    public function addMessageSingle(\AppBundle\Entity\Message $messageSingle)
    {
        $this->messageSingle[] = $messageSingle;

        return $this;
    }

    /**
     * Remove messageSingle
     *
     * @param \AppBundle\Entity\Message $messageSingle
     */
    public function removeMessageSingle(\AppBundle\Entity\Message $messageSingle)
    {
        $this->messageSingle->removeElement($messageSingle);
    }

    /**
     * Get messageSingle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessageSingle()
    {
        return $this->messageSingle;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return User
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Add opinion
     *
     * @param \AppBundle\Entity\Opinion $opinion
     *
     * @return User
     */
    public function addOpinion(\AppBundle\Entity\Opinion $opinion)
    {
        $this->opinions[] = $opinion;

        return $this;
    }

    /**
     * Remove opinion
     *
     * @param \AppBundle\Entity\Opinion $opinion
     */
    public function removeOpinion(\AppBundle\Entity\Opinion $opinion)
    {
        $this->opinions->removeElement($opinion);
    }

    /**
     * Get opinions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpinions()
    {
        return $this->opinions;
    }
}
