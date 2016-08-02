<?php //

namespace  ADEPSOFT\ComunBundle\DataTypes;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Clase para mapear los tipos de datos Bytea
 *
 * @author Franklin Rivero
 */
class ByteaType extends Type{
     const BYTEA = 'bytea';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'bytea';
    }    

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        $val = stream_get_contents($value);
        return base64_decode($val); 
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return base64_encode($value);
    }

    public function getName()
    {
        return self::BYTEA;
    }    
}

?>
