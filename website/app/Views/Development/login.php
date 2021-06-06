<body>
    <div>
        <?php
            foreach($errors ?? [] as $error){
                echo '<p>' . $error . '</p>';
            }
        ?>
        <form action="/user/login/request" method="post">
            <label>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email ?? null ?>" required>
            </label>
            <label>
                <input type="password" name="password" placeholder="Mot de passe" required>
            </label>
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>