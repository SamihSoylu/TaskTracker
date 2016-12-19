<?php

  /**
  *
  *   @author Samih Soylu
  *
  **/
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TT - <?php echo PAGE_NAME; ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="apple-touch-icon" href="favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css" />
</head>
<body>
    <header>
        <nav>
            <div class="menu" onclick="toggleNav()">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <h1><a href="index.php">TTracker</a></h1>
            <ul id="menu">
                <li <?php if(PAGE_NAME == "MyEntries") { echo 'class="active"'; } ?>>
                    <a href="?p=MyEntries">My entries</a>
                </li>
                <li <?php if(PAGE_NAME == "NewEntry") { echo 'class="active"'; } ?>>
                    <a href="?p=NewEntry">Add new entry</a>
                </li>
                <li <?php if(PAGE_NAME == "AllEntries") { echo 'class="active"'; } ?>>
                    <a href="?p=AllEntries">View all entries</a>
                </li>
                <?php if(isset($_SESSION['user_id'])) { ?>
                <li class="logout">
                    <a href="?p=Logout">Logout</a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </header>