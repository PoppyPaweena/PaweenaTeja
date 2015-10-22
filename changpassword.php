<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "170937", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Change Password form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$oldpassword = trim($_POST['oldpassword']);
		$newpassword = trim($_POST['newpassword']);
		$Confirm = trim($_POST['Confirm']);
		if($Confirm == $newpassword){
		$query = "SELECT * FROM AA_LOGIN WHERE password='$oldpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$query1 = "UPDATE AA_LOGIN SET password='$newpassword' WHERE password='$oldpassword'";
			$parseRequest1 = oci_parse($conn, $query1);
			oci_execute($parseRequest1);
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Change Password Fail.";
		}
	}else{
			echo "Change Password Fail.";
		}};
	oci_close($conn);
?>
<?PHP
	if(isset($_POST['Back'])){
		echo '<script>window.location = "MemberPage.php";</script>';
	}

?>


<form action='changpassword.php' method='post'>
	Old Password <br>
	<input name='oldpassword' type='input'><br>
	New Password<br>
	<input name='newpassword' type='password'><br><br>
	Confirm <br>
	<input name='Confirm' type='input'><br><br>
	<input name='submit' type='submit' value='Save'>
	<input name='Back' type='submit' value='Back'>
</form>
