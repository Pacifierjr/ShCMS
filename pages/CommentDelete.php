<style>
/*

RESPONSTABLE 2.0 by jordyvanraaij
  Designed mobile first!

If you like this solution, you might also want to check out the 1.0 version:
  https://gist.github.com/jordyvanraaij/9069194

*/
.responstable {
  margin: 1em 0;
  width: 100%;
  overflow: hidden;
  background: #FFF;
  color: #024457;
  border-radius: 10px;
  border: 1px solid #167F92;
}
.responstable tr {
  border: 1px solid #D9E4E6;
}
.responstable tr:nth-child(odd) {
  background-color: #EAF3F3;
}
.responstable th {
  display: none;
  border: 1px solid #FFF;
  background-color: #167F92;
  color: #FFF;
  padding: 1em;
}
.responstable th:first-child {
  display: table-cell;
  text-align: center;
}
.responstable th:nth-child(2) {
  display: table-cell;
}
.responstable th:nth-child(2) span {
  display: none;
}
.responstable th:nth-child(2):after {
  content: attr(data-th);
}
@media (min-width: 480px) {
  .responstable th:nth-child(2) span {
    display: block;
  }
  .responstable th:nth-child(2):after {
    display: none;
  }
}
.responstable td {
  display: block;
  word-wrap: break-word;
  max-width: 7em;
}
.responstable td:first-child {
  display: table-cell;
  text-align: center;
  border-right: 1px solid #D9E4E6;
}
@media (min-width: 480px) {
  .responstable td {
    border: 1px solid #D9E4E6;
  }
}
.responstable th, .responstable td {
  text-align: left;
  margin: .5em 1em;
}
@media (min-width: 480px) {
  .responstable th, .responstable td {
    display: table-cell;
    padding: 1em;
  }
}


</style>
<?php 

if($arg == null){ 
$arg = 0;
}
		
		$query = $conn->prepare('SELECT UserUID FROM Website.dbo.Comments WHERE NewID = ?');
		$query->bindParam(1,$arg,PDO::PARAM_INT);
		$query->execute();
		$PUserUID = $query->fetch(PDO::FETCH_ASSOC);
		$PUserUID = $PUserUID['UserUID'];
		
		if(($PUserUID == $uid) || ($status == 16)){
			$query = $conn->prepare('DELETE FROM Website.dbo.Comments WHERE CommentID = ?');
			$query->bindParam(1,$arg,PDO::PARAM_INT);
			$query->execute();		
			
			 		}
?>
<SCRIPT LANGUAGE="JavaScript">
document.location.href="<?=$_SERVER['HTTP_REFERER']?>"
</SCRIPT>