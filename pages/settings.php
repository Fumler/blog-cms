<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#pane1" data-toggle="tab">Website</a></li>
    <li><a href="#pane2" data-toggle="tab">User</a></li>
  </ul>
  <div class="tab-content">
    <div id="pane1" class="tab-pane active">
      <h4>Website settings</h4>
      <h5>Style</h5>
      <form action="index.php?id=settings" method="post">
        <label class="radio">
          <input type="radio" name="radio" id="radio1" value="option1" checked> Standard  (Light)
        </label>
        <label class="radio">
          <input type="radio" name="radio" id="radio2" value="option2">Dark
        </label>
        <label class="radio">
          <input type="radio" name="radio" id="radio3" value="option3">Journal
        </label>
        <button class="btn btn-primary" type="submit" >  Save</button>
      </form>
    </div>
    <?php echo "Radio: " . $_POST['radio'];
    $_SESSION['style'] = $_POST['radio'];
    header('Location: '.'/blog-cms/index.php?=settings');


    ?>
    <div id="pane2" class="tab-pane">
    <h4>User settings</h4>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->