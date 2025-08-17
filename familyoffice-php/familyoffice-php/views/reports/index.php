<?php
$title = 'Laporan - FamilyOffice';
$active = 'reports';
ob_start();
?>
<h5 class="mb-3">Laporan Ringkas</h5>
<div class="card">
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-4">
				<div class="border rounded p-3">
					<div class="small text-muted">Total Modal</div>
					<div class="fs-5 fw-bold">Rp <?= number_format($capital,0,',','.') ?></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="border rounded p-3">
					<div class="small text-muted">Total Dividen</div>
					<div class="fs-5 fw-bold">Rp <?= number_format($dividends,0,',','.') ?></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="border rounded p-3">
					<div class="small text-muted">Nilai Saham</div>
					<div class="fs-5 fw-bold">Rp <?= number_format($positions,0,',','.') ?></div>
				</div>
			</div>
		</div>
		<div class="mt-3">
			<a href="/reports/export/pdf" class="btn btn-dark me-2">Export PDF</a>
			<a href="/reports/export/excel" class="btn btn-outline-dark">Export Excel</a>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>