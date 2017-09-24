<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>

				<title>Registration Page</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<style>label.error { width: 250px; display: inline; color: red;}</style>
		<style type="text/css">#error {color:#ff0000;background-color: #000; list-style:none;}</style>

		<body bgcolor="#000000" text="#FFFFFF">

		<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="jquery.validate.min.js"></script>
		<script type="text/javascript">var RecaptchaOptions = {theme:'clean'};</script>
		<script type="text/javascript">
	$(document).ready(function(){
		$("#myform").validate({
			debug: false,
			rules: {
				username: "required",
				email: {
					required: true,
					email: true
				},
				password: "required",
				password2: "required",
				answer: "required"
				
			},
			messages: {
				username: "Please let us know who you are.",
				email: "A valid email will help us get in touch with you.",
				password: "Please provide a password.",
				password2: "Please confirm your password.",
				answer: "Please provide an answer."
			},
			submitHandler: function(form) {
				$.post('verify.php', $("#myform").serialize(), function(data) {
					$('#results').html(data);
				});
			}
		});
	});
	</script>
	<script type="text/javascript">
            $(document).ready(function(){
                $('#username').change(function(){
                    $.post('verifyuser.php', $("#username"), function(data) {
                        $('#result').html(data);
                    });
                })
            });
       </script>
	</head>
	<body>
		<div id="results"></div>
		<form action="verify.php" id="myform" method="post">
			<div style="width:436px; border:1px solid #000000; padding:16px;">
				<div id="result"></div>
				User Name
				<input name="username" id="username" value="" style="width:100%;" />
				<div style="height: 5px;">&nbsp;</div>
				Password							
				<input name="password" type="password" value="" style="width:100%;" />
				<div style="height: 5px;">&nbsp;</div>
				Confirm Password							
				<input name="password2" type="password" value="" style="width:100%;" />
				<div style="height: 5px;">&nbsp;</div>
				Select a password question<br />
				<select name="question">
				<option value="What is your refferal name">What's your refferal name?</option>
				<option value="What is your favorite movie">What's your favorite movie?</option>
				<option value="What is your favorite animal">What's your favorite animal?</option>
				<option value="Who was your childhood love">Who was your first childhood love?</option>
				<option value="What was your first teachers name">What was your first teacher's name?</option>
				<option value="What is your favorite food">What's your favorite food?</option>
				</select><br />
				Please provide the answer
				<input name="answer" type="text" value=""style="width:100%;" />
				<div style="height: 5px;">&nbsp;</div>
				Please provide your email [You will be unable to change this later]			
				<input name="email" value="" style="width:100%;" />
				<div style="height: 5px;">&nbsp;</div>
				Please type this in the text box below to prove you are human
				<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LdJib8SAAAAAGS2W1GCnT1nJMfbZX4tevzlXVJ8"></script>

	<noscript>
  		<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LdJib8SAAAAAGS2W1GCnT1nJMfbZX4tevzlXVJ8" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
	</noscript>				<div style="height: 5px;">&nbsp;</div>
				<input type="submit" id="submit" name="submit" value="Create Account" />
			</div>
		</form>
	</body>
</html>