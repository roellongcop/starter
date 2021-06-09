<?php
$registerJs = <<< SCRIPT
    var popupCenter = (url, title='Print Report', w=1000, h=700) => {
        // Fixes dual-screen position                             Most browsers      Firefox
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;
        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        const systemZoom = width / window.screen.availWidth;
        const left = (width - w) / 2 / systemZoom + dualScreenLeft
        const top = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow = window.open(url, title, 
          `
          scrollbars=yes,
          width=(w/systemZoom), 
          height=(h/systemZoom), 
          top=top, 
          left=left
          `
        )
        if (window.focus) newWindow.print();
    }
SCRIPT;
$this->registerJs($registerJs, \yii\web\View::POS_END);
?>
<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
        <?= $title ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right">
        <?php foreach ($exports as $anchor): ?>
            <li> <?= $anchor ?> </li>
        <?php endforeach ?>
    </ul>
</div>