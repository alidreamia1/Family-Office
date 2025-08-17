<?php
$title = 'Investor - FamilyOffice';
$active = 'investors';
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h5 class="mb-0">Daftar Investor</h5>
	<a href="/investors/create" class="btn btn-dark">Tambah Investor</a>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead class="table-light">
				<tr>
					<th>Nama</th><th>Email</th><th>NIK</th><th>KYC</th><th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($list as $row): ?>
				<tr>
					<td><?= htmlspecialchars($row['name']) ?></td>
					<td><?= htmlspecialchars($row['email']) ?></td>
					<td><?= htmlspecialchars($row['national_id'] ?? '-') ?></td>
					<td><span class="badge bg-secondary"><?= htmlspecialchars($row['kyc_status']) ?></span></td>
					<td class="text-end"><a class="btn btn-sm btn-outline-dark" href="/investors/<?= (int)$row['id'] ?>">Detail</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>