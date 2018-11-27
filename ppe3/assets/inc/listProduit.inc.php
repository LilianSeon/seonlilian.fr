<div class="row element" id="preElement1">
    <div class="input-field col m4">
        <select>
            <option value="" disabled selected>Produits</option>
            <?php
            foreach (Medicaments::getAllDepotAndName() as $value):
                ?>
                <option value="<?php echo $value['MED_DEPOTLEGAL']; ?>">
                    <?= $value['MED_DEPOTLEGAL'] . ' : ' . $value['MED_NOMCOMMERCIAL']; ?>
                </option>
                <?php
            endforeach;
            ?>
        </select>
        <label>Sélectionner un produit</label>
    </div>
    <div class="col m3">
        <input type="checkbox" id="Documentation"/>
        <label for="Documentation">Documentation Offerte</label>
    </div>
    <div class="col s1">
        <a id="addPresente"
           class="btn-floating btn-large waves-effect waves-light btn tooltipped blue accent-1"
           data-position="left" data-delay="50" data-tooltip="Ajoute un nouvel élément">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>
