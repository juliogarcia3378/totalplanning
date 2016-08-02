<?php
namespace ADEPSOFT\Planeacion\AdminBundle\Enums;

use Doctrine\ORM\Mapping as ORM;

class ECategoria {
    const TiempoCompleto=1;
    const MedioTiempo=2;
    const HorasBase = 3;
    const HorasContratoRectoria = 5;
    const HorasContratoIngresosPropios = 6;
}