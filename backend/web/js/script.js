$(document).ready(function(){
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-purple',
        radioClass   : 'iradio_minimal-purple'
    });

    $("select#type_social").on('change',function(){
        var type = $(this).val();

        location.href = $(this).parents('form').attr('action') + "&type=" + type;
    });

    $('#vol24').on('click',function(e){
        var form = $(this).parents('form'),
            link = form.attr('action').replace(/&day=Y/g,''),
            type = form.find('#type_social').val();
        location.href = link + '&day=Y&type=' + type;
    });

    $('#all').on('click',function(e){
        var form = $(this).parents('form'),
            link = form.attr('action').replace(/&day=Y/g,''),
            type = form.find('#type_social').val();
        location.href = link + '&type=' + type;
    });

    $(".show_dates_fields").on('click', function(e){
        e.preventDefault();

        $('.date_hide').show(500);
    });

    $('#get_dates').on('click',function(){
        var dates = $(this).parent().siblings('input').val();

        location.href = "/admin/table?dates=" + dates;
    });

    // получаем get параметр дат
    var url = new URL(location.href),
        dates = url.searchParams.get("dates");

    if(dates != null) {
        dates = dates.split(" - ");
    }

    var Data = new Date(),
        Year = Data.getFullYear(),
        Month = Data.getMonth() + 1,
        Day = Data.getDate(),
        Hours = Data.getHours(),
        Minutes = Data.getMinutes();

    $('#reservationtime').daterangepicker({
        "timePicker": true,
        timePicker24Hour: true,
        autoApply: true,
        locale: {
            format: 'MM/DD/YYYY hh:mm',// hh:mm
            separator: " - ",
            applyLabel: "Применить",
            cancelLabel: "Отмена",
            customRangeLabel: "Custom",
            daysOfWeek: [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            monthNames: [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            firstDay: 1,
        },
        startDate: dates != null ? dates[0] : Month + "/" + Day + "/" + Year + " " + Hours + ":" + Minutes,
        endDate: dates != null ? dates[1] : Month + "/" + Day + "/" + Year + " " + Hours + ":" + Minutes,
        showCustomRangeLabel: false
    }, function(start, end, label) {
        //console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });

    $(".formula-block .coin_btn").on("click",function(e){
        e.preventDefault();

        $(".formula-block .coin_btn").parent().removeClass('active');
        $(this).parent().addClass('active');

        var id = $(this).attr('rel'),
            type = $(".active .settings_btn").attr('rel');

        $.pjax.reload({
            container: '#pjax-form',
            url: $(this).attr("href"),
            type: 'GET',
            data: {coin: id, type: type},
            push       : false,
            replace    : false,
            timeout    : 1000,
        });
    });

    $(".formula-block .settings_btn").on("click",function(e){
        e.preventDefault();

        $(".formula-block .settings_btn").parent().removeClass('active');
        $(this).parent().addClass('active');

        var type = $(this).attr('rel'),
            id = $(".active .coin_btn").attr('rel');

        $.pjax.reload({
            container: '#pjax-form',
            url: $(this).attr("href"),
            type: 'GET',
            data: {coin: id, type: type},
            push       : false,
            replace    : false,
            timeout    : 1000,
        });
    });

    $('#table_coins').DataTable({
        paging          : false,
        lengthChange    : false,
        searching       : false,
        ordering        : true,
        info            : false,
        autoWidth       : false,
        orderCellsTop   : false,
        //order           : [[6, 'desc']],
        orderFixed      : [6, 'desc'],
        aoColumnDefs    : [
          {
              bSortable: false,
              aTargets : [0, 1, 2, 3, 4, 5, 7, 8]
          }
        ]
    });

    $('#table_dublicats').DataTable({
        paging          : true,
        lengthChange    : false,
        searching       : false,
        ordering        : false,
        info            : false,
        autoWidth       : false,
        orderCellsTop   : false,
        //order           : [[6, 'desc']],
        //orderFixed      : [6, 'desc'],
        /*aoColumnDefs    : [
            {
                bSortable: false,
                aTargets : [0, 1, 2, 3, 4, 5, 7, 8]
            }
        ]*/
    });

    $(".blocks__update .blocks-btn_update").on("click",function(e){
        e.preventDefault();

        $(".blocks__update .blocks-btn_update").parent().removeClass('active');
        $(this).parent().addClass('active');

        $.pjax.reload({
            container: '#pjax-blocks',
            url: $(this).attr("href"),
            type: 'GET',
            push       : false,
            replace    : false,
            timeout    : 1000,
        });
    });

    $(document).on('change', '#coins-type', function() {
        var value = $(this).val();

        if(value == 0) {
            $('.field-coins-smart_contracts').removeClass('hide');
            $('.field-coins-platform').addClass('hide');
            //$('.field-coins-mining').addClass('hide');
        } else if(value == 1) {
            $('.field-coins-smart_contracts').addClass('hide');
            $('.field-coins-platform').removeClass('hide');
            //$('.field-coins-mining').removeClass('hide');
        }
    });
});

$(function () {
    $.fn.size = function () {
        return this.length;
    }
});