<?php
$title = 'Instalasi - FamilyOffice';
$active = '';
ob_start();
?>
<div class="row justify-content-center mt-5">
	<div class="col-12 col-md-6 col-lg-5">
		<div class="card shadow-sm">
			<div class="card-body">
				<h5 class="card-title mb-3">Instalasi Awal</h5>
				<p>Buat akun Admin pertama.</p>
				<form method="post" action="/install">
					<div class="mb-2"><label class="form-label">Nama</label><input class="form-control" name="name" required></div>
					<div class="mb-2"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
					<div class="mb-2"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
					<button class="btn btn-dark w-100">Buat Admin</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>