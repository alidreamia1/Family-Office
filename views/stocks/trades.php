<?php
$title = 'Transaksi Saham - FamilyOffice';
$active = 'stocks';
ob_start();
?>
<h5 class="mb-3">Transaksi Saham</h5>
<form class="row g-2 mb-3" method="get">
	<div class="col-sm-4">
		<input class="form-control" name="investor_id" placeholder="Investor ID" value="<?= htmlspecialchars($_GET['investor_id'] ?? '') ?>">
	</div>
	<div class="col-sm-2">
		<button class="btn btn-dark">Tampilkan</button>
	</div>
</form>
<div class="row g-3">
	<div class="col-lg-8">
		<div class="card">
			<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead class="table-light">
						<tr><th>Tanggal</th><th>Kode</th><th>Jenis</th><th>Lot</th><th>Harga</th><th>Fee</th><th>P/L</th></tr>
					</thead>
					<tbody>
						<?php foreach (($trades ?? []) as $t): ?>
						<tr>
							<td><?= htmlspecialchars($t['trade_date']) ?></td>
							<td><?= htmlspecialchars($t['symbol']) ?></td>
							<td><?= htmlspecialchars($t['trade_type']) ?></td>
							<td><?= (int)$t['lots'] ?></td>
							<td><?= number_format($t['price'],0,',','.') ?></td>
							<td><?= number_format($t['fee'],0,',','.') ?></td>
							<td><?= isset($t['realized_pl']) ? number_format($t['realized_pl'],0,',','.') : '-' ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card mb-3">
			<div class="card-body">
				<h6>Beli Saham</h6>
				<form method="post" action="/stocks/buy">
					<input type="hidden" name="investor_id" value="<?= htmlspecialchars($_GET['investor_id'] ?? '') ?>">
					<div class="mb-2"><input class="form-control" name="stock_id" placeholder="Stock ID" required></div>
					<div class="mb-2"><input class="form-control" name="lots" placeholder="Lot" required></div>
					<div class="mb-2"><input class="form-control" name="price" placeholder="Harga" required></div>
					<div class="mb-2"><input class="form-control" name="fee" placeholder="Fee" value="0"></div>
					<div class="mb-2"><input type="date" class="form-control" name="trade_date" required></div>
					<button class="btn btn-dark w-100">Catat Beli</button>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<h6>Jual Saham</h6>
				<form method="post" action="/stocks/sell">
					<input type="hidden" name="investor_id" value="<?= htmlspecialchars($_GET['investor_id'] ?? '') ?>">
					<div class="mb-2"><input class="form-control" name="stock_id" placeholder="Stock ID" required></div>
					<div class="mb-2"><input class="form-control" name="lots" placeholder="Lot" required></div>
					<div class="mb-2"><input class="form-control" name="price" placeholder="Harga" required></div>
					<div class="mb-2"><input class="form-control" name="fee" placeholder="Fee" value="0"></div>
					<div class="mb-2"><input type="date" class="form-control" name="trade_date" required></div>
					<button class="btn btn-outline-dark w-100">Catat Jual</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>