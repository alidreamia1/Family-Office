<?php
$title = 'Dashboard - FamilyOffice';
$active = 'dashboard';
ob_start();
?>
<div class="row g-3">
	<div class="col-12">
		<div class="card card-hero shadow-sm">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h4 class="mb-1">Ringkasan Kekayaan</h4>
						<p class="mb-0">Selamat datang kembali!</p>
					</div>
					<div class="text-end">
						<div>Total Modal: <strong>Rp <?= number_format($totals['capital'],0,',','.') ?></strong></div>
						<div>Total Dividen: <strong>Rp <?= number_format($totals['dividends'],0,',','.') ?></strong></div>
						<div>Nilai Saham: <strong>Rp <?= number_format($totals['stocks_value'],0,',','.') ?></strong></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-8">
		<div class="card shadow-sm">
			<div class="card-body">
				<h5 class="card-title">Pertumbuhan Portofolio</h5>
				<canvas id="chart-growth" height="120"></canvas>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="card shadow-sm">
			<div class="card-body">
				<h5 class="card-title">Distribusi Aset</h5>
				<canvas id="chart-allocation" height="120"></canvas>
			</div>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
ob_start();
?>
<script>
const ctx = document.getElementById('chart-growth');
new Chart(ctx, { type: 'line', data: { labels: <?= json_encode($chartData['labels']) ?>, datasets: [{ label: 'Total Aset', data: <?= json_encode($chartData['values']) ?>, borderColor: '#d4af37', tension:.3 }] }, options: { plugins:{legend:{display:false}} }});

const ctx2 = document.getElementById('chart-allocation');
new Chart(ctx2, { type: 'doughnut', data: { labels: ['Saham','Properti','Kas','Lainnya'], datasets: [{ data: [55,25,10,10], backgroundColor:['#0b1b3b','#d4af37','#6c757d','#adb5bd'] }] }, options: { plugins:{legend:{position:'bottom'}} }});
</script>
<?php
$scripts = ob_get_clean();
include __DIR__ . '/../layouts/main.php';