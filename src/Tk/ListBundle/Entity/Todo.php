<?php

namespace Tk\ListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tk\ListBundle\Entity\TodoRepository")
 */
class Todo
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * @ORM\ManyToOne(targetEntity="Tk\UserBundle\Entity\Member", cascade={"persist"})
     */
    protected $author;

    /**
     * @ORM\ManyToOne(targetEntity="Tk\UserBundle\Entity\Member", cascade={"persist"})
     */
    protected $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Tk\GroupBundle\Entity\TGroup", inversedBy="todos", cascade={"persist"})
     */
    protected $group;

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
     * Set name
     *
     * @param string $name
     * @return Todo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Todo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Todo
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set author
     *
     * @param \Tk\UserBundle\Entity\Member $author
     * @return Todo
     */
    public function setAuthor(\Tk\UserBundle\Entity\Member $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Tk\UserBundle\Entity\Member 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set owner
     *
     * @param \Tk\UserBundle\Entity\Member $owner
     * @return Todo
     */
    public function setOwner(\Tk\UserBundle\Entity\Member $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Tk\UserBundle\Entity\Member 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set group
     *
     * @param \Tk\GroupBundle\Entity\TGroup $group
     * @return Todo
     */
    public function setGroup(\Tk\GroupBundle\Entity\TGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Tk\GroupBundle\Entity\TGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
