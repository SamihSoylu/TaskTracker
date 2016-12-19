<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/

  /*
  * Default all entries page. Shows all entry. If ID is not set shows all entries.
  */
  if(!isset($_GET['id'])) {

    $AllEntries = $entry_handler->ReadAllUsersEntries();
?>
    <main>
        <article>
          
        <!--<h2>All entries</h2>-->

                  <?php

                    if($AllEntries != 0) {

                          # Gets the date of the first entry within the database
                          $first_entry_date = $entry_handler->getDateOfFirstCreatedEntry();

                          # Converts to week.
                          $first_entry_week = date('W', $first_entry_date);

                          # Current entry week is 0 by default
                          $current_entry_week = 0;

                          # To display first week on the page, this is marked as true.
                          $we_are_processing_first_week = true;

                        foreach($AllEntries as $entry) {

                          # If we haven't displayed the first entry week on the page
                          if($we_are_processing_first_week) {

                            # Display first entry week
                            echo "<h2>Week ".$first_entry_week."<h2>";

                            # Sets the current week (entries date in week(eg. WK41) are being displayed)
                            $current_entry_week = $first_entry_week;

                            $we_are_processing_first_week = false;
                          }

                          # To keep track of the previous week, after the current entry week changes.
                          # We determine later if current entry week is different, if so then we display a new week number.
                          $previous_entry_week = $current_entry_week;

                          # Compare current week with the retrieved entry from the database. 
                          $current_entry_week = $entry_handler->checkWeek($current_entry_week, date('W', $entry['date_added']));

                          # Display new week if necessary.
                          if($previous_entry_week != $current_entry_week) {
                            echo "<h2>Week ".$current_entry_week."<h2>";
                          }

                          # Date filter for posts
                          $entry['description'] = str_replace("[", "<span>[", $entry['description']);
                          $entry['description'] = str_replace("]", "]</span>", $entry['description']);

                          # Filter for new lines
                          $entry['description'] = str_replace("\n", "<br>", $entry['description']);

                            ?>
                <section>
                  <h3><a href="index.php?p=AllEntries&id=<?php echo $entry['entry_id']; ?>"><?php echo $entry['title']; ?></a></h3>
                  <p><?php echo $entry['description']; ?></p>
                  <hr>
                  <p class="center credits">

                    <?php /* user name */ echo $entry['name']; ?> | <?php /* last modified */ echo date("d M H:i", $entry['date_modified']); ?>
                      
                  </p>
                </section>
                            <?php
                            
                        }
                    } else {

                ?>
                  <h2>All entries</h2>
                  <section>
                    <p class="center">There are no entries</p>
                  </section>
                <?php } ?>
        </article>
    </main>
<?php } else { 

  /*
  * If user wants to see a specific entry,
  * shows specified entry
  */

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
          <p class="center"><?php echo $e['name']; ?></p>
          <p class="center"><?php echo date("d M Y, H:i", $e['date_modified']); ?></p>
        
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
