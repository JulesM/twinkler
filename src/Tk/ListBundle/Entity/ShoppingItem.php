<?php

namespace Tk\ListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tk\ListBundle\Entity\ShoppingItemRepository")
 */
class ShoppingItem
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
     * @ORM\Column(name="addedDate", type="datetime")
     */
    private $addedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="doneDate", type="datetime", nullable=true)
     */
    private $doneDate;

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
    protected $validator;

    /**
     * @ORM\ManyToOne(targetEntity="Tk\GroupBundle\Entity\TGroup", inversedBy="shoppingItems", cascade={"persist"})
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
     * @return ShoppingItem
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
     * Set addedDate
     *
     * @param \DateTime $addedDate
     * @return ShoppingItem
     */
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    /**
     * Get addedDate
     *
     * @return \DateTime 
     */
    public function getAddedDate()
    {
        return $this->addedDate;
    }

    /**
     * Set doneDate
     *
     * @param \DateTime $doneDate
     * @return ShoppingItem
     */
    public function setDoneDate($doneDate)
    {
        $this->doneDate = $doneDate;

        return $this;
    }

    /**
     * Get doneDate
     *
     * @return \DateTime 
     */
    public function getDoneDate()
    {
        return $this->doneDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return ShoppingItem
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
     * @return ShoppingItem
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
     * Set validator
     *
     * @param \Tk\UserBundle\Entity\Member $validator
     * @return ShoppingItem
     */
    public function setValidator(\Tk\UserBundle\Entity\Member $validator = null)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Get validator
     *
     * @return \Tk\UserBundle\Entity\Member 
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Set group
     *
     * @param \Tk\GroupBundle\Entity\TGroup $group
     * @return ShoppingItem
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
