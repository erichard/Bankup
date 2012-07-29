<?php

namespace Erichard\BankupBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OperationRepository")
 * @ORM\Table(name="operation")
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="operations")
     * @var [type]
     */
    private $account;

    /**
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $balance;

    /**
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * Set id
     *
     * @param string $id
     * @return Operation
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
     * Set date
     *
     * @param date $date
     * @return Operation
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set label
     *
     * @param string $label
     * @return Operation
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set balance
     *
     * @param integer $balance
     * @return Operation
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
     * Set account
     *
     * @param Erichard\BankupBundle\Entity\Account $account
     * @return Operation
     */
    public function setAccount(\Erichard\BankupBundle\Entity\Account $account = null)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * Get account
     *
     * @return Erichard\BankupBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }
}