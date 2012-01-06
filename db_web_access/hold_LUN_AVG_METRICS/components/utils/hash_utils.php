<?php

require_once 'libs/phpass/PasswordHash.php';

define('ENCRYPTION_NONE', 0);
define('ENCRYPTION_MD5', 1);
define('ENCRYPTION_SHA1', 2);
define('ENCRYPTION_PHPASS', 3);

class HashUtils
{
    public static function CreateHasher($encryptionType)
    {
        switch($encryptionType)
        {
            case ENCRYPTION_NONE:
                return new PlainStringHasher();
                break;
            case ENCRYPTION_MD5:
                return new MD5StringHasher();
                break;
            case ENCRYPTION_SHA1:
                return new SHA1StringHasher();
                break;
            case ENCRYPTION_PHPASS:
                return new PHPassStringHasher();
                break;
        }
        throw new Exception('Unknown encryption type');
    }
}

abstract class StringHasher
{
    /**
     * @abstract
     * @param string $string
     * @return string
     */
    public abstract function GetHash($string);

    /**
     * @abstract
     * @param string $hash
     * @param string $string
     * @return boolean
     */
    public function CompareHash($hash, $string)
    {
        return $hash == $this->GetHash($string);
    }
}

class PlainStringHasher extends StringHasher
{
    /**
     * @param string $string
     * @return string
     */
    public function GetHash($string)
    {
        return $string;
    }
}

class MD5StringHasher extends StringHasher
{
    /**
     * @param string $string
     * @return string
     */
    public function GetHash($string)
    {
        return md5($string);
    }
}

class SHA1StringHasher extends StringHasher
{
    /**
     * @param string $string
     * @return string
     */
    public function GetHash($string)
    {
        return sha1($string);
    }
}

class PHPassStringHasher extends StringHasher
{
    /** @var \PasswordHash */
    private $hasher;

    public function __construct()
    {
        $this->hasher = new PasswordHash(8, FALSE);
    }

    /**
     * @abstract
     * @param string $hash
     * @param string $string
     * @return boolean
     */
    public function CompareHash($hash, $string)
    {
        return $this->hasher->CheckPassword($string, $hash);
    }

    /**
     * @param string $string
     * @return string
     */
    public function GetHash($string)
    {
        return $this->hasher->HashPassword($string);
    }
}