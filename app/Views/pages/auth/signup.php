<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Sign Up<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <div class="form-container mx-auto mt-5">
        <h3 class="mb-4">Sign-Up</h3>
        <form>
            <div class="row mb-3">
                <div class="col mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="email" class="form-control" id="firstName">
                </div>
                <div class="col mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="email" class="form-control" id="lastName">
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="email" class="form-control mb-3" id="password" placeholder="New Password">
                <input type="email" class="form-control" id="confirm-password" placeholder="Confirm Password">
            </div>
            <button type="submit" class="btn btn-submit w-100 text-uppercase text-sm">Sign Up</button>
        </form>
    </div>

<?= $this->endSection() ?>
