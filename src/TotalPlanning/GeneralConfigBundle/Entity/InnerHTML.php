<?php

namespace TotalPlanning\GeneralConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rol
 *
 * @ORM\Table(name="config_html_part")
 * @ORM\Entity(repositoryClass="TotalPlanning\GeneralConfigBundle\Repository\HTMLRepository")
 */
class InnerHTML
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="config_html_part_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="denominacion", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Campo obligatorio")
     */
    private $denominacion;
    /**
     * @var string
     *
     * @ORM\Column(name="html", type="text", nullable=false)
     */
    private $html;

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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Menu
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set denominacion
     *
     * @param string $denominacion
     * @return Menu
     */
    public function setHTML($denominacion)
    {
        $this->html= $denominacion;

        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string
     */
    public function getHTML()
    {
        return $this->html;
    }


}