<?php

if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){


  echo "<div align=center><h5>You are already logged in</h5></div>";

}
else{
  try{
    $config = include 'conf.php';
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    if(isset($_POST['submit'])){
      //$creds = mysqli_query($conx,"SELECT * FROM users WHERE username='".$_POST['username']."' AND password='".md5($_POST['password'])."'");
      //$creds = mysqli_fetch_array($creds);
      $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      $consulta = "SELECT username, password FROM users WHERE username LIKE ? AND password LIKE ?";
      $sentencia = $conexion->prepare($consulta);
      $sentencia->bindParam(1, $username);
      $sentencia->bindParam(2, $data['password']);
      $sentencia->execute();
      $user = $sentencia->fetchAll(); 
      if($user){
          $_SESSION['username'] = $user['username'];
          $_SESSION['password'] = $user['password'];
          $_SESSION['admin'] = 1;
          header("Location: ".$_SERVER['PHP_SELF']);
      }
      else{
          header("Location: ".$_SERVER['PHP_SELF']."?action=login");
      }

      }
      else{

    ?>

    <div align=center>
      <fieldset style=width:300;>
      <legend><b>Login</b></legend>
          <form action="<?php echo $_SERVER['PHP_SELF']."?action=login"; ?>" method="post">
              <br>
              Username/Email: <input type=text name=username><br>
              Password: <input type=password name=password><br>
              <br><input type=submit name="submit" value=Login><br>
          </form>
      </fieldset>
    </div>

    <?php

      }
  }
    catch(PDOException $error){
      echo "Error al cargar.";
    }
}

?>