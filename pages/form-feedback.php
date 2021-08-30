<?php
/**
 * @var string $base_url
 */
?>
<main class="form-feedback">
  <form action="<?php echo $base_url; ?>/form-feedback" method="post">
    <div class="form-floating">
      <input type="text" class="form-control" name="name" placeholder="John Doe">
      <label for="floatingInput">Name</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control" name="email" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" name="message" placeholder="Feedback">
      <label for="floatingPassword">Message</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Send</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
  </form>
</main>