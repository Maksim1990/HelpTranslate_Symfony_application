<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingsRepository")
 */
class Settings
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
     * @ORM\Column(name="background_color", type="string", length=255, nullable=true)
     */
    private $backgroundColor;

    /**
     * @var string
     *
     * @ORM\Column(name="sidebar_color", type="string", length=255, nullable=true)
     */
    private $sidebarColor;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_color", type="string", length=255, nullable=true)
     */
    private $footerColor;

    /**
     * @var string
     *
     * @ORM\Column(name="header_color", type="string", length=255, nullable=true)
     */
    private $headerColor;

    /**
     * @var string
     *
     * @ORM\Column(name="links_color", type="string", length=255, nullable=true)
     */
    private $linksColor;

    /**
     * @var string
     *
     * @ORM\Column(name="show_email", type="string", length=255, nullable=true)
     */
    private $showEmail;

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
     * @return Settings
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
     * Set backgroundColor
     *
     * @param string $backgroundColor
     *
     * @return Settings
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * Get backgroundColor
     *
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Set footerColor
     *
     * @param string $footerColor
     *
     * @return Settings
     */
    public function setFooterColor($footerColor)
    {
        $this->footerColor = $footerColor;

        return $this;
    }

    /**
     * Get footerColor
     *
     * @return string
     */
    public function getFooterColor()
    {
        return $this->footerColor;
    }


    /**
     * Set headerColor
     *
     * @param string $headerColor
     *
     * @return Settings
     */
    public function setHeaderColor($headerColor)
    {
        $this->headerColor = $headerColor;

        return $this;
    }

    /**
     * Get headerColor
     *
     * @return string
     */
    public function getHeaderColor()
    {
        return $this->headerColor;
    }

    /**
     * Set sidebarColor
     *
     * @param string $sidebarColor
     *
     * @return Settings
     */
    public function setSidebarColor($sidebarColor)
    {
        $this->sidebarColor = $sidebarColor;

        return $this;
    }

    /**
     * Get sidebarColor
     *
     * @return string
     */
    public function getSidebarColor()
    {
        return $this->sidebarColor;
    }

    /**
     * Set linksColor
     *
     * @param string $linksColor
     *
     * @return Settings
     */
    public function setLinksColor($linksColor)
    {
        $this->linksColor = $linksColor;

        return $this;
    }

    /**
     * Get linksColor
     *
     * @return string
     */
    public function getLinksColor()
    {
        return $this->linksColor;
    }

    /**
     * Set showEmail
     *
     * @param string $showEmail
     *
     * @return Settings
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;

        return $this;
    }

    /**
     * Get showEmail
     *
     * @return string
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Settings
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
     * @return Settings
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

