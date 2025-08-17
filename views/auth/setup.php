<?php
$title = 'Setup - FamilyOffice';
$active = '';
ob_start();
$notice = $_SESSION['setup_notice'] ?? null; unset($_SESSION['setup_notice']);
$error = $_SESSION['setup_error'] ?? null; unset($_SESSION['setup_error']);
?>
<div class="row justify-content-center mt-5">
	<div class="col-12 col-lg-7">
		<div class="card border-0 shadow-sm">
			<div class="card-body p-4">
				<h4 class="mb-1" style="color:#0b1b3b;">Instalasi FamilyOffice</h4>
				<p class="text-muted mb-3">Langkah cepat tanpa terminal</p>
				<?php if ($notice): ?><div class="alert alert-success py-2"><?= htmlspecialchars($notice) ?></div><?php endif; ?>
				<?php if ($error): ?><div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div><?php endif; ?>
				<?php if (($step ?? 'db') === 'db' || ($step ?? 'db') === 'migrate'): ?>
				<form method="post" action="/install/db">
					<div class="row g-3">
						<div class="col-md-6"><label class="form-label">App URL</label><input class="form-control" name="APP_URL" placeholder="https://<?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'domain.com') ?>" value="<?= htmlspecialchars($_ENV['APP_URL'] ?? '') ?>"></div>
						<div class="col-md-6"><label class="form-label">DB Host</label><input class="form-control" name="DB_HOST" value="<?= htmlspecialchars($_ENV['DB_HOST'] ?? 'localhost') ?>" required></div>
						<div class="col-md-4"><label class="form-label">DB Port</label><input class="form-control" name="DB_PORT" value="<?= htmlspecialchars($_ENV['DB_PORT'] ?? '3306') ?>" required></div>
						<div class="col-md-8"><label class="form-label">DB Name</label><input class="form-control" name="DB_DATABASE" value="<?= htmlspecialchars($_ENV['DB_DATABASE'] ?? '') ?>" required></div>
						<div class="col-md-6"><label class="form-label">DB User</label><input class="form-control" name="DB_USERNAME" value="<?= htmlspecialchars($_ENV['DB_USERNAME'] ?? '') ?>" required></div>
						<div class="col-md-6"><label class="form-label">DB Password</label><input class="form-control" name="DB_PASSWORD" type="password" value="<?= htmlspecialchars($_ENV['DB_PASSWORD'] ?? '') ?>"></div>
					</div>
					<div class="mt-3"><button class="btn btn-dark">Simpan & Buat Skema</button></div>
				</form>
				<?php elseif (($step ?? '') === 'admin'): ?>
				<form method="post" action="/install">
					<div class="row g-3">
						<div class="col-md-6"><label class="form-label">Nama</label><input class="form-control" name="name" required></div>
						<div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
						<div class="col-md-6"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
					</div>
					<div class="mt-3"><button class="btn btn-dark">Buat Admin</button></div>
				</form>
				<?php else: ?>
				<div class="text-center py-3">
					<div class="mb-2">Instalasi selesai.</div>
					<a href="/login" class="btn btn-dark">Lanjut ke Login</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>