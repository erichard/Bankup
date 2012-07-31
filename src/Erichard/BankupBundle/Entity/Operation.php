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
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * @ORM\Column(type="text")
     */
    private $rawLabel;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="operations")
     */
    private $tags;

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
     * @param Account $account
     * @return Operation
     */
    public function setAccount(Account $account = null)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * Get account
     *
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param Tag $tag
     * @return Operation
     */
    public function addTag(Tag $tag)
    {
        $tag->addOperation($this);
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * Remove tags
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $tag->removeOperation($this);
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set rawLabel
     *
     * @param text $rawLabel
     * @return Operation
     */
    public function setRawLabel($rawLabel)
    {
        $this->rawLabel = $rawLabel;
        return $this;
    }

    /**
     * Get rawLabel
     *
     * @return text
     */
    public function getRawLabel()
    {
        return $this->rawLabel;
    }

    public function hasTagBySlug($slug)
    {
        foreach ($this->tags as $tag) {
            if ($tag->getSlug() === $slug) {
                return true;
            }
        }

        return false;
    }

    public function removeTagBySlug($slug)
    {
        foreach ($this->tags as $tag) {
            if ($tag->getSlug() === $slug) {
                $this->tags->removeElement($tag);
            }
        }
    }
}
