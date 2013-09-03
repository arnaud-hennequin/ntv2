<?php

namespace NinjaTooken\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message
 *
 * @ORM\Table(name="nt_message")
 * @ORM\Entity(repositoryClass="NinjaTooken\UserBundle\Entity\MessageRepository")
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="old_id", type="integer", nullable=true)
     */
    private $old_id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\MaxLength(255)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="NinjaTooken\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_deleted", type="boolean")
     */
    private $hasDeleted = false;

    /**
     * @ORM\OneToMany(targetEntity="NinjaTooken\UserBundle\Entity\MessageUser", mappedBy="message", cascade={"persist", "remove"})
     */
    private $receivers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->receivers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setDateAjout(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Message
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     * @return Message
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime 
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Message
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set hasDeleted
     *
     * @param boolean $hasDeleted
     * @return Message
     */
    public function setHasDeleted($hasDeleted)
    {
        $this->hasDeleted = $hasDeleted;

        return $this;
    }

    /**
     * Get hasDeleted
     *
     * @return boolean 
     */
    public function getHasDeleted()
    {
        return $this->hasDeleted;
    }

    /**
     * Set old_id
     *
     * @param integer $oldId
     * @return Message
     */
    public function setOldId($oldId)
    {
        $this->old_id = $oldId;

        return $this;
    }

    /**
     * Get old_id
     *
     * @return integer 
     */
    public function getOldId()
    {
        return $this->old_id;
    }

    /**
     * Add receivers
     *
     * @param \NinjaTooken\UserBundle\Entity\MessageUser $receivers
     * @return Message
     */
    public function addReceiver(\NinjaTooken\UserBundle\Entity\MessageUser $receivers)
    {
        $this->receivers[] = $receivers;

        return $this;
    }

    /**
     * Remove receivers
     *
     * @param \NinjaTooken\UserBundle\Entity\MessageUser $receivers
     */
    public function removeReceiver(\NinjaTooken\UserBundle\Entity\MessageUser $receivers)
    {
        $this->receivers->removeElement($receivers);
    }

    /**
     * Get receivers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceivers()
    {
        return $this->receivers;
    }
}
