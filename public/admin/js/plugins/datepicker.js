$(function () {

    $.fn.extend({
        maDatepicker: function (options) {
            let setting = $.extend({
                start: moment().subtract(29, 'days'),
                end : moment()
            },options),
                $this = $(this);

            return $this.daterangepicker({
                startDate: setting.start,
                endDate: setting.end,
                ranges: {
                    'اليوم': [moment(), moment()],
                    'الامس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'اخر 7 ايام': [moment().subtract(6, 'days'), moment()],
                    'اخر 30 يوم': [moment().subtract(29, 'days'), moment()],
                    'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
                    'الشهر الماضى': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'منذ البداية': ["منذ البداية",null]
                },
                "locale": {
                    "format": "YYYY-MM-DD",
                    "separator": " to ",
                    "applyLabel": "عرض",
                    "cancelLabel": "إالغاء",
                    "fromLabel": "من",
                    "toLabel": "الى",
                    "customRangeLabel": "عرض فترة مخصصة",
                    "weekLabel": "إسبوع",
                    "daysOfWeek": [
                        "ح",
                        "ن",
                        "ث",
                        "ع",
                        "خ",
                        "ج",
                        "س"
                    ],
                    "monthNames": [
                        "يسناير",
                        "فيراير",
                        "مارس",
                        "إبريل",
                        "مايو",
                        "يونيو",
                        "يوليو",
                        "أغسطس",
                        "ستمبر",
                        "أكتوبر",
                        "نوفمبر",
                        "ديسمبر"
                    ],
                    "firstDay": 1
                },
            }, function (start,end) {
                if (options === "function")
                    options(start,end);
                $this.find("span").html(start.format('YYYY-MM-DD') + ' الى ' + end.format('YYYY-MM-DD'));
            })
        },
    })

});
