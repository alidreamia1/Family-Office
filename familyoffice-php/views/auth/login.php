<?php
$title = 'Login - FamilyOffice';
$active = '';
ob_start();
?>
<div class="row justify-content-center mt-5">
	<div class="col-12 col-md-6 col-lg-5">
		<div class="card border-0 shadow-sm">
			<div class="card-body p-4">
				<div class="text-center mb-3">
					<div class="mx-auto" style="width:56px;height:56px;background:var(--gold);border-radius:14px;display:flex;align-items:center;justify-content:center;color:#000;font-weight:700;">FO</div>
					<h4 class="mt-3" style="color:#0b1b3b;">FamilyOffice</h4>
					<p class="text-muted mb-0">Masuk untuk mengelola portofolio keluarga</p>
				</div>
				<?php if (!empty($_SESSION['login_error'])): ?>
				<div class="alert alert-danger py-2"><?= htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?></div>
				<?php endif; ?>
				<form method="post" action="/login">
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input type="email" class="form-control form-control-lg" name="email" placeholder="you@example.com" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Password</label>
						<input type="password" class="form-control form-control-lg" name="password" required>
					</div>
					<button class="btn btn-dark w-100 btn-lg">Login</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>