<!--
	Internal Development use only
	Access to LocalDB
	Created by Zoltan Gal	
-->

<html>
<body>

<h1>SQL Injector</h1>

<?php
							
	$con = mysql_connect("99.236.89.35","root","toor");
	if (!$con)
	  {
	  die("Could not connect: " . mysql_error());
	  }
	mysql_select_db("germanapdb", $con);	
	$sql = "$_POST[sqlQuery]";
	if ($sql != "" || $sql != null)
	{
		if (!mysql_query($sql,$con))
		{
			die("Error: " . mysql_error());
		}
		else
		{
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				for ($i =0; $i< count($row)/2; $i++)
				{
					echo $row[$i] . " ";
				}
				echo "<br/>";
			}					
		}
	}		
?>

<form id="sqlForm" name="sqlForm" action="hiddenSql.php" method="post">
<textarea name="sqlQuery" id="sqlQuery" rows="10" cols="30"></textarea>
<input type="submit" value="Exectue Query" />
</form>


</body>
</html> 