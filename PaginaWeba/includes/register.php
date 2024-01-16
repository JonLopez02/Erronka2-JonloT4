<?php

	try{
		$config = include 'conf.php';
		$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

		if (isset($_POST['submit'])) {

			$data = array(
				"username" => $_POST['username'],
				"firstname" => $_POST['firstname'],
				"lastname" => $_POST['lastname'],
				"postcode" => $_POST['postcode'],
				"city"  => $_POST['city'],
				"stateProv"  => $_POST['stateProv'],
				"country"  => $_POST['country'],
				"telephone" => $_POST['telephone'],
				"password"  => md5($_POST['password']),
				"password2"  => $_POST['password2'],
				"imagen"  => '',
			);

			$username = filter_var($data['username'], FILTER_SANITIZE_STRING);
			$usernames = filter_var($username, FILTER_SANITIZE_EMAIL);
			$firstname = filter_var($data['firstname'], FILTER_SANITIZE_STRING);		
			$lastname = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
			$postcode = filter_var($data['postcode'], FILTER_SANITIZE_NUMBER_INT);
			$city = filter_var($data['city'], FILTER_SANITIZE_STRING);
			$stateProv = filter_var($data['stateProv'], FILTER_SANITIZE_STRING);
			$country = filter_var($data['country'], FILTER_SANITIZE_STRING);
			$telephone = filter_var($data['telephone'], FILTER_SANITIZE_NUMBER_INT);

			$consulta = "INSERT INTO users (username, password, izena, abizena, hiria, lurraldea, herrialdea, postakodea, telefonoa, irudia) VALUES (:username, :password, :izena, :abizena, :hiria, :lurraldea, :herrialdea, :postakodea, :telefonoa, :irudia)";
			$sentencia = $conexion->prepare($consulta);
			$sentencia->bindParam(':username', $usernames);
			$sentencia->bindParam(':password', $data['password']);
			$sentencia->bindParam(':izena', $firstname);
			$sentencia->bindParam(':abizena', $lastname);
			$sentencia->bindParam(':hiria', $city);
			$sentencia->bindParam(':lurraldea', $stateProv);
			$sentencia->bindParam(':herrialdea', $country);
			$sentencia->bindParam(':postakodea', $postcode);
			$sentencia->bindParam(':telefonoa', $telephone);
			$sentencia->bindParam(':irudia', $data['imagen']);
			$sentencia->execute();
			header("Location: index.php");
		}
	}catch(PDOException $error){
		echo "Error" . $error->getMessage();;
	}

?>
<div class="content">
	<br/>
	<div class="register">
		<h2>Erregistroa egin</h2>
		<br/>

		<b>Introduce la información.</b>
		<br/>
		<form action="<?php echo $_SERVER['PHP_SELF']."?action=register"; ?>" method="POST" enctype="multipart/form-data">
			<p>
				<label for="username">Email/username: </label>
				<input type="text" name="username" id="username">
			<p>
			<p>
				<label for="firstname">Izena: </label>
				<input type="text" name="firstname"  />
			<p>
			<p>
				<label>Abizena: </label>
				<input type="text" name="lastname" />
			<p>
			<p>
				<label>Hiria: </label>
				<input type="text" name="city" />

			<p>
			<p>
				<label>Lurraldea: </label>
				<input type="text" name="stateProv" />			
			<p>
			<!-- // *** validation: implement a database lookup -->
			<p>
				<label>Herrialdea: </label>
				<input type="text" name="country" />		
			<p>
			<p>
				<label>Postakodea: </label>
				<input type="text" name="postcode"/>		
			<p>
			<p>
				<label>Telefonoa: </label>
				<input type="text" name="telephone" />		
			<p>
			<p>
				<label>Pasahitza: </label>
				<input type="password" name="password"  />	
			<p>
            <p>
                <label>Pasahitza errepikatu: </label>
                <input type="password" name="password2"  />
            <p>
            <p>
                <label>Irudia aukeratu:</label>
                <input name="imagen" type="file" />
            <p>
			<p>
				<input type="reset" name="clear" value="Clear" class="button"/>
				<input type="submit" name="submit" value="Submit" class="button marL10"/>
			<p>
		</form>
	</div>
</div>
