$(function () {

    $.fn.extend({
        maChart: function (options) {
            let settings = $.extend({
                labels: [],
                type: "line",
                data: {},
                currency : " ج.م ",
                activeCurrency : false,
                min: undefined,
            },options), dataSets = [];

            $.each(settings.data,function (k,v) {
                dataSets.push(dataSet(v.label,v.data,v.color))
            });
            

            return new Chart($(this).get(0).getContext('2d'), {
                type: settings.type,
                data: {
                    labels  : settings.labels,
                    datasets: dataSets
                },
                options: {
                    responsive              : true,
                    maintainAspectRatio     : false,
                    datasetFill             : true,
                    scales: {
                        yAxes: [{
                            type: "linear",
                            ticks: {
                                min: settings.min,
                                stepSize: 1,
                                callback: function(value, index, values) {
                                    if (settings.activeCurrency)
                                        return (parseInt(value) >= 1000)
                                            ? settings.currency + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                            : settings.currency + value;
                                    return value;
                                }
                            }
                        }]
                    }//end of scales
                }//end of option
            });
        },
    });
});

function dataSet(label,data,color = 'rgba(60,141,188,0.9)') {
    return {
        label               : label,
        backgroundColor     : color,
        borderColor         : color,
        pointStrokeColor    : color,
        pointHighlightStroke: color,
        pointColor          : color,
        pointHighlightFill  : '#fff',
        data                : data,
        fill: true,
        borderWidth: 1 // Specify bar border width
    };
}
