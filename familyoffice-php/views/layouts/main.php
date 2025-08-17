<!doctype html>
<html lang="id" data-bs-theme="light">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= htmlspecialchars($title ?? 'FamilyOffice') ?></title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<style>
			:root{--navy:#0b1b3b;--gold:#d4af37}
			body{background:#f6f8fb}
			.sidebar{background:var(--navy);min-height:100vh;color:#fff}
			.sidebar a{color:#fff;text-decoration:none;display:block;padding:.75rem 1rem;border-left:4px solid transparent}
			.sidebar a.active,.sidebar a:hover{background:rgba(255,255,255,.08);border-left-color:var(--gold)}
			.navbar-brand{color:var(--navy) !important}
			.card-hero{background:linear-gradient(135deg,var(--navy),#142857);color:#fff}
			.badge-gold{background:var(--gold)}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<aside class="col-12 col-md-3 col-lg-2 sidebar p-0">
					<div class="p-3 fs-5 fw-bold border-bottom border-light">FamilyOffice</div>
					<nav>
						<a href="/" class="<?= ($active ?? '')==='dashboard'?'active':'' ?>">Dashboard</a>
						<a href="/investors" class="<?= ($active ?? '')==='investors'?'active':'' ?>">Investor</a>
						<a href="/stocks" class="<?= ($active ?? '')==='stocks'?'active':'' ?>">Saham</a>
						<a href="/dividends" class="<?= ($active ?? '')==='dividends'?'active':'' ?>">Dividen</a>
						<a href="/capital" class="<?= ($active ?? '')==='capital'?'active':'' ?>">Modal</a>
						<a href="/reports" class="<?= ($active ?? '')==='reports'?'active':'' ?>">Laporan</a>
						<a href="/admin" class="<?= ($active ?? '')==='admin'?'active':'' ?>">Admin</a>
					</nav>
				</aside>
				<main class="col-12 col-md-9 col-lg-10 p-0 min-vh-100">
					<nav class="navbar bg-white shadow-sm px-3">
						<a class="navbar-brand" href="#">Dashboard</a>
						<div class="ms-auto d-flex align-items-center gap-3">
							<span class="badge badge-gold text-dark">Premium</span>
							<form method="post" action="/logout"><button class="btn btn-outline-dark btn-sm">Logout</button></form>
						</div>
					</nav>
					<div class="p-3">
						<?= $content ?? '' ?>
					</div>
				</main>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
		<?= $scripts ?? '' ?>
	</body>
</html>