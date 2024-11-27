<?= $this->extend('main_layout') ?>

<?= $this->section('page_title'); ?>Login<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <?php if($status === 'success'): ?>
    <div class="w-50 mx-auto mt-5 alert alert-success" role="alert">
      <h4 class="alert-heading">Verification Sent!</h4>
      <p>A verification link has been sent to your email address.  
            Please check your inbox and click the link to verify your account.</p>
      <hr>
      <p class="mb-0"><a href="/login" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Log-In</a> / <a href="/login" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Sign-Up</a></p>
    </div>
    <?php else: ?>
    <div class="w-50 mx-auto mt-5 alert alert-danger" role="alert">
      <h4 class="alert-heading">Sorry!</h4>
      <p>Failed to send verification email</p>
      <hr>
      <p class="mb-0"><a href="/resend-verification?email=<?= $email; ?>" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Resend verification</a></p>
    </div>
    <?php endif; ?>


<?= $this->endSection() ?>
