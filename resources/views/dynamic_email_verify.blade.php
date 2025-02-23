<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

<title>Email mail de contact suggestion</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12 card">
					<div class="card-header text-center">
						Mail de contact
					</div>
					<!-- formulaire -->
					<div class="card-body">

						<p>Salut, c'est {{ $data['name'] }}</p>
						<p>J'ai une requête comme {{ $data['message'] }}.</p>
						<p>Ce serait apprécié, si vous êtes passé par cette rétroaction.</p>

						
						
					</div>
					<!-- fin -->
					
				</div>
			</div>
		</div>
	</div>
</body>
</html>