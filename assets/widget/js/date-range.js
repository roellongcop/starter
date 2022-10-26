class DateRangeWidget {
    newRanges = {};

    constructor(options) {
        this.start = options?.start;
        this.end = options?.end;
        this.all_start = options?.all_start;
        this.all_end = options?.all_end;
        this.ranges = options?.ranges;
        this.id = options?.id;
    }

    init() {
        let start = moment(this.start);
        let end = moment(this.end);
        let span = $(`#${this.id} span`);
        let input = $(`#${this.id} input`);

        let defaultRanges = {
            'All': [moment(this.all_start), moment(this.all_end)],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        }
        for(let key in this.ranges) {
            this.newRanges[this.ranges[key]] = defaultRanges[this.ranges[key]];
        }
        $(`#${this.id}`).daterangepicker({
            // buttonClasses: 'btn btn-sm',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            startDate: start,
            endDate: end,
            ranges: this.newRanges
        }, function(start, end, label) {
            span.html( start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
            input.val( start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        });
        span.html( start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
        input.val( start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }
}

