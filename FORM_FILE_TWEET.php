<html>
<body>
<br/>
<table>
<td>
<tr>
Enter username:
</tr>
<tr>
<form name="user/number" method="post" action="read_into_file.php">
<input type="text" name="user" value="<?php if (isset($_POST['user'])) echo $_POST['user']; ?>">
</tr>
</td>
<td>      </td>
<td>
<tr>
Enter number of tweets to collect and classify:
</tr>
<tr>
<input type="text" name="number" value="<?php if (isset($_POST['number'])) echo $_POST['number']; ?>">&nbsp;
</tr>
</td>

<td>      </td>
<td>
<tr>
Enter class:
</tr>
<tr>
<input type="text" name="class" value="<?php if (isset($_POST['class'])) echo $_POST['class']; ?>">&nbsp;
<input type="submit" name="submit" value="GO"/>
</tr>
</td>

<br></td>
</table>
</form>
</html>