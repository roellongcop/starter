<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
        Manage
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <?php foreach ($template as $t): ?>
            <?php if ($t): ?>
                <li> <?= $t ?> </li>
            <?php endif ?>
        <?php endforeach ?>
    </ul>
</div>