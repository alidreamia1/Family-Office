<?php
$title = 'Detail Investor - FamilyOffice';
$active = 'investors';
ob_start();
?>
<h5 class="mb-3">Detail Investor</h5>
<div class="card mb-3">
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-6"><strong>Nama:</strong> <?= htmlspecialchars($investor['name']) ?></div>
			<div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($investor['email']) ?></div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form method="post" action="/investors/<?= (int)$investor['id'] ?>">
			<div class="row g-3">
				<div class="col-md-4">
					<label class="form-label">NIK</label>
					<input class="form-control" name="national_id" value="<?= htmlspecialchars($investor['national_id'] ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label class="form-label">RDN</label>
					<input class="form-control" name="rdn_account" value="<?= htmlspecialchars($investor['rdn_account'] ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label class="form-label">Bank</label>
					<input class="form-control" name="bank_name" value="<?= htmlspecialchars($investor['bank_name'] ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label class="form-label">Status KYC</label>
					<select class="form-select" name="kyc_status">
						<?php foreach (['PENDING','VERIFIED','REJECTED'] as $s): ?>
						<option value="<?= $s ?>" <?= ($investor['kyc_status'] === $s) ? 'selected' : '' ?>><?= $s ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="mt-3 d-flex gap-2">
				<button class="btn btn-dark">Simpan</button>
				<form method="post" action="/investors/<?= (int)$investor['id'] ?>/delete" onsubmit="return confirm('Hapus investor?')">
					<button class="btn btn-outline-danger">Hapus</button>
				</form>
			</div>
		</form>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>