<?php //

namespace  ADEPSOFT\ComunBundle\DataTypes;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Clase para mapear los tipos de datos Bytea
 *
 * @author Franklin Rivero
 */
class ByteaArrayType extends Type{
     const BYTEA_ARRAY = 'byteaArray';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'bytea[]';
    }    

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }
        $r = array();
        foreach($value as $val)
        {
            $content = stream_get_contents($val);
             $r[]= base64_decode($content);
        }
        return $r;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $r = array();
        foreach($value as $val)
        {
//            ld($val);
            $r[]= base64_encode($val);
        }
        return json_encode($r);
    }

    public function getName()
    {
        return self::BYTEA_ARRAY;
    }    
}

?>
