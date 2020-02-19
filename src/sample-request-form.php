<!DOCTYPE html>
<html lang="en">
<head>
  <title>Fund Request Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>

<div class="container">
  <center><h3>Customer Fund Request</h3></center>
		<!-- Default form register -->
		<form class="text-center border border-light p-5" action="process-transfer.php" method="POST">

			<p class="h4 mb-4">Fill in the details correctly and click on 'Request Now'.</p>

			<div class="form-row mb-4">
				<div class="col">
					<!-- First name -->
					<input type="text" name="accname" placeholder="Enter Account Name" required id="" class="form-control">
				</div>
				<div class="col">
					<!-- Last name -->
					<input type="text" name="accno" placeholder="Enter Account Number" required id="" class="form-control">
				</div>
			</div>
			
			<div class="form-row mb-4">
				<div class="col">
					<!-- First name -->
					<input type="number" name="amount" placeholder="Enter Amount" required id="" class="form-control">
				</div>
				<div class="col">
					<!-- Last name -->
					<!--<input type="text" name="bankname" placeholder="Enter Bank Name" required class="form-control">-->
					<select name="bankname" class="form-control">
                                   <option value="Access Bank">
                       Access Bank
                   </option>
                                  <option value="Access Bank (Diamond)">
                       Access Bank (Diamond)
                   </option>
                                  <option value="ALAT by WEMA">
                       ALAT by WEMA
                   </option>
                                  <option value="ASO Savings and Loans">
                       ASO Savings and Loans
                   </option>
                                  <option value="Citibank Nigeria">
                       Citibank Nigeria
                   </option>
                                  <option value="Ecobank Nigeria">
                       Ecobank Nigeria
                   </option>
                                  <option value="Ekondo Microfinance Bank">
                       Ekondo Microfinance Bank
                   </option>
                                  <option value="Fidelity Bank">
                       Fidelity Bank
                   </option>
                                  <option value="First Bank of Nigeria">
                       First Bank of Nigeria
                   </option>
                                  <option value="First City Monument Bank">
                       First City Monument Bank
                   </option>
                                  <option value="Globus Bank">
                       Globus Bank
                   </option>
                                  <option value="Guaranty Trust Bank">
                       Guaranty Trust Bank
                   </option>
                                  <option value="Heritage Bank">
                       Heritage Bank
                   </option>
                                  <option value="Jaiz Bank">
                       Jaiz Bank
                   </option>
                                  <option value="Keystone Bank">
                       Keystone Bank
                   </option>
                                  <option value="Kuda Bank">
                       Kuda Bank
                   </option>
                                  <option value="Parallex Bank">
                       Parallex Bank
                   </option>
                                  <option value="Polaris Bank">
                       Polaris Bank
                   </option>
                                  <option value="Providus Bank">
                       Providus Bank
                   </option>
                                  <option value="Rubies MFB">
                       Rubies MFB
                   </option>
                                  <option value="Sparkle Microfinance Bank">
                       Sparkle Microfinance Bank
                   </option>
                                  <option value="Stanbic IBTC Bank">
                       Stanbic IBTC Bank
                   </option>
                                  <option value="Standard Chartered Bank">
                       Standard Chartered Bank
                   </option>
                                  <option value="Sterling Bank">
                       Sterling Bank
                   </option>
                                  <option value="Suntrust Bank">
                       Suntrust Bank
                   </option>
                                  <option value="TAJ Bank">
                       TAJ Bank
                   </option>
                                  <option value="Union Bank of Nigeria">
                       Union Bank of Nigeria
                   </option>
                                  <option value="United Bank For Africa">
                       United Bank For Africa
                   </option>
                                  <option value="Unity Bank">
                       Unity Bank
                   </option>
                                  <option value="VFD|566">
                       VFD
                   </option>
                                  <option value="Wema Bank">
                       Wema Bank
                   </option>
                                  <option value="Zenith Bank">
                       Zenith Bank
                   </option>
                             </select>
				</div>
			</div>


			<!-- Sign up button -->
			<!--<button class="btn btn-info my-4 btn-block" type="submit">Request Now</button>-->
      <input type="submit" name="submit" value="Request Now" class="btn btn-info my-4 btn-block">
			<hr>

			<!-- Terms of service -->
			<p>By clicking
				<em>Sign up</em> you agree to our
				<a href="" target="_blank">terms of service</a>

		</form>
		<!-- Default form register -->
</div>

</body>
</html>


