<?php
namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;
/**
 * @extends AbstractEnumType<string, string>
 */
final class NotificationTypes extends AbstractEnumType
{
    public const SMS = 'sms';
    public const EMAIL = 'email';
    public const PUSH = 'push';
    public const TG = 'tg';

    protected static array $choices = [
        self::SMS => 'SMS',
        self::EMAIL => 'Email',
        self::PUSH => 'PUSH',
        self::TG => 'tg',
    ];
}