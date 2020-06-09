<?php
/**
 * @var $userId int
 * @var $daysArray ReservationSystem\Day\Day[]
 * @var $yearNumber int
 * @var $weekNumber int
 * @var $hoursAmount int
 * @var $weekId int
 * @var $isLoggedIn bool
 * @var $username string
 */

use ReservationSystem\Block\Block; ?>
<header>
    <img id="logo" src=<?= LOGO_PATH ?> alt="Logo">
    <h1><?= $pageTitle ?? '' ?></h1>
    <?php if($isLoggedIn ?? false): ?>
        <div id="login">
            <a href="user"><?= $username ?? "?" ?></a>
            <a href="logout">Log Out</a>
        </div>
    <?php else: ?>
        <div id="login">
            <a href="login">Log In</a>
            <a href="signin">Sign Up</a>
        </div> 
    <?php endif ?>
</header>
<div>
    <div>
        <div id="weekSelector">
            <form id="weekNav" action="" method="post"></form>
            <button name="previousWeekBtn" form="weekNav" type="submit" value="0"><</button>
            <h2 id="weekLabel"><?= $yearNumber . " Week " . $weekNumber; ?></h2>
            <button name="nextWeekBtn" form="weekNav" type="submit" value="0">></button>
        </div>
        <table id="planning">
            <thead>
            <tr>
                <td id="hourLabel" class="label"></td>
                <th><?= "Ma " . $daysArray[0]->getDate(); ?></th>
                <th><?= "Di " . $daysArray[1]->getDate(); ?></th>
                <th><?= "Wo " . $daysArray[2]->getDate(); ?></th>
                <th><?= "Do " . $daysArray[3]->getDate(); ?></th>
                <th><?= "Vr " . $daysArray[4]->getDate(); ?></th>
                <th><?= "Za " . $daysArray[5]->getDate(); ?></th>
                <th><?= "Zo " . $daysArray[6]->getDate(); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td id="hours">
                    <table>
                        <tbody>
                        <?php for($i = DAY_START; $i < DAY_END; $i++): ?>
                            <tr><td class="first"><?= $i; ?></td></tr>
                            <tr><td class="second"></td></tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </td>
                <?php foreach($daysArray as $day): ?>
                <td class="day" id="dayNr:<?= $day->getDayNumber() ?>">
                    <div>
                        <div class="blocks">
                            <?php foreach($day->getBlocksArray() as $block): ?>

                                <?= $block->getBlock($userId, $isLoggedIn, $hoursAmount, $day->getDayNumber()); ?>

                            <?php endforeach; ?>
                        </div>
                        <table class="daysBackground">
                            <tbody>
                            <?= $dayBackground ?? '' ; ?>
                            </tbody>
                        </table>
                    </div>

                </td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>
    </div>
    <?php if($isLoggedIn ?? false): ?>
        <div class="modal" id="reservationModal">
            <div class="modalContent">
                <span class="modalClose">&times;</span>
                <p id="modalHeader">Selecteer een veld</p>

                <form id="reservationForm" action="" method="post">
                        <label for="fieldOne">Field 1: </label>
                        <input type="radio" name="fieldSelector" id="fieldOne" value="1">
                        <label for="fieldTwo">Field 2: </label>
                        <input type="radio" name="fieldSelector" id="fieldTwo" value="2">
                        <label for="fieldThree">Field 3: </label>
                        <input type="radio" name="fieldSelector" id="fieldThree" value="3">
                    <br>
                    <input type="submit" id="submitAdd" value="book">

                    <input id="blockId" type="hidden" value="">
                </form>

            </div>
        </div>
        <div class="modal" id="editModal">
            <div class="modalContent">
                <span class="modalClose">&times;</span>
                <p id="modalHeader">Reservering aanpassen</p>

                <form id="editForm" action="" method="post">
                    <input type="submit" id="submitEdit" value="remove">

                    <input type="hidden" class="blockSelect">
                </form>

            </div>
        </div>
    <?php endif ?>
    <div class="modal" id="infoModal">
        <div class="modalContent">
            <span class="modalClose">&times;</span>

            <p>info</p>

            <p id="weekId">week: <?= $weekId ?></p>
        </div>
    </div>

    <script src="js/scripts.js"></script>

</div>

