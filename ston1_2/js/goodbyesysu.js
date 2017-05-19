$(function() {

    var n = 0;
    showFirst()
    $('.nextpage').click(function() {
        n++;
        if (n == 1) {
            $('#firstpage').animate({ 'height': 0 }, 500);
            showSecond();
        }
        if (n == 2) {
            $('#secondpage').animate({ 'height': 0 }, 500);
            showThird();
        }
        if (n == 3) {
            $('#thirdpage').animate({ 'height': 0 }, 500);
            showFour();
            n = 0;
        }
    })
    $('.grp02-second').click(function() {
        $('#secondpage').animate({ 'height': 0 }, 500);
        showThird();
        n = 2;
    })
    $('#touchgodown').click(function() {
        $('#firstpage').animate({ 'height': 0 }, 500);
        showSecond()
    })
    $('#back').click(function() {
        $('.part01-first').animate({ 'opacity': 1 }, 200);
        $('.page').animate({ 'height': '100%' }, 500);
        $('#firstpage').animate({ 'height': '100%' }, 500);
    })
    $('#firstpage').on('swipeup', function(e) {
        $(this).animate({ 'height': 0 }, 500);
        showSecond()
    })
    $('#secondpage').on('swipeup', function(e) {
        $(this).animate({ 'height': 0 }, 500);
        showThird();
    })
    $('#secondpage').on('swipedown', function(e) {
        $('.part01-first').animate({ 'opacity': 1 }, 200);
        $('#firstpage').animate({ 'height': '100%' }, 500);
    })
    $('#thirdpage').on('swipeup', function(e) {
        $(this).animate({ 'height': 0 }, 500);
        showFour()
    })
    $('#thirdpage').on('swipedown', function(e) {
        $('#secondpage').animate({ 'height': '100%' }, 500);
    })
    $('#fourpage').on('swipedown', function(e) {
        $('#thirdpage').animate({ 'height': '100%' }, 500);
    })

    function showFirst() {
        $('.part01-first').animate({ 'opacity': 1 }, 500, function() { $('.part02-first').animate({ 'opacity': 1 }, 500, function() { $('.part04-first').animate({ 'opacity': 1 }, 500, function() { $('.nextpage').animate({ 'opacity': 1 }, 500) }) }) });
    }

    function showSecond() {
        $('.part01-first').animate({ 'opacity': 0 }, 500);
        $('.part01-second').animate({ 'opacity': 1 }, 1000, function() { $('.grp01-second').animate({ 'opacity': 1 }, 500, function() { $('.grp02-second').animate({ 'opacity': 1 }, 500) }) })
    }

    function showThird() {
        $('.p1txt').animate({ 'opacity': 1 }, 1000, function() { $('.part02-third').animate({ 'opacity': 1 }, 500, function() { $('.textbox').animate({ 'opacity': 1 }, 500) }) })
    }

    function showFour() {
        $('.part01-four img').animate({ 'width': 300 }, 1000, function() { $('#back').animate({ 'opacity': 1 }, 500) });
        $('.copyright').animate({ 'opacity': 1 }, 2000);
    }
    $('.schedule').click(function() {
        $('.schedulebox').animate({ 'bottom': 0 }, 800);
    })
    $('#scheduleheader').click(function() {
        $('.schedulebox').css({ 'bottom': '-200%' }, 500);
    })
    $('.photobtn').click(function() {
        $('.photobox').animate({ 'bottom': 0 }, 800);
    })
    $('#photoheader').click(function() {
        $('.photobox').css({ 'bottom': '-200%' }, 500);
    })
    $('.messagebtn').click(function() {
        $('.messagebox').animate({ 'bottom': 0 }, 800);
        $('.messagebg').fadeIn();
        loadComment(undefined, undefined, true);
    })
    $('.closemess').click(function() {
        $('.messagebox').animate({ 'bottom': '-100%' }, 500);
        $('.messagebg').fadeOut();
        $(window).scrollTop(0)
    })
    $('.contacttable').click(function() {
        $('.timebox').animate({ 'height': '100%' }, 500);
    })
    $('#timeheader').click(function() {
        //$('.timebox').css({'-webkit-transform':'translate(0,0)'});
    })
    $('.messicon').click(function() {
        $('#scroller2').css({ '-webkit-transform': 'translate(0,0)' })
        $('.messarea').focus();
    })
    $('.messarea').focus(function() {
        $(this).val('');
    })

});