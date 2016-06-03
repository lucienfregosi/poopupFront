<?php
	session_start();
	if(isset($_SESSION['user_id'])) {
		$redirect = "http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/poopupFront';
		header('Location: ' . $redirect);
	}
?>

<link rel="stylesheet" type="text/css" href="css/main.css">
<header class="header-login">
	<img class="logo" src="img/logo.png" alt="" />
</header>
<form id="login" action = "login.validation.php" method="POST"></br>
		<span class="input input--hoshi">
			<input class="input__field input__field--hoshi" type="text" name="login" id="input-4" />
			<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="input-4">
				<span class="input__label-content input__label-content--hoshi">Login</span>
			</label>
		</span>
		<br>
		<span class="input input--hoshi" style="margin-top:40px">
			<input class="input__field input__field--hoshi" type="password" name="mdp" id="input-5" />
			<label class="input__label input__label--hoshi input__label--hoshi-color-2" for="input-5">
				<span class="input__label-content input__label-content--hoshi">Password</span>
			</label>
		</span>
	<input class="button" type="submit" value="log in" />
</form>


	<script src="js/classie.js"></script>
	<script>
		(function() {
			// trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
			if (!String.prototype.trim) {
				(function() {
					// Make sure we trim BOM and NBSP
					var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
					String.prototype.trim = function() {
						return this.replace(rtrim, '');
					};
				})();
			}

			[].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
				// in case the input is already filled..
				if( inputEl.value.trim() !== '' ) {
					classie.add( inputEl.parentNode, 'input--filled' );
				}

				// events:
				inputEl.addEventListener( 'focus', onInputFocus );
				inputEl.addEventListener( 'blur', onInputBlur );
			} );

			function onInputFocus( ev ) {
				classie.add( ev.target.parentNode, 'input--filled' );
			}

			function onInputBlur( ev ) {
				if( ev.target.value.trim() === '' ) {
					classie.remove( ev.target.parentNode, 'input--filled' );
				}
			}
		})();
	</script>
