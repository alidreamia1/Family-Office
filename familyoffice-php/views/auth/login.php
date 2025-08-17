<?php
$title = 'Login - FamilyOffice';
$active = '';
ob_start();
?>
<div class="row justify-content-center mt-5">
	<div class="col-12 col-md-5 col-lg-4">
		<div class="card shadow-sm">
			<div class="card-body">
				<h5 class="card-title mb-3">Masuk</h5>
				<form method="post" action="/login">
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input type="email" class="form-control" name="email" placeholder="you@example.com" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" class="form-control" name="password" required>
					</div>
					<button class="btn btn-dark w-100">Login</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>