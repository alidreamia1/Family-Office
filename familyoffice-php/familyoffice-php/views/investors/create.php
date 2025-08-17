<?php
$title = 'Tambah Investor - FamilyOffice';
$active = 'investors';
ob_start();
?>
<h5 class="mb-3">Tambah Investor</h5>
<div class="card">
	<div class="card-body">
		<form method="post" action="/investors">
			<div class="row g-3">
				<div class="col-md-6">
					<label class="form-label">Nama</label>
					<input class="form-control" name="name" required>
				</div>
				<div class="col-md-6">
					<label class="form-label">Email</label>
					<input type="email" class="form-control" name="email" required>
				</div>
				<div class="col-md-4">
					<label class="form-label">NIK</label>
					<input class="form-control" name="national_id">
				</div>
				<div class="col-md-4">
					<label class="form-label">RDN</label>
					<input class="form-control" name="rdn_account">
				</div>
				<div class="col-md-4">
					<label class="form-label">Bank</label>
					<input class="form-control" name="bank_name">
				</div>
			</div>
			<div class="mt-3"><button class="btn btn-dark">Simpan</button></div>
		</form>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';