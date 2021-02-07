<?php

class XORCipher
{

    public function cipher($plaintext, $key)
    {
        $key = (int) $key;
        $plaintext = $this->text2ascii($plaintext);

        $input_size = count($plaintext);

        $cipher = "";

        for ($i = 0; $i < $input_size; $i++)
            $cipher .= chr($plaintext[$i] ^ $key);

        return $cipher;
    }

    /*public function crack($cipher, $keysize)
    {
        $cipher = $this->text2ascii($cipher);
        $occurences = $key = array();
        $input_size = count($cipher);

        for ($i = 0; $i < $input_size; $i++) {
            $j = $i % $keysize;
            if (++$occurences[$j][$cipher[$i]] > $occurences[$j][$key[$j]])
                $key[$j] = $cipher[$i];
        }

        return $this->ascii2text(array_map(function ($v) {
            return $v ^ 32;
        }, $key));
    }*/

    public function plaintext($cipher, $key)
    {
        $key = (int) $key;
        $cipher = $this->text2ascii($cipher);
        $input_size = count($cipher);
        $plaintext = "";

        for ($i = 0; $i < $input_size; $i++)
            $plaintext .= chr($cipher[$i] ^ $key);

        return $plaintext;
    }

    public function text2ascii($text)
    {
        return array_map('ord', str_split($text));
    }

    public function ascii2text($ascii)
    {
        $text = "";
        // var_dump($ascii);
        // die;
        foreach ($ascii as $char)
            $text .= chr($char);

        return $text;
    }
}
