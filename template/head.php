<?
if (session_id() == ""){
    session_start();
}
   
if(!isset($_SESSION['UserUID'])){
        $uid = 0;
        $status = 0;
        $point = 0;
    } else {
        $uid = $_SESSION['UserUID'];
        $status = $_SESSION['Status'];
    
        $query = $conn->prepare('SELECT Point FROM PS_UserData.dbo.Users_Master WHERE UserUID=?');
		$query->bindParam(1, $uid, PDO::PARAM_STR);
        $query->execute();
		$row = $query->fetch(PDO::FETCH_NUM);
        $point = $row[0];
}
?>

<head>
	<title><? echo($pagename); ?> | <?=$SiteName?></title>	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel="shortcut icon" href="img/favicon.ico"/>
	<script src='js/jquery-3.2.1.min.js' type='text/javascript'></script>
	<script src='js/likes.js' type='text/javascript'></script>
    <link rel="stylesheet" href="js/themes/default.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="js/jquery.sceditor.bbcode.min.js"></script>
    <script>
    $(function() {
        // Replace all textarea tags with SCEditor
        $('textarea').sceditor({
            plugins: 'bbcode',
            style: 'minified/jquery.sceditor.default.min.css'
        });
    });
    </script>

    <!-- Begin emoji-picker JavaScript -->
    <script src="js/config.js"></script>
    <script src="js/util.js"></script>
    <script src="js/jquery.emojiarea.js"></script>
    <script src="js/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->

    <script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: 'img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>
    <script>
      // Google Analytics
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49610253-3', 'auto');
      ga('send', 'pageview');
    </script>
</head>