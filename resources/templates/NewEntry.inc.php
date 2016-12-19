<?php
  /**
  *
  *   @author Samih Soylu
  *
  **/

  ## Once a new entry is submitted, a success message is shown.
  # Meanwhile the if statement disables the forum.
  if(isset($_POST['AddNewEntry'])) {
    $a = true;
  } else {
    $a = false;
  }

?>
    <main>
        <article>
        <h2>Add new entry</h2>
            <form method="post">
                <label>Give your entry a title</label>
                <input type="text" name="title" maxlength="100" value="<?php echo @$_POST['title']; ?>" <?php if($a) { echo "disabled"; } ?> required />
                <span>The title helps define the entry and how users will see it.</span>
                <label>Describe your entry in more detail</label>
                <textarea name="desc" maxlength="65000" <?php if($a) { echo "disabled"; } ?> required><?php echo @$_POST['desc']; ?></textarea>
                <span>Add as much information as you would like</span>
                <input type="submit" name="AddNewEntry" value="Add entry" <?php if($a) { echo "disabled"; } ?> />
            </form>
            <?php
              if(@$AddEntrySuccess) {
                echo '<p class="success">Successfully added!</p>';
              }
            ?>
        </article>
    </main>