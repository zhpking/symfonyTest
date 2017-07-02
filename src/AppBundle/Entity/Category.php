<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Category
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

	/**
     * @ORM\OneToMany(targetEntity="Good", mappedBy="category")
     */
	 private $good;

	public function __construct()
	{
		$this->good = new ArrayCollection();
	}
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Add good
     *
     * @param \AppBundle\Entity\Good $good
     *
     * @return Category
     */
    public function addGood(\AppBundle\Entity\Good $good)
    {
        $this->good[] = $good;

        return $this;
    }

    /**
     * Remove good
     *
     * @param \AppBundle\Entity\Good $good
     */
    public function removeGood(\AppBundle\Entity\Good $good)
    {
        $this->good->removeElement($good);
    }

    /**
     * Get good
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGood()
    {
        return $this->good;
    }
}
