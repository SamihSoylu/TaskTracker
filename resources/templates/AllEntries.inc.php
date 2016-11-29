<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/

  

  if(!isset($_GET['id'])) {

    $AllEntries = $entry_handler->ReadAllUsersEntries();
?>
    <main>
        <article>
        <h2>All entries</h2>
            <table>
                <tr>
                    <th width="20%">Name</th>
                    <th>Entry Title</th> 
                    <th width="20%">Created</th>
                    <th width="20%">Last updated</th>
                </tr>
                  <?php

                    if($AllEntries != 0) {
                        foreach($AllEntries as $entry) {
                            ?>
                <tr>
                  <td><?php echo $entry['name']; ?></td>
                  <td><a href="index.php?p=AllEntries&id=<?php echo $entry['entry_id']; ?>"><?php echo $entry['title']; ?></a></td>
                  <td><?php echo date("d M", $entry['date_added']); ?></td>
                  <td><?php echo date("d M, H:i", $entry['date_modified']); ?></td>
                </tr>
                            <?php
                        }
                    } else {

                ?>
                <tr>
                    <td colspan="4">There are no entries</td>
                </tr>
                <?php } ?>
            </table>
        </article>
    </main>
<?php } else { 
    $entry = $entry_handler->ReadEntry($_GET['id']);

?>
    <main>

        <article>
<?php

    if($entry != 0) {

      foreach($entry as $e) {

?>
        <h2><?php echo $e['title'];?></h2>
        <p>
          <?php echo $e['description']; ?>
        </p>
          <p><br></p>
          <p><?php echo $e['name']; ?></p>
          <p><?php echo date("d M Y, H:i", $e['date_modified']); ?></p>
        
        </article>
<?php
        break;
      }//end of for
    } else {
?>
        <h2>Entry does not exist</h2>
<?php
    }
  }

        ?>
    </main>
