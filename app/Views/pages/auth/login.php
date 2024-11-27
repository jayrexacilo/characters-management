<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Login<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <div class="form-container mx-auto mt-5">
        <h3 class="mb-4">Log-In</h3>
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="email" class="form-control mb-5" id="password">
            </div>
            <button type="submit" class="btn btn-submit w-100 text-uppercase text-sm mt-5">Log In</button>
        </form>
    </div>

<?= $this->endSection() ?>
