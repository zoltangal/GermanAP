<!DOCTYPE html>

<!-- 
Last Revised: Zoltan
-->

<html>

<head>
<title>German Auto Parts</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

	<h1>German Auto Parts</h1>
	<h2> Find all your OEM and Performace parts here!</h2>


	<?php	
	
	
		// Create connection string, Note, params are as follow
		// mysql_connect(databaseLocation, username, password)
		$con = mysql_connect("99.236.89.35","root","toor");
		if (!$con)
		  {
		  die("Could not connect: " . mysql_error());
		  }
		
		// Populate Make dropdown when user first enters the site
		mysql_select_db("germanapdb", $con);
		$sql = "SELECT makeid, makename FROM makes WHERE modcat='G';";
		$result = mysql_query($sql);
		$makeDDList="";
		while($row = mysql_fetch_array($result))
		{
			$makeid=$row["makeid"];
			$makeName=$row["makename"];
			$makeDDList.="<OPTION VALUE=\"$makeid\">".$makeName.'</option>';
		}

		// Populate Model Dropdown if query string is found
		if(isset($_GET['makeid']) && $_GET['makeid'] != '') {
			// Populate dropdown
			// Select current make from dropdown
			
			$makeid = $_GET['makeid'];
			$sql = "SELECT DISTINCT ym.modelid, m.modelName FROM ymmcoverage ym INNER JOIN models m ON (ym.modelid = m.modelid) WHERE makeid ='$makeid' ORDER BY m.modelName;";
			$result = mysql_query($sql);
			$modelDDList="";
			while($row = mysql_fetch_array($result))
			{
				$modelid=$row["modelid"];
				$modelName=$row["modelName"];
				$modelDDList.="<OPTION VALUE=\"$modelid\">".$modelName.'</option>';
			}			
		}
		
		// Populate Year Dropdown if query string is found
		if(isset($_GET['modelid']) && $_GET['modelid'] != '') {
			
			
			$modelid = $_GET['modelid'];
			$sql = "SELECT DISTINCT ym.yearid, y.year FROM ymmcoverage ym INNER JOIN years y ON (ym.yearid = y.yearid) WHERE modelid = '$modelid';";
			$result = mysql_query($sql);
			$yearDDList="";
			while($row = mysql_fetch_array($result))
			{
				$yearid=$row["yearid"];
				$year=$row["year"];
				$yearDDList.="<OPTION VALUE=\"$yearid\">".$year.'</option>';
			}
			// Select current model from dropdown
			
		}
		// Populate Engine Dropdown
		if(isset($_GET['yearid']) && $_GET['yearid'] != '') {
			
			$modelid = $_GET['modelid'];			
			$yearid = $_GET['yearid'];
			
			$sql = "SELECT e.enginenum, e.defaultSize FROM ymmcoverage ym INNER JOIN engine e ON (ym.enginenum = e.enginenum) WHERE ym.modelid = '$modelid' AND ym.yearid = '$yearid';";
			$result = mysql_query($sql);
			$engineDDList="";
			while($row = mysql_fetch_array($result))
			{
				$engineid=$row["enginenum"];
				$engine=$row["defaultSize"];
				$engineDDList.="<OPTION VALUE=\"$engineid\">".$engine.'</option>';
			}
		}
		
		
		
	?> 
	
	
	<script>
		
		function getModelDropdown(makeDD) {
			makeValue = makeDD.value;
			localStorage.makeId = makeDD.value;
			document.getElementById("hidden").innerHTML=makeValue;
			//document.getElementById("currentVehicle").innerHTML=;
			window.location.assign("index.php?makeid="+makeValue);
		}
		
		function getYearDropdown(modelDD) {
			modelValue = modelDD.value;
			localStorage.modelId = modelDD.value;
			document.getElementById("hidden").innerHTML=modelValue;
			window.location.assign("index.php?modelid="+modelValue);
		}
		
		function getEngineDropdown(yearDD) {
			yearValue = yearDD.value;
			localStorage.yearId = yearDD.value;
			document.getElementById("hidden").innerHTML=yearValue;
			window.location.assign("index.php?modelid="+localStorage.modelId+"&yearid="+yearValue);
		}
		
		function getEngineInfo(engineDD) {
			// Stuff
		}
		
		
	</script>
	
	
	
	<div id="centerBox">
		<div id="vehicleSelection">
			<h2> Select Your Vehicle </h2>
			<form action="">
				<select name="Make" onChange="getModelDropdown(this)">
					<option value="0">Make</option>
					<?php echo $makeDDList?> 
				</select>
				
				<select name="Model" onChange="getYearDropdown(this)">
					<option value="0" >Model</option>
					<?php echo $modelDDList?>
				</select>
				<select name="Year" onChange="getEngineDropdown(this)">
					<option value="0">Year</option>
					<?php echo $yearDDList?>
				</select>

				<select name="Engine">
					<option value="" >Engine</option>
					<?php echo $engineDDList?>
				</select>
				<select name="Body">
					<option value="" >Body</option>
					<?php echo $bodyDDList?>
				</select>
			</form>		
		</div>
		<h2 id="CurrentVehicle"></h2>
	</div>

	<h2 id="hidden"></h2>
	
</body>

</html> 
