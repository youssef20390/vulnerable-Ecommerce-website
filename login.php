<?php include "init.php"; 
      session_start();
?>
<?php if(isset($_SESSION["signup-username-exists"])){  ?>
		<div class="alert alert-danger text-center"style="position: fixed; top: 100px; right: 780px; z-index: 100;">
			<?php echo $_SESSION["signup-username-exists"]; ?>
		</div>
<?php };
	unset($_SESSION["signup-username-exists"]);       
?>


	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4">Log In</h4>
											<form action="includes/logic/loginLogic.php" method="POST">
												<?php if(isset($_SESSION["Userserror"])){  ?>
														<div class="alert alert-danger text-center">
															<?php echo $_SESSION["Userserror"]; ?>
														</div>
												<?php };
													unset($_SESSION["Userserror"]);       
												?>
												<div class="form-group">
													<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
													<i class="input-icon uil uil-at"></i>
												</div>	
												<div class="form-group mt-2">
													<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<input type="submit" class="btn mt-4">
												<p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
											</form>
				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4">Sign Up</h4>
											<form action="includes/logic/signupLogic.php" method="POST">
												<div class="form-group">
													<input type="text" name="logname" class="form-style" placeholder="Your Name" id="logname" autocomplete="off">
													<i class="input-icon uil uil-user"></i>
												</div>	
												<div class="form-group mt-2">
													<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
													<i class="input-icon uil uil-at"></i>
												</div>	
												<div class="form-group mt-2">
													<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<input type="submit" class="btn mt-4">
											</form>
				      					</div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>


<?php include "includes/templates/footer.php";  ?>