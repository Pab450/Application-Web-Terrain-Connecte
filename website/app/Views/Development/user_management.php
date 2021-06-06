<body>
    <form id="search" action="/user/management/request" method="post">
            <label>
                <input type="text" name="text" placeholder="Adresse email" value="<?php echo $text ?? null ?>">
            </label>
            <input type="submit" value="Rechercher">
    </form>
    <div id="informations">
        <?php
        if(isset($success))
        {
            echo "<p id='success'>" . $success . "</p>";
        }
        else
        {
            foreach($errors ?? [] as $error)
            {
                echo '<p>' . $error . '</p>';
            }
        }
        ?>
    </div>
    <div id="list">
        <ul>
            <?php
            foreach($users ?? [] as $user){
                echo '<li class="user">
                        <div>' . $user->email . '</div>
                        <form method="post">
                            <input name="email" type="hidden" value=' . $user->email . '>
                            <div class="level">
                                <p>Niveau: </p>
                                <select name="level">';
                                    foreach($levels ?? [] as $levelValue => $levelName){
                                        echo '<option value=' . $levelValue . ' ' . ($levelValue == $user->level ? 'selected' : null) .'>' . $levelName. '</option>';
                                    }
                echo           '</select>
                            </div>
                            <div class="input">
                                <input type="submit" class="update" name="update" value="Mettre à jour" formaction="/user/change-level/request/">
                                <input type="submit" class="delete" name="delete" value="Supprimer" formaction="/user/delete/request/">
                            </div>
                        </form>
                    </li>';
            }
            ?>
        </ul>
    </div>
    <a href="/home" class="button">Quitter</a>
</body>