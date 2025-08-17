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
			.sidebar{background:var(--navy);min-height:100vh;color:#fff;transition:width .2s ease;white-space:nowrap}
			.sidebar .brand{font-weight:700}
			.sidebar a{color:#fff;text-decoration:none;display:flex;align-items:center;gap:.6rem;padding:.75rem 1rem;border-left:4px solid transparent}
			.sidebar a .dot{display:inline-block;width:.5rem;height:.5rem;border-radius:50%;background:var(--gold)}
			.sidebar a.active,.sidebar a:hover{background:rgba(255,255,255,.08);border-left-color:var(--gold)}
			.navbar-brand{color:var(--navy) !important}
			.card-hero{background:linear-gradient(135deg,var(--navy),#142857);color:#fff}
			.badge-gold{background:var(--gold)}
			/****** Collapsible ******/
			.sidebar{width:240px}
			body.sidebar-collapsed .sidebar{width:72px}
			body.sidebar-collapsed .sidebar a .label{display:none}
			body.sidebar-collapsed .sidebar .brand .label{display:none}
			body.sidebar-collapsed main{width:calc(100% - 72px)}
		</style>
	</head>
	<body class="<?= !empty($_COOKIE['sb_collapsed']) && $_COOKIE['sb_collapsed']==='1' ? 'sidebar-collapsed' : '' ?>">
		<div class="container-fluid">
			<div class="row">
				<aside class="col-auto sidebar p-0">
					<div class="p-3 fs-5 border-bottom border-light d-flex align-items-center gap-2 brand"><span class="dot"></span><span class="label">FamilyOffice</span></div>
					<nav>
						<a href="/" class="<?= ($active ?? '')==='dashboard'?'active':'' ?>"><span class="dot"></span><span class="label">Dashboard</span></a>
						<a href="/investors" class="<?= ($active ?? '')==='investors'?'active':'' ?>"><span class="dot"></span><span class="label">Investor</span></a>
						<a href="/stocks" class="<?= ($active ?? '')==='stocks'?'active':'' ?>"><span class="dot"></span><span class="label">Saham</span></a>
						<a href="#" class="<?= ($active ?? '')==='dividends'?'active':'' ?>"><span class="dot"></span><span class="label">Dividen</span></a>
						<a href="#" class="<?= ($active ?? '')==='capital'?'active':'' ?>"><span class="dot"></span><span class="label">Modal</span></a>
						<a href="/reports" class="<?= ($active ?? '')==='reports'?'active':'' ?>"><span class="dot"></span><span class="label">Laporan</span></a>
						<a href="#" class="<?= ($active ?? '')==='admin'?'active':'' ?>"><span class="dot"></span><span class="label">Admin</span></a>
						<a href="#" class="<?= ($active ?? '')==='tax'?'active':'' ?>"><span class="dot"></span><span class="label">Pajak</span></a>
					</nav>
				</aside>
				<main class="col p-0 min-vh-100">
					<nav class="navbar bg-white shadow-sm px-3">
						<button id="btnToggle" class="btn btn-outline-secondary btn-sm" type="button" title="Collapse sidebar">≡</button>
						<a class="navbar-brand ms-2" href="#">Dashboard</a>
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
		<script>
		(function(){
			var btn=document.getElementById('btnToggle');
			if(btn){
				btn.addEventListener('click',function(){
					document.body.classList.toggle('sidebar-collapsed');
					document.cookie = 'sb_collapsed=' + (document.body.classList.contains('sidebar-collapsed')? '1':'0') + '; path=/; max-age='+(60*60*24*365);
				});
			}
		})();
		</script>
		<?= $scripts ?? '' ?>
	</body>
</html>