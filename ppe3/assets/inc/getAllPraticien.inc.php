<?php
require '../phpClass/ClassPraticien.php';
?>
<?php foreach(Praticien::getAllPraticiens() as $value):?>
    <ul class="collection with-header praSelectable">
        <li class="collection-header">
            <input name="rapportPraticien" type="hidden" value="<?php echo $value->getNum(); ?>"/>
            <h4 class="nom">
                <?php echo mb_strtoupper($value->getNom(),'UTF-8')." ".$value->getPrenom(); ?>
            </h4>
        </li>
        <li class="collection-item">
            <h6 class="boldPoppins">
                Numéro :
                <span class="softPoppins">
                                <?php echo $value->getNum(); ?>
                            </span>
            </h6>
        </li>
        <li class="collection-item">
            <h6 class="boldPoppins">
                Adresse :
                <span class="softPoppins">
                                <?php echo $value->getAdresse(); ?>
                            </span>
            </h6>
        </li>
        <li class="collection-item">
            <h6 class="boldPoppins">
                Ville :
                <span class="softPoppins">
                               <?php echo $value->getCp()." ".$value->getVille(); ?>
                            </span>
            </h6>
        </li>
        <li class="collection-item">
            <h6 class="boldPoppins">
                Coeff. notoriété :
                <span class="softPoppins">
                                <?php echo $value->getCoef(); ?>
                            </span>
            </h6>
        </li>
        <li class="collection-item">
            <h6 class="boldPoppins">
                Type :
                <span class="softPoppins">
                                <?php echo $value->getTypePraticien()->getTypeCode().
                                    " : "
                                    .$value->getTypePraticien()->getTypeLibelle(); ?>
                            </span>
            </h6>
        </li>
        <li class="collection-item">
            <h6 class="boldPoppins">
                Lieu d'exercice :
                <span class="softPoppins">
                                <?php echo $value->getTypePraticien()->getTypeLieu(); ?>
                            </span>
            </h6>
        </li>
    </ul>
<?php endforeach;?>