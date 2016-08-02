<?php 
 namespace ADEPSOFT\ComunBundle\Enums;
 class EEstado {
     const Vacío = 1;         // Para indicar que no existen datos de referencia en este periodo
     const Elaboracion = 2;   // Anteproyecto en edición
	 const Aprobado = 3;      // El anteproyecto se aprueba, pero es posible su edición
	 const Terminado = 4;     // El anteproyecto se termina y no es posible modificarlo
                              // Toda la información de su manejo se borra

}
 ?>