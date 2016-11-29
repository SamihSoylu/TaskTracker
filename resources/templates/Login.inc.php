<?php
  /**
  *
  *   @author Samih Soylu
  *
  **/
?>
    <main>
        <article>
        <h2>Login</h2>
            <form method="post">
                <label>Username</label>
                <input type="text" name="username" required />
                <label>Password</label>
                <input type="password" name="password" />
                <?php

                    if($GLOBALS['error_messages'] != "x")
                        echo "<span>".$GLOBALS['error_messages']."</span>";

                ?>
                <input type="submit" name="login" value="Sign in" />
            </form>
        </article>
    </main>