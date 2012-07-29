<?php

namespace Erichard\BankupBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AccountRepository")
 * @ORM\Table(name="account")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity="Operation", mappedBy="account")
     */
    private $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Account
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Account
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
     * Set balance
     *
     * @param integer $balance
     * @return Account
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
        return $this;
    }

    /**
     * Get balance
     *
     * @return integer
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Add operations
     *
     * @param Operation $operations
     * @return Account
     */
    public function addOperation(Operation $operation)
    {
        $operation->setAccount($this);
        $this->operations[] = $operation;
        return $this;
    }

    /**
     * Remove operations
     *
     * @param Operation $operations
     */
    public function removeOperation(Operation $operations)
    {
        $this->operations->removeElement($operations);
    }

    /**
     * Get operations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOperations()
    {
        return $this->operations;
    }
}