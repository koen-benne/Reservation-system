<header>
    <img id="logo" src=<?= LOGO_PATH ?>>
    <h1><?= $pageTitle ?? '' ?></h1>
    <?php if($isLoggedIn ?? false): ?>
        <div id="login">
            <p>Username</p>
            <a>Log Out</a>
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
                <th>Ma</th>
                <th>Di</th>
                <th>Wo</th>
                <th>Do</th>
                <th>Vr</th>
                <th>Za</th>
                <th>Zo</th>
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
                <?php foreach($displayedWeek->getDaysArray() as $day): ?>
                <td id=<?= $day->getDay(); ?> class="day">
                    <div>
                        <div class="blocks">
                            <?php foreach($day->getBlocksArray() as $block): ?>

                                <div class="block" style="<?= $block->getStyles($hoursAmount) ?>">
                                    <div class=<?= $block->getType(); ?>>
                                        <div class="blockTimeBar"><?= $block->getStart()->getString() . " - " . $block->getEnd()->getString(); ?></div>
                                        <div class="blockContent"></div>
                                    </div>
                                </div>

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
</div>

