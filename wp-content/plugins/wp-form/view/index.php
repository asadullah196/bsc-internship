<!DOCTYPE html>
<html>

	<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>HTML5 Form Test | Asadullah Galib</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico in the root directory -->
		<link rel="icon" href="image/icon/asad-icon.png" type="image/icon" sizes="">

		<!-- CSS here -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">

		<!--Responsive CSS if needed 
        <link rel="stylesheet" href="css/responsive.css">
		-->
    </head>
	<body>
		<!-- Header Area Start -->
		<header>
			<div class="header-area" style="background-image:url(image/background/slider-bg-1.jpg)">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-6 offset-xl-3">
							<div class="main-menu">
								<nav>
									<ul>
										<li><a href="#">Home  +</a>
											<ul class="submenu">
												<li><a href="#">Input Form</a></li>
												<li><a href="#">Output Form</a></li>
											</ul>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- Header Area End -->

		<main>
			<section class="body-area">
				<div class="registration-form">
					<h4>Registration Form</h4>
					<p>Please eneter your personal details below</p>
					<hr>
					<div class="registration-input">
						<form action="/action_page.php">

							<label>Enter your name</label><br>
							<input type="text" id="fname" name="fname" placeholder="First Name">
							<input type="text" id="lname" name="lname" placeholder="Last Name"><br><br>

							<label>Enter your phone and email</label><br>
							<input type="text" id="phone" name="phone" placeholder="Phone number">
							<input type="text" id="email" name="email" placeholder="Email address"><br><br>

							<label>Enter your address</label><br>
							<input type="text" id="address1" name="address1" placeholder="Address line 1">
							<input type="text" id="address2" name="address2" placeholder="Address line 2"><br><br>
							<input type="text" id="zipcode" name="zipcode" placeholder="zip code">
							<input type="text" id="city" name="city" placeholder="City"><br><br>
							<input type="text" id="state" name="state" placeholder="State">
							<input type="text" id="country" name="country" placeholder="Country"><br><br>

							<input type="submit" value="Submit">
						</form> 
					</div>
				</div>
			</section>
		</main>
		<footer></footer>

	</body>
</html>