<body>
    <div id="user">
        <a href="/user/create" class="button">Créer un utilisateur</a>
        <a href="/user/change-password" class="button">Changer son mot de passe</a>
        <a href="user/logout" class="button">Se déconnecter</a>
        <a href="user/management" class="button">Gérer les utilisateurs</a>
    </div>
    <div id="lands">
        <form id="landsform" action="/home/request" method="post">
            <label>
                <input type="text" name="text" placeholder="Nom du terrain" value="<?php echo $text ?? null ?>">
            </label>
            <input type="submit" value="Rechercher">
        </form>
        <div id="list">
            <ul>
                <?php
                foreach($lands ?? [] as $land){
                    echo '<li><a id="land" href="/land/management/' . $land->name . '">' . $land->name . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <a href="/land/create" class="button round">Créer un nouveau terrain</a>
    </div>
</body>