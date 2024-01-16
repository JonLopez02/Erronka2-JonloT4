<?php
$search="";
$testua="";
if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $testua = htmlspecialchars($_GET['keyword'], ENT_SUBSTITUTE, UTF-8);
}
$search = "'%" . $testua . "%'";

$config = include 'conf.php';
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
//$consultaSQL = "SELECT * FROM produktuak WHERE izena LIKE " . $search . " OR deskripzioa LIKE " . $search ;
$consultaSQL = "SELECT * FROM produktuak WHERE izena LIKE ? OR deskripzioa LIKE ?";
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->bindParam(1, $search);
$sentencia->bindParam(2, $search);
$sentencia->execute();
$prod = $sentencia->fetchAll();
if(sizeof($prod) == 0){
    echo "<fieldset style=width:500;>";
    echo "<legend><b>Ez dago produkturik katalogoan ".$testua." deitzen denik</b></legend>";
    if(isset($_SESSION['admin'])){
      echo "<div align=center><h3><b><a href=".$_SERVER['PHP_SELF']."?action=updel>Eguneratu</a> katalogoa.</b></h3></div>";
    }
    else{
      echo "<div align=center>
                <h3>Enpresaren hasierako orria</h3></div>";
    }
    echo "</fieldset>";
}
else{
?>
    <table width=1000 cellpadding=10 cellspacing=10 align=center>
    <?php
    foreach($prod as $data){
        ?>

        <tr>
            <td align=center valign=top width=40%>
                <fieldset>
                <br>
                <a href=<?php echo "images/".$data["pic"]; ?>><img src=images/<?php echo $data["pic"]; ?> border=1></a><br>
                <br>
                </fieldset>
            </td>
            <td valign=top width=60%>
                <fieldset>
                    <legend><b>Izena</b></legend>
                    <br>
                    <?php echo $data['izena']; echo " - ".$data['salneurria']. "€";?>
                    <br>
                </fieldset>
                <fieldset>
                    <legend><b>Deskripzioa</b></legend>
                    <br>
                    <?php echo $data['deskripzioa']; ?>
                    <br>
                </fieldset>
                <br>
                <?php
                if(isset($_SESSION['admin']) && ($_SESSION['admin']==1))
                    {
                        if($_SESSION['username'] == 'admin@bdweb'){
                            ?>
                            <table width=100% cellpadding=2 cellspacing=2 align=center>
                            <tr><td width=50% align=left>
                            <a href=<?php echo $_SERVER['PHP_SELF']."?action=description&pic_id=".$data['id']; ?>><b>Deskripzioa/Salneurria aldatu</b></a>
                            </td>
                            </tr>
                            </table>
                            <?php
                        }
                        else {
                            echo "<a href='><img src='images/pngegg.png'></a>";
                        }
                    }
                ?>
            </td>
        </tr>
    <?php

    }

}

?>

</table>