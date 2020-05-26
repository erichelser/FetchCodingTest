<?
// To use this web service, call EmailChecker.php with POST form-data, and
// the key "data" filled out. The value associated with that key will be
// evaluated according to the requirements.

// Eric Helser
// ehelser@gmail.com
// 5/26/2020

// When POST data is detected,
if(isset($_POST['data']))
{
	// Split input by whitespace and commas
	$emails = preg_split("/[\\s,]+/", $_POST['data']);
	
	// Create an array to identify processed emails, so duplicates are only counted once
	$emailMap = array();
	
	// Process each input email and add it to the map
	foreach($emails as $inputEmail)
	{
		if(strlen(trim($inputEmail)) > 0)
		{
			$processedEmail = processAddress($inputEmail);
			$emailMap[$processedEmail] = 1;
		}
	}
	
	// Print number of unique email addresses as output
	echo count($emailMap);
}
else
{
?>	
<html>
	<head>
		<title>Email Checker - Fetch Coding Test</title>
	</head>
	<body>
		Enter email addresses here:
		
		<p>
		
		<form method=post target=EmailChecker.php name=list>
			<textarea name=data cols=40 rows=10></textarea>
			
			<p>
			
			<input type=submit name=Submit>
		</form>
	</body>
</html>
<?
}

// "Formats" an email address according to Gmail account matching rules
// - ignores all dots (.)
// - anything after a plus (+) is ignored, before the "@" symbol
// Additionally, emails are standardized to lowercase. Emails coming in
// are assumed to be valid email addresses.
function processAddress($email)
{
	list($name, $domain) = explode("@", strtolower($email), 2);
	
	$name = explode("+", $name, 2)[0];
	$name = str_replace(".", "", $name);
	
	return $name."@".$domain;
}
?>