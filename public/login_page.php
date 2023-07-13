<?php
    if(isset($_POST['submit'])){
        header('Location : chat_client.html');
    }
    $username = $_POST['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat Login Form</title>
</head>
<body>

    <table align="center" bgcolor="#CCCCCC" border="0" cellpadding="0"
    cellspacing="1" width="300">
        <tr>
            <td>
                <form method="post" action="/login">
                    <table bgcolor="#FFFFFF" border="0" cellpadding="3"
                    cellspacing="1" width="100%">
                        <tr>
                            <td align="center" colspan="3"><strong>User
                            Login</strong></td>
                        </tr>
                        <tr>
                            <td width="78">Guest Username</td>
                            <td width="6">:</td>
                            <td width="294"><input id="username" name=
                            "username" type="text"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><input name="submit" type="submit" value=
                            "submit"> <input name="reset" type="reset" value=
                            "reset"></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>