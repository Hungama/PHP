<?php

class Encryption 
{
    var $skey = "awdrgyji"; 
     
    public function safe_b64encode($string) 
    {
        $data = base64_encode($string);
        return $data;
    }
 
    public function safe_b64decode($string) 
    {
        $data = str_replace(array('-','_'),array('+','/'),$string);  
        $mod4 = strlen($data) % 4;
        if ($mod4) 
        {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
 
    public function encode($value)
    {
        if(!$value)
        {
            return false;
        }
        $text = $value;
        $crypttext = mcrypt_encrypt(MCRYPT_DES, $this->skey, $text, MCRYPT_MODE_CFB, "awdrgyji");
        return trim($this->safe_b64encode($crypttext));
    }
     
    public function decode($value)
    {
        if(!$value)
        {
            return false;
        }
        $crypttext = $this->safe_b64decode($value);
        $decrypttext = mcrypt_decrypt(MCRYPT_DES, $this->skey, $crypttext, MCRYPT_MODE_CFB, "awdrgyji");
        return trim($decrypttext);
    }
}
 
$str = "msisdn=893227076&serviceid=V11.01500&otp=54212&";
$converter = new Encryption;
$encoded = $converter->encode($str);

$encoded="QjVEwVW1MC9gYyY3vq9i5Xd0MzUKas5zyEp3d0xgiUqz0lWdQDiUfmpu4nHSHj6UZzcPwQ3Ha/B5B7tjL9nAlMAvZQoHLssgZIlwJFkdVl8QH3hT0+WqkgAtpA+KP6ruqD+7DmfOGURFfCG7ew7F+En2rRacI7zqGw==";
$decoded = $converter->decode($encoded);
 
echo "$encoded<p>$decoded";

?>