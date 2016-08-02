<?php
/**
 * Created by PhpStorm.
 * User: MATRIX
 * Date: 12/11/2014
 * Time: 10:16
 */

namespace JMS\Serializer\Handler;

interface SubscribingHandlerInterface
{
    /**
     * Return format:
     *
     * array(
     * array(
     * 'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
     * 'format' => 'json',
     * 'type' => 'DateTime',
     * 'method' => 'serializeDateTimeToJson',
     * ),
     * )
     *
     * The direction and method keys can be omitted.
     *
     * @return array
     */
    public static function getSubscribingMethods();
}