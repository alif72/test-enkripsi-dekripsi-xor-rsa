<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload ods and encrypt it</title>
</head>

<body>
    <?php
    if (isset($_POST['enkrip_ods'])) {
        require_once 'proses_upload.php';
        die;
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Spreadsheet File</th>
                <td><input type="file" name="ods"></td>
            </tr>
            <tr>
                <th>Key XOR</th>
                <td><input type="text" name="keyXOR"></td>
            </tr>
            <tr>
                <th>Key E RSA</th>
                <td><input type="text" name="keyE"></td>
            </tr>
            <tr>
                <th>Key N RSA</th>
                <td><input type="text" name="keyN"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="enkrip_ods">Enkrip</button>
                </td>
            </tr>

        </table>
    </form>
</body>

</html>