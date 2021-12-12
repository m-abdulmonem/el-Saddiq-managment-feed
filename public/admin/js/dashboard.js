/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.card-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  })
  $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move')


  // jvectormap data
  var visitorsData = {
    'US': 398, //USA
    'SA': 400, //Saudi Arabia
    'CA': 1000, //Canada
    'DE': 500, //Germany
    'FR': 760, //France
    'CN': 300, //China
    'AU': 700, //Australia
    'BR': 600, //Brazil
    'IN': 800, //India
    'GB': 320, //Great Britain
    'RU': 3000 //Russia
  }
  // World map by jvectormap
  $('#world-map').vectorMap({
    map              : 'world_en',
    backgroundColor  : 'transparent',
    regionStyle      : {
      initial: {
        fill            : 'rgba(255, 255, 255, 0.7)',
        'fill-opacity'  : 1,
        stroke          : 'rgba(0,0,0,.2)',
        'stroke-width'  : 1,
        'stroke-opacity': 1
      }
    },
    series           : {
      regions: [{
        values           : visitorsData,
        scale            : ['#ffffff', '#0154ad'],
        normalizeFunction: 'polynomial'
      }]
    },
    onRegionLabelShow: function (e, el, code) {
      if (typeof visitorsData[code] != 'undefined')
        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors')
    },
    onRegionClick: function(element, code, region) {
        let $map = $('#world-map');

        $.ajax({
            url: $map.data("url"),
            data:{_token:$map.data("token"), region:region},
            type: "GET",
            dataType: "json",
            success: function (result) {
                if (result.status === 1) {
                    $(".visitors-count").html(result.msg)
                }
            },
            error:function (x,y) {
                console.log(x,y);
            }
        });
      // var message = 'You clicked "'
      //     + region
      //     + '" which has the code: '
      //     + code.toUpperCase();
      //
      // alert(message);
    }
  })

  // Sparkline charts
  // var sparkline1 = new Sparkline($("#sparkline-1")[0], {width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9'});
  // var sparkline2 = new Sparkline($("#sparkline-2")[0], {width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9'});
  // var sparkline3 = new Sparkline($("#sparkline-3")[0], {width: 80, height: 50, lineColor: '#92c1dc', endColor: '#ebf4f9'});
  // //
  // sparkline1.draw([1, 20, 20, 27, 31, 27, 19, 30, 21]);
  // sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921]);
  // sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21]);


});
