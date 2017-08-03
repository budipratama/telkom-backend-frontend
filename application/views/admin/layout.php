<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $title_page?> | CMS tMoney</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include('css_content.php'); ?>
    <?php include_once('js_content.php'); ?>
  </head>
  <body class="skin-red sidebar-mini">
    <div class="loading">Loading&#8230;</div>
    <div class="wrapper">
      <header class="main-header">
          <?php include_once('header.php'); ?>
      </header>
      <aside class="main-sidebar">
          <?php include_once('menu_sidebar.php'); ?>
      </aside>
      <div class="content-wrapper">
          <?php $this->load->view($content_page); ?>
      </div>
      <footer class="main-footer">
          <?php include_once('footer.php'); ?>
      </footer>
    </div>
  </body>
</html>
