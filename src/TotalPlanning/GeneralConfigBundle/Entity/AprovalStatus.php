<?php

namespace TotalPlanning\GeneralConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="aprovalStatus")
 * @ORM\Entity(repositoryClass="TotalPlanning\GeneralConfigBundle\Repository\AprovalStatusRepository")
 */
class AprovalStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="AprovalStatus_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="AprovalStatus", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Campo obligatorio")
     */
    private $AprovalStatus;
   

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
     * Set AprovalStatus
     *
     * @param string $AprovalStatus
     * @return Menu
     */
    public function setAprovalStatus($AprovalStatus)
    {
        $this->AprovalStatus = $AprovalStatus;

        return $this;
    }

    /**
     * Get AprovalStatus
     *
     * @return string
     */
    public function getAprovalStatus()
    {
        return $this->AprovalStatus;
    }

   


}