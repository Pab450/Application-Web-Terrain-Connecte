<body>
<div id="flexRow">
    <div id="grid">
        <div id="grid-container">
        </div>
    </div>
    <div id="menu">
        <h3>Terrain</h3>
        <?php
        if(isset($obtain_success))
        {
            echo "<p id='success'>" . $obtain_success . "</p>";
        }
        else
        {
            foreach($obtain_errors ?? [] as $error){
                echo '<p>' . $error . '</p>';
            }

            foreach($create_errors ?? [] as $error){
                echo '<p>' . $error . '</p>';
            }
        }
        ?>
        <form id="land" action="/sonde/obtain/request" method="post">
            <label>
                <input type="text" name="identifierLand" value="<?php echo $identifierLand ?? null ?>" placeholder="Nom du terrain">
            </label>
            <input type="submit" value="Rechercher">
        </form>

        <?php
            if(isset($obtain_success, $identifierLand))
            {
                echo '<h3>Sondes</h3>';

                echo '<form id="land" action="/land/create/request" method="post">
                      <input type="hidden" name="identifierLand" value="' . $identifierLand . '">';

                foreach($sondes ?? [] as $sondes)
                {
                    echo '<div class="sonde" id=' . $sondes->identifierSonde . '> Sonde numéro ' . $sondes->identifierSonde . ', non liée. </div>';
                    echo "<input type='hidden' name=" . $sondes->identifierSonde . ">";
                }

                echo '<input type="submit" value="Créer">
                      </form>';
            }
        ?>
    </div>
    <a class="button" href="/home">Quitter</a>
</div>
</body>
<script>
    let rows = 10;
    let columns = 6;

    let gridContainer = document.getElementById('grid-container');

    gridContainer.style.gridTemplateRows = 'repeat(' + rows + ', 1fr)';
    gridContainer.style.gridTemplateColumns = 'repeat(' + columns + ', 1fr)';

    for(let column = 1; column <= columns; column += 1)
    {
        let gridColumn = document.createElement('div');

        if(column !== 1)
        {
            gridColumn.style.borderLeft = '1px dashed black';
        }

        gridColumn.style.gridArea = '1 / ' + column + ' / ' + (rows + 1) + ' / ' + (columns + 1);
        gridColumn.style.zIndex = '1';

        gridContainer.appendChild(gridColumn);
    }
    
    for(let row = 1; row <= rows; row += 1)
    {
        let gridRow = document.createElement('div');

        if(row !== 1)
        {
            gridRow.style.borderTop = '1px dashed black';
        }

        gridRow.style.gridArea = row + ' / 1 / ' + row + ' / ' + (columns + 1);
        gridRow.style.zIndex = '1';

        gridContainer.appendChild(gridRow);

        for(let column = 1; column <= columns; column += 1)
        {
            let gridItem = document.createElement('div');

            gridItem.className = 'grid-item';
            gridItem.style.gridArea = row + ' / ' + column + ' / ' + row + ' / ' + column;
            gridItem.dataset.row = row.toString();
            gridItem.dataset.column = column.toString();
            gridItem.style.zIndex = '3';

            gridContainer.appendChild(gridItem);
        }
    }

    let sondes = document.getElementsByClassName('sonde');
    let sonde_selected = null;

    Array.prototype.forEach.call(sondes, (sonde) => {
       sonde.addEventListener("click", () => {
           Array.prototype.forEach.call(sondes, (sonde) => {
               sonde.className = 'sonde';
           });

           sonde.className = "sonde sonde_selected";
           sonde_selected = sonde;
       });
    });

    let elementAtMousePosition;
    let gridBox = null;

    document.onmousemove = function(e)
    {
        elementAtMousePosition = document.elementFromPoint(e.clientX, e.clientY);

        if(elementAtMousePosition?.classList.contains('grid-item')  && gridBox)
        {
            gridBox.style.gridColumnEnd = (parseInt(elementAtMousePosition.dataset.column) + 1).toString();
            gridBox.style.gridRowEnd = (parseInt(elementAtMousePosition.dataset.row) + 1).toString();
        }
    };

    document.onmousedown = function(e)
    {
        if(
            elementAtMousePosition.classList.contains('grid-item') &&
            gridBox === null && sonde_selected != null
        ){
            let row = elementAtMousePosition.dataset.row;
            let column = elementAtMousePosition.dataset.column;

            gridBox = document.createElement('div');

            gridBox.style.gridArea = row + ' / ' + column + ' / ' + row + ' / ' + column;
            gridBox.style.zIndex = '2';
            gridBox.classList.add('grid-box');

            Array.prototype.forEach.call(gridContainer.getElementsByClassName(sonde_selected.id), (gridBox) => {
                gridBox.remove();
            });

            Array.prototype.forEach.call(document.getElementsByName(sonde_selected.id), (input) => {
                input.value = null;
            });

            gridContainer.appendChild(gridBox);

            return false;
        }
    }

    document.onmouseup = function (e) {
        if(gridBox)
        {
            gridBox.classList.add(sonde_selected.id);

            Array.prototype.forEach.call(document.getElementsByName(sonde_selected.id), (input) => {
                input.value = gridBox.style.gridArea;
            });

            document.getElementById(sonde_selected.id).innerText = "Sonde numéro " + sonde_selected.id + ", liée."

            gridBox.style.zIndex = '4';

            let boxDelete = document.createElement('button');
            boxDelete.innerHTML = "supprimer";

            boxDelete.addEventListener('click', (event) => {
                event.target.parentElement.remove();

                let id  = event.target.parentElement.classList[1];

                Array.prototype.forEach.call(document.getElementsByName(id), (input) => {
                    input.value = null;
                });

                document.getElementById(id).innerText = "Sonde numéro " + id + ", non liée."
            });

            gridBox.appendChild(boxDelete);

            let divText = document.createElement('div');
            divText.innerHTML = 'Sonde numéro ' + sonde_selected.id;
            divText.id = "boxId";
            gridBox.appendChild(divText);

            gridBox = null;
        }
    }
</script>