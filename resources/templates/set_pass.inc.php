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
                <label>New password</label>
                <input type="password" name="newPassword" required />
                <?php
                    if(@$setPassResult == 0) {
                        echo "<span>Error: User does not exist?</span>";
                    }
                ?>
                <input type="submit" name="setNewPass" value="Set Password" />
            </form>
        </article>
    </main>