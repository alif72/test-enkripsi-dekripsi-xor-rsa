<?php
require 'XORCipher.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Enkripsi</title>
</head>

<body>
    <h1>XOR dan Rivest Shamir Adleman</h1>
</body>
<?php
$XORCipher = new XORCipher;

// Variable Static Kunci dari RSA
//$e = 7;
//$n = 247;
//$d = 31;
?>
<form action="" method="POST">
    <table border="1">
        <tr>
            <th colspan="2">
                Enkripsi XOR
            </th>
        </tr>
        <tr>
            <td>
                Plaintext
            </td>
            <td>
                <input type="text" name="plaintext" value="<?= isset($_POST['plaintext']) ? $_POST['plaintext'] : '' ?>">
            </td>
        </tr>
        <tr>
            <td>
                Kunci XOR
            </td>
            <td>
                <input type="text" name="keyxor" value="<?= isset($_POST['keyxor']) ? $_POST['keyxor'] : '' ?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" name="enc1">Enkripsi XOR</button>
            </td>
        </tr>
        <?php if (isset($_POST['enc1']) || isset($_POST['enc2']) || isset($_POST['enc3']) || isset($_POST['enc4'])) : ?>
            <?php
            $enc1 = $XORCipher->cipher($_POST['plaintext'], $_POST['keyxor'])
            ?>
            <tr>
                <td>Hasil Enkripsi XOR</td>
                <td><input type="text" value="<?= $enc1; ?>"></td>
            </tr>
            <tr>
                <th colspan="2">
                    Enkripsi RSA
                </th>
            </tr>
            <tr>
                <td>
                    Kunci E
                </td>
                <td>
                    <input type="text" name="kunci_E" value="<?= isset($_POST['kunci_E']) ? $_POST['kunci_E'] : '' ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Kunci N
                </td>
                <td>
                    <input type="text" name="kunci_N" value="<?= isset($_POST['kunci_N']) ? $_POST['kunci_N'] : '' ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="enc2">Enkripsi RSA</button>
                </td>
            </tr>
        <?php endif; ?>
        <?php if (isset($_POST['enc2']) || isset($_POST['enc3']) || isset($_POST['enc4'])) :
            $enc2 = $XORCipher->text2ascii($enc1);
            $res = '';
            foreach ($enc2 as $text2Ascii) {
                $tmp = bcpow($text2Ascii, $_POST['kunci_E']);
                $tmp = bcmod($tmp, $_POST['kunci_N']);
                $res .=  $tmp . " ";
            }
            $ascii = [
                'number' => $res,
                'text' => $XORCipher->ascii2text(explode(' ', trim($res)))
            ];
        ?>
            <tr>
                <td>Hasil Enkripsi RSA (ASCII INT)</td>
                <td><input type="text" name="res_enc_rsa_num" value="<?= $ascii['number']; ?>"></td>
            </tr>
            <tr>
                <td>Hasil Enkripsi RSA (ASCII CHAR)</td>
                <td><input type="text" name="res_enc_rsa_txt" value="<?= $ascii['text']; ?>"></td>
            </tr>
            <tr>
                <td><a href="generate.php?enc=<?= $ascii['text'] ?>&num=<?= $ascii['number'] ?>">Download file.ods</a></td>
            </tr>
            <tr>
                <th colspan="2">
                    Dekripsi RSA
                </th>
            </tr>
            <tr>
                <td>
                    Kunci D
                </td>
                <td>
                    <input type="text" name="kunci_D" value="<?= isset($_POST['kunci_D']) ? $_POST['kunci_D'] : '' ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Kunci N
                </td>
                <td>
                    <input type="text" name="kunci_N1" value="<?= isset($_POST['kunci_N1']) ? $_POST['kunci_N1'] : '' ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="enc3">Dekripsi RSA</button>
                </td>
            </tr>
        <?php endif; ?>
        <?php if (isset($_POST['enc3']) || isset($_POST['enc4'])) :
            $enc2 = explode(' ', trim($res));
            $res2 = '';
            foreach ($enc2 as $text2Ascii) {
                $tmp = bcpow($text2Ascii, $_POST['kunci_D']);
                $tmp1 = bcmod($tmp, trim($_POST['kunci_N1']));
                $res2 .=  $tmp1 . " ";
                $ascii = [
                    'number' => $res2,
                    'text' => $XORCipher->ascii2text(explode(' ', trim($res2)))
                ];
            }
        ?>
            <tr>
                <td>Hasil Dekripsi RSA (ASCII INT)</td>
                <td><input type="text" value="<?= $ascii['number']; ?>"></td>
            </tr>
            <tr>
                <td>Hasil Dekripsi RSA (ASCII CHAR)</td>
                <td><input type="text" value="<?= $ascii['text']; ?>"></td>
            </tr>
            <tr>
                <th colspan="2">
                    Dekripsi XOR
                </th>
            </tr>
            <tr>
                <td>
                    Kunci XOR
                </td>
                <td>
                    <input type="text" name="keyxor2" value="<?= isset($_POST['keyxor2']) ? $_POST['keyxor2'] : '' ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="enc4">Dekripsi XOR</button>
                </td>
            </tr>
        <?php endif; ?>
        <?php if (isset($_POST['enc4'])) : ?>
            <?php $enc4 = $XORCipher->plaintext($ascii['text'], $_POST['keyxor2']) ?>
            <tr>
                <td>Hasil Dekripsi XOR</td>
                <td><input type="text" value="<?= $enc4; ?>"></td>
            </tr>
        <?php endif; ?>
    </table>
</form>

</html>