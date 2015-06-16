<h2>&#9881; MENAGE INFORMATIONS</h2>
<form class="loginform" action="?controller=user&action=alter&id=<?php echo $_GET['id']; ?>" method="post">
    <fieldset>
        <label for="NewName">Name</label>
        <input name="NewName" type="text" value="<?php echo $user->name(); ?>" id="NewName" />
        <label for="NewSurname">Surname</label>
        <input name="NewSurname" type="text" value="<?php echo $user->surname(); ?>" id="NewSurname" />
        <label for="NewMail">E-Mail</label>
        <input name="NewMail" type="email" value="<?php echo $user->email(); ?>" id="NewMail" />
        <label for="NewUsername">Username</label>
        <input name="NewUsername" type="text" value="<?php echo $user->username(); ?>" id="NewUsername" />
        <label for="NewPassword">Password</label>
        <input name="NewPassword" type="Password" value="" id="NewPassword" />
        <input type="submit" value="submit" />
    </fieldset>
</form>