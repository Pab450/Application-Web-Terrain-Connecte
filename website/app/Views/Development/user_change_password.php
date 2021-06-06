<body>
    <div>
        <?php
        if(isset($success))
        {
            echo "<p id='success'>Le mot de passe de l'utilisateur à bien été modifié.</p>";
        }
        else
        {
            foreach($errors ?? [] as $error){
                echo '<p>' . $error . '</p>';
            }
        }
        ?>
        <form action="/user/change-password/request" method="post">
            <label id="email"><?php echo $email ?? null ?></label>
            <label>
                <input type="password" name="old_password" placeholder="Ancien mot de passe" required>
            </label>
            <label>
                <input type="password" name="password" placeholder="Nouveau mot de passe" required>
            </label>
            <label>
                <input type="password" name="confirm_password" placeholder="Confirmation du nouveau mot de passe" required>
            </label>
            <input type="submit" value="Mettre à jour le mot de passe">
        </form>
        <a href="/home" class="button">Quitter</a>
    </div>
</body>