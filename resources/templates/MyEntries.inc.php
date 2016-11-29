<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/
  if(!isset($_GET['id'])) {
    $UserEntries = $entry_handler->ReadUserEntries($_SESSION['user_id']);

?>
    <main>
        <article>
        <h2>My entries</h2>
            <table>
                <tr>
                    <th width="60%">Title</th> 
                    <th>Created</th> 
                    <th>Last updated</th>
                </tr>
                <?php

                    if($UserEntries != 0) {
                        foreach($UserEntries as $entry) {
                            ?>
                <tr>
                  <td><a href="index.php?p=MyEntries&id=<?php echo $entry['id']; ?>"><?php echo $entry['title']; ?></a></td>
                  <td><?php echo date("D d M Y H:i:s", $entry['date_added']); ?></td>
                  <td><?php echo date("D d M Y H:i:s", $entry['date_modified']); ?></td>
                </tr>
                            <?php
                        }
                    } else {

                ?>
                <tr>
                    <td colspan="3">You have no entries</td>
                </tr>
                <?php } ?>
            </table>
        </article>
    </main>
<?php
  
    } else {

        $entry = $entry_handler->ReadEntry($_GET['id']);

        if($entry != 0) {

          

          foreach($entry as $e) { $_SESSION['entry_id'] = $e['id'];
?>

    <main>
        <article>
        <h2>Update your entry</h2>
            <form method="post">
                <label>Give your entry a title</label>
                <input type="text" name="title" maxlength="100" value="<?php echo $e['title']; ?>" required />
                <span>The title helps define the entry and how users will see it.</span>
                <label>Describe your entry in more detail</label>
                <textarea name="desc" maxlength="65000"  required><?php echo $e['description']; ?></textarea>
                <span>Add as much information as you would like</span>
                <input type="submit" name="UpdateEntry" value="Update entry"  />
            </form>
            <?php
              if(@$UpdateEntrySuccess) {
                echo '<p class="success">Successfully updated!</p>';
              }
            ?>
        </article>
    </main>

<?php
            break;
          } # end of for
        } else {
            echo "<main><article><h2>Entry does not exist</h2></article></main>";
        }
    }

?>