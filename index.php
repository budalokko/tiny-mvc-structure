<?php
require_once 'vendor/autoload.php';

// Load app settings
/** @var array $settings */
require_once 'settings.php';

$result = (new App($settings))->handle();

// Result array contains the 'url' key it is a redirect
if (isset($result['url'])) {
    header('Location: ' . $result['url']);
    exit();
}

// Otherwise it will contain 'html' key and is "render html"
// 'page_title' key is also expected
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Marc Orcau">
    <title>Give us some feedback</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/styles.css" rel="stylesheet">
</head>
<body class="text-center">

    <div class="container">
        <a href="<?php echo $settings['base_url']; ?>"><img class="mb-4" src="assets/logo.png" alt="" width="80" height="80" /></a>
        <h1 class="h3 mb-3 fw-normal"><?php echo isset($result['page_title']) ? $result['page_title'] : $settings['page_title_default']; ?></h1>
      <?php echo $result['html']; ?>
    </div>

</body>
</html>
