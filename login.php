<?php
session_start();
include "db_conn.php";
if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    if (empty($uname)) {
        header("Location:index.php?error=User Name is require");
        exit();
    } else if (empty($pass)) {
        header("Location:index.php?error=User Password is require");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE users_name ='$uname'AND password ='$pass'";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['users_name'] === $uname && $row['password'] === $pass) {
                $_SESSION['user_name'] = $row['users_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location:home.php");
                exit();
            } else {
                header("Location:index.php?error=Incorect user name or password");
                exit();
            }
        } else {
            header("Location:index.php?error=Incorect user name or password");
            exit();
        }
    }
} else {
    header("Location:index.php");
    exit();
}
