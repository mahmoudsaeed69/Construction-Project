<?php
session_start();

if (isset($_SESSION['user'])) {

  header("Location:index.html");
}

include "conect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['Signup'])) {

    $name = $_POST['user_name'];

    $email = $_POST['email'];

    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];


    $hideen_pass1 = sha1($pass1);
    $hideen_pass2 = sha1($pass2);


    $erorr_array = array();


    if (isset($name)) {

      $filter_user = filter_var($name, FILTER_SANITIZE_STRING);

      if (strlen($filter_user) < 5) {
        $erorr_array[] = "Please Write The Full Name";
      }

      if (empty($name)) {
        $erorr_array[] = "Can\\' Leave This Input Empty";

      }


    }

    if (isset($email)) {
      $filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);




    }
    if (isset($pass1) && isset($pass2)) {

      if (empty($pass1)) {
        $erorr_array[] = "Can\\' Leave This  Input Empty";

      }

      if ($hideen_pass1 !== $hideen_pass1) {

        $erorr_array[] = "Your Password Is No Mathe";

      } elseif (strlen($pass1) < 6) {

        $erorr_array[] = "Plese Type The Password Langer Than 6 Character";

      } elseif (is_numeric($pass1)) {


        $erorr_array[] = "PassWord Mast Have A Character";


      }

    }


    // cheak if found any errors in array

    if (empty($erorr_array)) {

      // cheak if no found uniqe name

      $stamt = $con->prepare("SELECT f_name FROM user_table WHERE f_name=?");

      $stamt->execute(array($name));

      $rowCont = $stamt->rowCount();

      if ($rowCont == 1) {


        $mes = "<div class='alert alert-danger'> Soory This Name Is Found</div>";



      } else {


        $stam = $con->prepare("INSERT INTO user_table (f_name , email , pass , date)
        VALUES (:n ,:e,:p,date)");

        $stam->execute(
          array(

            ":n" => $name,
            ":e" => $email,
            ":p" => $hideen_pass1

          )
        );

        $row = $stam->rowCount();

        if ($row > 0) {
          $_SESSION['user'] = $name;
          header("Location:index.html");
          exit();
        }


      }


    }



  } else {

    // Named The Varibels
    $email = $_POST['email_user'];
    $pass = $_POST['pass_user'];
    $Passhide = sha1($pass);

    // Cheak If The User Found In The Database

    $stam = $con->prepare("SELECT email , pass FROM user_table WHERE email = ? AND Pass=?");
    $stam->execute(array($email, $Passhide));
    $count = $stam->rowCount();


    // If The Count Row IN Database > 0 
    if ($count > 0) {
      $_SESSION['user'] = $email;
      header('Location:index.html');
      exit();
    }

  }

}

?>



<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login & Signup Form</title>
  <link rel="stylesheet" href="css/style-login.css" />
</head>

<body>
  <section class="wrapper">
    <div class="form signup">
      <header>Signup</header>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="text" name="user_name" placeholder="Full name" required autocomplete="off" />
        <input type="email" name="email" placeholder="Email address" required autocomplete="off" />
        <input type="password" name="pass1" placeholder="Type The Strong PassWord" required
          autocomplete="new-password" />
        <input type="password" name="pass2" placeholder="Write Agine PassWord" required autocomplete="new-password" />
        <div class="checkbox">
          <input type="checkbox" id="signupCheck" />
          <label for="signupCheck">I accept all terms & conditions</label>
        </div>
        <input type="submit" value="Signup" name="Signup" />
        <div class="erorr">

          <?php
          if (!empty($erorr_array)) {
            foreach ($erorr_array as $erorr) {


              echo "<p style='color:red'>$erorr</p> <br>";


            }
          }
          ?>
        </div>
      </form>
    </div>

    <div class="form login">
      <header>Login</header>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="email" name="email_user" placeholder="Email address" required autocomplete="off" />
        <input type="password" name="pass_user" placeholder="Password" required autocomplete="new-password" />
        <a href="#">Forgot password?</a>
        <input type="submit" name="login" value="Login" />
      </form>
    </div>

    <script>
      const wrapper = document.querySelector(".wrapper"),
        signupHeader = document.querySelector(".signup header"),
        loginHeader = document.querySelector(".login header");

      loginHeader.addEventListener("click", () => {
        wrapper.classList.add("active");
      });
      signupHeader.addEventListener("click", () => {
        wrapper.classList.remove("active");
      });
    </script>
  </section>
</body>

</html>