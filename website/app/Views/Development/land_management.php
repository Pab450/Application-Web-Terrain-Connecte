<body>
<div id="flexRow">
    <div id="grid">
        <?php
        $rows = 10;
        $columns = 6;

        echo '<div id="grid-container" style="grid-template-rows: repeat('. $rows .', 1fr); grid-template-columns: repeat(' . $columns . ', 1fr);">';

        for($column = 1; $column <= $columns; $column += 1)
        {
            echo '<div ';

            if($column !== 1)
            {
                echo 'style="border-left: 1px dashed black; ';
            }

            echo 'grid-area: 1 / ' . $column . ' / ' . ($rows + 1) . ' / ' . ($columns + 1) . '; z-index: 1;"></div>';
        }

        for($row = 1; $row <= $rows; $row += 1)
        {
            echo '<div ';

            if($row !== 1)
            {
                echo 'style="border-top: 1px dashed black; ';
            }

            echo 'grid-area: ' . $row . ' / 1 / ' . $row . ' / ' . ($columns + 1) . '; z-index: 1;"></div>';

            for($column = 1; $column <= $columns; $column += 1)
            {
                echo '<div class="grid-item" data-row="'. $row .'" data-column="'. $column .'" style="grid-area: ' . $row . ' / ' . $column . ' / ' . $row . ' / ' . $column . '; z-index: 3;"></div>';
            }
        }

        foreach($sondes ?? [] as $sonde){
            $render = json_decode(json_encode($render ?? []), true);

            if(in_array($sonde->identifierSonde, array_keys($render)))
            {
                /** @var stdClass $thresholds */
                $humidity_check = $sonde->humidity >= $thresholds->minimalHumidity ? 'ok' : 'no';
                $tension_check = $sonde->tension >= $thresholds->minimalTension ? 'ok' : 'no';

                echo '<div class="grid-box" style="grid-area: ' . $render[$sonde->identifierSonde] . ';">';
                echo '<div class="identifier">Sonde ' . $sonde->identifierSonde . '</div>';
                echo '<div>' . $sonde->temperature . ' °C</div>';
                echo '<div class="' . $humidity_check . '">' . $sonde->humidity . ' %</div>';
                echo '<div class="' . $tension_check . '">' . $sonde->tension . ' V</div>';
                echo '</div>';
           }
        }

        echo '</div>'
        ?>
    </div>
    <div id="menu">
        <h3>Seuils</h3>
        <?php
        if(isset($threshold_success))
        {
            echo "<p id='success'>" . $threshold_success . "</p>";
        }
        else
        {
            foreach($threshold_errors ?? [] as $error){
                echo '<p>' . $error . '</p>';
            }
        }
        ?>
        <form id="land" action="/threshold/change-values/request/" method="post">
            <label>
                <input type="hidden" name="identifierLand" value="<?php echo $identifierLand ?? null ?>">
            </label>
            <label>
                <input type="number" step="0.01" name="minimalHumidity" value="<?php echo $thresholds->minimalHumidity ?? null ?>" placeholder="Humidité minimale">
            </label>
            <label>
                <input type="number" step="0.01" name="minimalTension" value="<?php echo $thresholds->minimalTension ?? null ?>" placeholder="Tension minimale">
            </label>
            <input type="submit" value="Enregistrer">
        </form>
        <h3>Action</h3>

        <form id="land" method="post">
            <input type="submit" name="mode" value="Automatique" formaction="/land/management/request/mode/automatique">
            <input type="submit" name="mode" value="Semi-Automatique" formaction="/land/management/request/mode/semi-automatique">
            <input type="submit" name="mode" value="Arrêt" formaction="/land/management/request/mode/arret">
            <input type="submit" name="mode" value="Forcer" formaction="/land/management/request/mode/forcer">
        </form>

        <h3>Occupation</h3>
        <?php
        if(isset($occupation_success))
        {
            echo "<p id='success'>" . $occupation_success . "</p>";
        }
        else
        {
            foreach($occupation_errors ?? [] as $error){
                echo '<p>' . $error . '</p>';
            }
        }
        ?>
        <form id="land" action="/occupation/change-values/request/" method="post" enctype="multipart/form-data">
            <label>
                <input type="hidden" name="identifierLand" value="<?php echo $identifierLand ?? null ?>">
            </label>
            <input type="file" name="file">
            <input type="submit" value="Importer">
        </form>

        <table>
            <tr>
                <td>Description</td>
                <td>Date de début</td>
                <td>Date de fin</td>
            </tr>

            <?php
            foreach ($occupation ?? [] as $item){
                echo '<tr>
                      <td>'. $item->wording .'</td>
                      <td>'. $item->startDateTime .'</td>
                      <td>'. $item->endDateTime .'</td>
                      </tr>';
            }
            ?>
        </table>
    </div>
    <a class="button" href="/home">Quitter</a>
</div>
</body>