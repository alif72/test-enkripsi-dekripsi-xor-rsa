<?php
class Crypto
{

    public function encrypt($plainText, $keyXOR, $keyE, $keyN)
    {
        $cipherText = $this->textToCipherXOR($plainText, $keyXOR);
        $cipherText = $this->textToCipherRSA($cipherText, $keyE, $keyN);
        return $cipherText;
    }

    public function decrypt($cipherText, $keyXOR, $keyD, $keyN)
    {
        $plainText = $this->cipherRSAToText($cipherText, $keyD, $keyN);
        $plainText = $this->ascii2text(explode(' ', $plainText));
        $plainText = $this->cipherXORToText($plainText, $keyXOR);
        return $plainText;
    }
    /**
     * Fungsi Untuk Meng Enkripsi Teks Dengan Metode XOR
     * params
     * @var $text = 'string'  // plaintext yang ingin dienkrip
     * @var $key = int // kunci untuk enkripsi XOR
     * @return string
     */
    public function textToCipherXOR($text = '', $key = 0)
    {
        $key = (int) $key;
        $text = $this->text2ascii($text); // balikan data, berupa array
        $cipherText = ''; // variable penampung
        foreach ($text as $t) {
            $cipherText .= chr($t ^ $key);
        }
        return $cipherText;
    }

    /**
     * Fungsi Untuk Mendekripsi Teks Dengan Metode XOR
     * params
     * @var $ciphertext = 'string'  // plaintext yang ingin dienkrip
     * @var $key = int // kunci untuk dekripsi XOR
     * @return string
     */

    public function cipherXORToText($ciphertext = '', $key = 0)
    {
        $key = (int) $key;
        $ciphertext = $this->text2ascii($ciphertext);
        $plainText = '';
        foreach ($ciphertext as $c) {
            $plainText .= chr($c ^ $key);
        }
        return $plainText;
    }

    /**
     * Fungsi Untuk Mengubah Sebuah Text Menjadi ASCII Code dalam integer
     * @var $text = 'string'
     * @return array
     */
    public function text2ascii($text = '')
    {
        return array_map('ord', str_split($text));
    }

    /**
     * Fungsi Untuk Mengubah Sebuah Array ASCII code dalam int Menjadi string
     * param 
     * @var $ascii = array()
     * @return string
     */
    public function ascii2text($ascii = array())
    {
        $text = "";
        foreach ($ascii as $char) {
            $text .= chr($char);
        }
        return $text;
    }

    /**
     * Fungsi untuk mengubah Text menjadi cipher RSA
     * Param
     * @var $plainText = 'string' 
     * @var $keyE      = int
     * @var $keyN      = int
     * @return 'string' ASCII code berbentuk integer dipisah oleh spasi 
     */
    public function textToCipherRSA($plainText = '', $keyE = 0, $keyN = 0)
    {
        $plainText = $this->text2ascii($plainText);
        $cipherText = '';
        foreach ($plainText as $asciiCode) {
            $tmp = bcpow($asciiCode, $keyE);
            $tmp = bcmod($tmp, $keyN);
            $cipherText .=  $tmp . " ";
        }
        return trim($cipherText);
    }

    /**
     * Fungsi untuk mengubah Cipher RSA menjadi Text
     * Param
     * @var $cipherText = 'string' // ASCII Code integer dipisah oleh spasi 
     * @var $keyD      = int
     * @var $keyN      = int
     * @return 'string' ASCII code berbentuk integer dipisah oleh spasi 
     */
    public function cipherRSAToText($cipherText = '', $keyD = 0, $keyN = 0)
    {
        $cipherText = explode(' ', $cipherText);
        $plaintText = '';
        foreach ($cipherText as $c) {
            $tmp = bcpow($c, $keyD);
            $tmp = bcmod($tmp, $keyN);
            $plaintText .=  $tmp . " ";
        }
        return trim($plaintText);
    }
}
