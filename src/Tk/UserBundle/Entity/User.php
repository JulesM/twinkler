<?php

namespace Tk\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Tk\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lasttname", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\ManyToMany(targetEntity="Tk\GroupBundle\Entity\TGroup", inversedBy="members", cascade={"persist"})
     */
    protected $tgroups;

    /**
     * @ORM\ManyToOne(targetEntity="Tk\GroupBundle\Entity\TGroup", cascade={"persist"})
     */
    protected $currentTGroup;

    /**
     * @ORM\OneToMany(targetEntity="Tk\ExpenseBundle\Entity\Expense", mappedBy="owner", cascade={"persist"})
     */
    protected $myExpenses;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tk\ExpenseBundle\Entity\Expense", mappedBy="users", cascade={"persist"})
     */
    protected $ForMeExpenses;

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
     * Constructor
     */
    public function __construct()
    {
        $this->myExpenses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ForMeExpenses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Add myExpenses
     *
     * @param \Tk\ExpenseBundle\Entity\expense $myExpenses
     * @return User
     */
    public function addMyExpense(\Tk\ExpenseBundle\Entity\expense $myExpenses)
    {
        $this->myExpenses[] = $myExpenses;

        return $this;
    }

    /**
     * Remove myExpenses
     *
     * @param \Tk\ExpenseBundle\Entity\expense $myExpenses
     */
    public function removeMyExpense(\Tk\ExpenseBundle\Entity\expense $myExpenses)
    {
        $this->myExpenses->removeElement($myExpenses);
    }

    /**
     * Get myExpenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyExpenses()
    {
        return $this->myExpenses;
    }

    /**
     * Add ForMeExpenses
     *
     * @param \Tk\ExpenseBundle\Entity\expense $forMeExpenses
     * @return User
     */
    public function addForMeExpense(\Tk\ExpenseBundle\Entity\expense $forMeExpenses)
    {
        $this->ForMeExpenses[] = $forMeExpenses;

        return $this;
    }

    /**
     * Remove ForMeExpenses
     *
     * @param \Tk\ExpenseBundle\Entity\expense $forMeExpenses
     */
    public function removeForMeExpense(\Tk\ExpenseBundle\Entity\expense $forMeExpenses)
    {
        $this->ForMeExpenses->removeElement($forMeExpenses);
    }

    /**
     * Get ForMeExpenses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getForMeExpenses()
    {
        return $this->ForMeExpenses;
    }

    /**
     * Add tgroups
     *
     * @param \Tk\GroupBundle\Entity\TGroup $tgroups
     * @return User
     */
    public function addTgroup(\Tk\GroupBundle\Entity\TGroup $tgroups)
    {
        $this->tgroups[] = $tgroups;

        return $this;
    }

    /**
     * Remove tgroups
     *
     * @param \Tk\GroupBundle\Entity\TGroup $tgroups
     */
    public function removeTgroup(\Tk\GroupBundle\Entity\TGroup $tgroups)
    {
        $this->tgroups->removeElement($tgroups);
    }

    /**
     * Get tgroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTgroups()
    {
        return $this->tgroups;
    }

    /**
     * Set currentTGroup
     *
     * @param \Tk\GroupBundle\Entity\TGroup $currentTGroup
     * @return User
     */
    public function setCurrentTGroup(\Tk\GroupBundle\Entity\TGroup $currentTGroup = null)
    {
        $this->currentTGroup = $currentTGroup;

        return $this;
    }

    /**
     * Get currentTGroup
     *
     * @return \Tk\GroupBundle\Entity\TGroup 
     */
    public function getCurrentTGroup()
    {
        return $this->currentTGroup;
    }
}
