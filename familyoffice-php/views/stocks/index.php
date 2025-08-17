<?php
$title = 'Saham - FamilyOffice';
$active = 'stocks';
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h5 class="mb-0">Daftar Saham (BEI)</h5>
	<form class="d-flex gap-2" method="post" action="/stocks">
		<input class="form-control" name="symbol" placeholder="Kode (ex: BBCA)" required>
		<input class="form-control" name="name" placeholder="Nama Perusahaan">
		<button class="btn btn-dark">Tambah</button>
	</form>
</div>
<div class="card">
	<div class="table-responsive">
		<table class="table table-hover align-middle mb-0">
			<thead class="table-light"><tr><th>Kode</th><th>Nama</th><th class="text-end">Aksi</th></tr></thead>
			<tbody>
				<?php foreach ($list as $row): ?>
				<tr>
					<td class="fw-semibold"><?= htmlspecialchars($row['symbol']) ?></td>
					<td><?= htmlspecialchars($row['name'] ?? '-') ?></td>
					<td class="text-end">
						<form method="post" action="/stocks/<?= (int)$row['id'] ?>/delete" onsubmit="return confirm('Hapus saham ini?')">
							<button class="btn btn-sm btn-outline-danger">Hapus</button>
						</form>
					</td>
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