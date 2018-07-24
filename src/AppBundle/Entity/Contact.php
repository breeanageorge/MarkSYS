<?php

namespace AppBundle\Entity;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table("contact_info")
 */
class Contact
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
     * @var Uuid
     *
     * @ORM\Column(name="uuid", type="string")
     */
    private $uuid;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="change", field="isRead")
     *
     * @ORM\Column(name="date_read", type="datetime", nullable=true)
     */
    private $dateRead;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @Assert\NotBlank(
     *     message = "select a reason"
     * )
     *
     * @Assert\Choice(
     *     choices={
     *          "general_inquiry",
     *          "support_request",
     *          "quote_request"
     *     },
     *     message="invalid choice"
     * )
     * @ORM\Column(name="reason", type="string")
     */
    private $reason;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @Assert\NotBlank(
     *     message = "enter your name"
     * )
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @Assert\NotBlank(
     *     message = "enter your email"
     * )
     *
     * @Assert\Email(
     *     checkMX = true
     * )
     *
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @Assert\NotBlank(
     *     message = "enter your phone"
     * )
     *
     * @ORM\Column(name="phone", type="string")
     */
    private $phone;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank(
     *     message = "enter message"
     * )
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var boolean
     *
     * @Assert\Type(type="boolean")
     *
     * @ORM\Column(name="is_read", type="boolean")
     */
    private $isRead = false;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @ORM\PostLoad
     */
    public function setUuid()
    {
        $this->uuid = Uuid::fromString(strval($this->uuid));
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateRead()
    {
        return $this->dateRead;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return boolean
     */
    public function isRead()
    {
        return $this->isRead;
    }

    /**
     * @param boolean $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }
}