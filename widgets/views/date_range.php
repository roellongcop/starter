<?php

$src = <<< SCRIPT
    var start = moment('{$start}');
    var end = moment('{$end}');

    let defaultRanges = {
        'All': [moment('{$all_start}'), moment('{$all_end}')],
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
       'This Year': [moment().startOf('year'), moment().endOf('year')],
       'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
    }
    let ranges = {$ranges};
    let newRanges = {};

    for(key in ranges) {
        newRanges[ranges[key]] = defaultRanges[ranges[key]];
    }

    $('#{$id}').daterangepicker({
        // buttonClasses: 'btn btn-sm',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',

        startDate: start,
        endDate: end,
        ranges: newRanges
    }, function(start, end, label) {
        $('#{$id} span').html( start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
        $('#{$id} input').val( start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    });

    $('#{$id} span').html( start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
    $('#{$id} input').val( start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
SCRIPT;
$this->registerJs($src);
?>
<br>
<p class=""><?= $title ?></p>
<div class="date-range-search" id="<?= $id ?>">
    <input name="<?= $name ?>" class="form-control pointer"  readonly placeholder="Select Date" type="hidden"  />
    <span class="form-control pointer"> </span>
</div>