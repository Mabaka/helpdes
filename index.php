<?php

require_once "php/config.php";

$connection = sqlsrv_connect($serverName, $connectionInfo);

$params = array();
$options =  array("Scrollable" => SQLSRV_CURSOR_KEYSET);

$query = "SELECT [Наименование],[ЭтоГруппа], [Справочник_Категория заявки на выполнение работ_Ссылка],[Справочник_Категория заявки на выполнение работ_Родитель],[Код]
    FROM [Справочник_КатегорииЗаявокНаВыполнениеРабот] WHERE [ПометкаУдаления] <> 0x01 ORDER BY [Наименование] ASC";
$group = sqlsrv_query($connection, $query, $params, $options);
$groupRows = sqlsrv_num_rows($group);

$query = "SELECT [Наименование],[ЭтоГруппа], [Справочник_Категория заявки на выполнение работ_Ссылка],[Справочник_Категория заявки на выполнение работ_Родитель],[Код]
    FROM [Справочник_КатегорииЗаявокНаВыполнениеРабот] WHERE [Справочник_Категория заявки на выполнение работ_Родитель] = 0xADEB001E68572A1A11E3E0DDA7A509D4 AND [ПометкаУдаления] <> 0x01  ORDER BY [Наименование] ASC";
$parent = sqlsrv_query($connection, $query, $params, $options);
$parentRows = sqlsrv_num_rows($parent);

$arGroup = array();
$arParent = array();

while ($rowGr = sqlsrv_fetch_array($group, SQLSRV_FETCH_ASSOC)) {
    array_push($arGroup, $rowGr);
}


while ($rowGr = sqlsrv_fetch_array($parent, SQLSRV_FETCH_ASSOC)) {
    array_push($arParent, $rowGr);
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>SelfService</title>
</head>

<body>
    <div class="bodyBg"></div>
    <header class="header">
        <div class="wrapper">
            <div class="Logo">
                <a class="Logo__link" href="#">Портал самооблуживания Энергомера</a>
            </div>
        </div>
    </header>
    <menu class="menu">
        <ul class="main__menu">
            <?php
            for ($i = 0; $i < $parentRows; $i++) {

                if (ord($arParent[$i]['ЭтоГруппа']) == 0) {
                    $link = '';
                    $img = "style = 'background-image: url(img/triangle.png); background-repeat: no-repeat; background-position: 97% 50%'";
                } else {
                    $link = 'href = "mailto:imst@energomera.ru?subject=' . $arParent[$i]['Код'] . '"';
                    $img = '';
                }

                echo '<li class = "main__menu__item" >
                    <a class = "main__menu__item__link" onclick = "showSubMenu(event);" ' . $link . $img . '  >'
                    . $arParent[$i]['Наименование'] .
                    '</a>';
            ?>
                <ul class="main__menu__subMenu subMenu">
                    <?php
                    for ($j = 0; $j < $groupRows; $j++) {
                        if ($arParent[$i]['Справочник_Категория заявки на выполнение работ_Ссылка'] != $arGroup[$j]['Справочник_Категория заявки на выполнение работ_Родитель']) {
                            continue;
                        }

                        if (ord($arGroup[$j]['ЭтоГруппа']) == 0) {
                            $link = '';
                            $img = "style = 'background-image: url(img/triangle.png); background-repeat: no-repeat; background-position: 98% 50%'";
                        } else {
                            $link = 'href = "mailto:imst@energomera.ru?subject=' .  $arGroup[$j]['Код'] . '"';
                            $img = '';
                        }

                        echo '<li class = "subMenu__item">
                            <a class = "subMenu__item__link" onclick = "showSubMenu2(event);" ' . $link . $img . '>'
                            . $arGroup[$j]['Наименование'] .
                            '</a>';
                    ?>
                        <ul class="main__menu__subMenu__subMenu2 subMenu2">
                            <?php
                            for ($k = 0; $k < $groupRows; $k++) {
                                if ($arGroup[$j]['Справочник_Категория заявки на выполнение работ_Ссылка'] != $arGroup[$k]['Справочник_Категория заявки на выполнение работ_Родитель']) {
                                    continue;
                                }

                                if (ord($arGroup[$k]['ЭтоГруппа']) == 0) {
                                    $link = '';
                                    $img = "style = 'background-image: url(img/triangle.png); background-repeat: no-repeat; background-position: 98% 50%'";
                                } else {
                                    $link = 'href = "mailto:imst@energomera.ru?subject=' .  $arGroup[$k]['Код'] . '"';
                                    $img = '';
                                }

                                echo '<li class = "subMenu2__item">
                                <a class = "subMenu2__item__link" ' . $link . $img . '>'
                                    . $arGroup[$k]['Наименование'] .
                                    '</a>';
                            ?>
                            <?php '</li>';
                            }
                            ?>
                        </ul>
                    <?php '</li>';
                    } ?>
                </ul>
            <?php '</li>';
            } ?>
        </ul>
    </menu>
    <script src="js/script.js"></script>
</body>

</html>
