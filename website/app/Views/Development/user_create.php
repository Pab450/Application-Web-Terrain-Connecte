<body>
    <div>
        <?php
        if(isset($success))
        {
            echo "<p id='success'> L'utilisateur à bien été créé.</p>";
        }
        else
        {
            foreach($errors ?? [] as $error)
            {
                echo '<p>' . $error . '</p>';
            }
        }
        ?>
        <form action="/user/create/request" method="post">
            <label>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email ?? null ?>" required>
            </label>
            <label>
                <input type="password" name="password" placeholder="Mot de passe" required>
            </label>
            <label>
                <input type="password" name="confirm_password" placeholder="Confirmation du mot de passe" required>
            </label>
            <label for="level">
                <input type="radio" name="level" value="1"
                    <?php
                    if(isset($administator))
                    {
                        echo 'checked';
                    }
                    ?>
                >
                Administrateur
            </label>
            <label for="level">
                <input type="radio" name="level" value="0"
                    <?php
                    if(isset($administator) === false)
                    {
                        echo 'checked';
                    }
                    ?>
                >
                Agent
            </label>
            <input type="submit" value="Créer un utilisateur">
        </form>
        <a href="/home" class="button">Quitter</a>
    </div>
</body>