<?php
namespace Entity;

class Message
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var \DateTime
     */
    private $dateCreated;
    /**
     * @var string
     */
    private $content;
    /**
     * @var User
     */
    private $user;

    /**
     * @var User
     */
    private $receiver;    
    /**
     * Messages constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->receiver = 0;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
   /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param User $user
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
       return $this->receiver;
    }
}