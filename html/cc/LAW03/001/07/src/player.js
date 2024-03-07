var saveData;
var contentNo;
var duration;
var contentStage = 0;

$(document).ready(function() {
    if ( navigator.appName == "Microsoft Internet Explorer" )
    {
        alert('호환되지 않는 브라우저 입니다. chrome 또는 Internet Explorer 11 이상을 사용해 주세요.');
    }
});
function getSaveData(target){
    return localStorage.getItem(target);
}
function setSaveData(target, value){
    saveData=localStorage.setItem(target, value);
}
function setCookie(cookie_name, value) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + 1);
    var cookie_value = escape(value) + '; expires=' + exdate.toUTCString();
    document.cookie = cookie_name + '=' + cookie_value;
}
function getCookie(cookie_name) {
    var x, y;
    var val = document.cookie.split(';');
  
    for (var i = 0; i < val.length; i++) {
      x = val[i].substr(0, val[i].indexOf('='));
      y = val[i].substr(val[i].indexOf('=') + 1);
      x = x.replace(/^\s+|\s+$/g, '');
      if (x == cookie_name) {
        return unescape(y);
      }
    }
  }
var prevDuration = 0;
function processFn(event) {
    var bla = event;
    switch(bla.name){
        case 'reqContent':
            var responseContent = {
                name : 'responseContent'
                ,val : contentsData.menus[bla.val].content
            };
            response(responseContent);
            break;
        case 'videoLen':
            var time = Math.round(bla.val);
            duration = time;
            $('.time1>div').text('00:00');
            $('.time2>div').text('/ ' + (Math.floor(time / 60) < 10 ? '0' : '')+Math.floor(time / 60) + ':' + (Math.floor(time % 60) < 10 ? '0' : '') + Math.floor(time % 60));
            break;
        case 'clearContent':
            contentNo = bla.val; 
            break;
        case 'saveData':
            saveData = bla.val;
            setSaveData('hrd-'+chasiCode+'_'+bla.type, saveData);
            break;
        case 'loadData':
            var usrData = {
                name : 'getUsrData'
                ,saved1 : getSaveData('hrd-'+chasiCode+'_1')
                ,saved2 : getSaveData('hrd-'+chasiCode+'_2')
            };
            response(usrData);
            break;
        case 'seekBarChange':
            var time = Math.round(bla.val);
            if(prevDuration != bla.val)
            {
                $('._contentsPlayAndStopBtn>img').show();
            } else {
                $('._contentsPlayAndStopBtn>img').hide();
            }
            prevDuration = bla.val;
            $('.time1>div').text((Math.floor(time / 60) < 10 ? '0' : '')+Math.floor(time / 60) + ':' + (Math.floor(time % 60) < 10 ? '0' : '') + Math.floor(time % 60));
            $('.mask').attr('style', 'width:'+((duration-time)/duration*100)+'%;');
            break;
        // 완강처리 -> 다음 섹션 오픈
        case 'completeStudy':
            contentsData.menus[bla.val].complete = true;
            setSaveData('hrd-'+chasiCode+'_c'+(Number(bla.val)+1), true);
            break;
        case 'gotoMenu':
            var index = bla.val; // 특정 페이지로 이동
            currentPageNo = index;
            setMenuPup();
            setValumeMain();
            $('._presPageNo>div').text(currentPageNo+1);
            document.location.href = contentsData.menus[currentPageNo].action;
            break;
        case 'sendPause':
            var isPause = bla.val;
            if(isPause == 1) 
                {
                    var agent = navigator.userAgent.toLowerCase(),
                            name = navigator.appName,
                            browser = '';
                    if(!clickAtOnce && agent.indexOf('chrome') > -1) return;
                    
                    $('._contentsPlayAndStopBtn>img').show();
                }
            else 
                {
                    $('._contentsPlayAndStopBtn>img').hide();
                }
            break;
        case 'setContentStage':
            contentStage = bla.val;
            break;
        case 'printPage':
            window.print();
            break;
    }
}

function setValumeMain(){
    var valume = { type: 0, name : 'valume', val : $( "#amount" ).val() };
    response(valume);
}

function setMenuPup(){
    
    var preMenuGrpNo = 0;
    var htmlSrc = '<p class="title_area" style="text-align: center;margin-top: 5%;margin-bottom: 20%;font-size: larger;"><span>'+contentsData.title1.main+'</span><span class="line"></span><span>'+contentsData.title1.sub+'</span></p>';
    htmlSrc += '<div style="'
                + 'margin: 3%;'
                + 'padding-left: 14%;'
                + 'overflow-y: scroll;'
                + 'height: 67%;'
                + '">';
    
    for(var inx=0; inx<contentsData.menus.length; inx++)
    {
        if(contentsData.menus[inx].grpNo != preMenuGrpNo)
        {
            preMenuGrpNo = contentsData.menus[inx].grpNo;
            if(inx != 0)
            {
                htmlSrc += '</ul>';
            }
            htmlSrc += '<span style="font-size: larger;">'
                            + '<div style="'
                            + 'background: url('+contentsData.group[contentsData.menus[inx].grpNo-1].icon+') no-repeat;'
                            + 'background-size: 35px auto;'
                            + 'width: 14%;'
                            + 'height: 6%;'
                            + 'float: left;'
                        + '">&nbsp;</div>' +contentsData.group[contentsData.menus[inx].grpNo-1].name
                        + '</span><ul>';
        }
        
        if(contentsData.menus[inx].complete)
            setSaveData('hrd-'+chasiCode+'_c'+Number(Number(inx)+1), true);
        if(!contentsData.menus[inx].visible)
        {
            var allowVisiblePt = inx-1;
            while(allowVisiblePt > 0)
            {
                if(contentsData.menus[allowVisiblePt].visible)
                    break;
                allowVisiblePt--;
            }
            if(currentPageNo == allowVisiblePt)
            {
                htmlSrc += '<li style="color: darkorange;">'+contentsData.menus[allowVisiblePt].name+'</li>';
            } else {
                htmlSrc += '<li onclick="gotoMenu('+allowVisiblePt+')">'+contentsData.menus[allowVisiblePt].name+'</li>';
            }
        }else{
            if(currentPageNo == inx)
            {
                htmlSrc += '<li style="color: darkorange;">'+contentsData.menus[inx].name+'</li>';
            } else {
                htmlSrc += '<li onclick="gotoMenu('+inx+')">'+contentsData.menus[inx].name+'</li>';
            }
        }
    }
    htmlSrc += '</ul></div>';
    $('._menuBarPup').html(htmlSrc);
}
function gotoMenuBanner(index){
    var isComplete = true;
    for(var inx=0; inx<index; inx++){
//        if(!contentsData.menus[inx].complete){
    // 'hrd-'+chasiCode+'_c'+(Number(bla.val)+1)
        console.log('hrd-=['+inx+'] '+getSaveData('hrd-'+chasiCode+'_c'+inx));
        if(!getSaveData('hrd-'+chasiCode+'_c'+inx)){
            isComplete = false;
            break;
        }
    }
    if(isComplete) 
        gotoMenu(index);
    else
        openbeforeNextPup(10);
}
function openbeforeNextPup(no){
    $('#_beforeNextPup').removeClass('_section1');
    $('#_beforeNextPup').removeClass('_section2');
    $('#_beforeNextPup').removeClass('_section3');
    $('#_beforeNextPup').removeClass('_section4');
    $('#_beforeNextPup').removeClass('_section5');
    $('#_beforeNextPup').removeClass('_section6');
    $('#_beforeNextPup').removeClass('_section7');
    $('#_beforeNextPup').removeClass('_section8');
    $('#_beforeNextPup').removeClass('_section9');
    $('#_beforeNextPup').removeClass('_section10');
    $('#_beforeNextPup').removeClass('_section11');
    $('#_beforeNextPup').removeClass('_section12');
    $('#_beforeNextPup').removeClass('_section13');
    $('#_beforeNextPup').addClass('_section'+no);
    $('#_beforeNextPup').show();
    setTimeout(function(){
        $('#_beforeNextPup').hide();
    }, 900);
}
function gotoValidation(index){
    if(!getSaveData('hrd-'+chasiCode+'_c'+(Number(index)+1))){
        var ment = '아직 이전 학습을 하지 않았습니다.';
        
        switch(contentsData.menus[Number(index)].type){
            case 0:
            case 1:
                ment = '인트로 영상을 시청해 주세요.';
                return true;
            case 2:
                if(contentStage == 1)
                {
                    openbeforeNextPup(3);
                    return false;
                } else if (contentStage == 2){
                    openbeforeNextPup(4);
                    return false;
                } else if (contentStage == 3){
                    openbeforeNextPup(11);
                    return false;
                } else if (contentStage == 4){
                    openbeforeNextPup(12);
                    return false;
                }
                break;
            case 3:
            case 5:
                if(contentStage == 1)
                {
                    openbeforeNextPup(1);
                    return false;
                } else if(contentStage == 2)
                {
                    openbeforeNextPup(13);
                    return false;
                } else if(contentStage == 3)
                {
                    $('._thnkPup').show();
                    setTimeout(function(){
                        $('._thnkPup').hide();
                    }, 900);
                    return false;
                } else if (contentStage == 4){
                    openbeforeNextPup(2);
                    return false;
                }
                break;
            case 4:
                if(contentStage == 1)
                {
                    openbeforeNextPup(3);
                    return false;
                } else if (contentStage == 2){
                    openbeforeNextPup(4);
                    return false;
                } else if (contentStage == 3){
                    openbeforeNextPup(5);
                    return false;
                } else if (contentStage == 4){
                    openbeforeNextPup(6);
                    return false;
                }
                break;
            case 6:
            case 7:
            case 8:
            default:
                break;
        }
    }
    return true;
}
function gotoMenu(index){
    if(0 < index)
    {
        if(index < Number(currentPageNo)) ;
        else if(!gotoValidation(Number(currentPageNo))) return;
    }
    $('._contentsPlayAndStopBtn>img').hide();
    currentPageNo = index;
    setMenuPup();
    setValumeMain();
    $('._presPageNo>div').text(Number(currentPageNo)+1);
    document.location.href = contentsData.menus[Number(currentPageNo)].action;
}

var visibleHelpPup = true;
$('._helpPup').click(function(){
    $('._helpPup').fadeOut('slow');
});
var isOpenHelp = false;
$('._helpPupBtn').click(function(){
    if(!isOpenHelp)
    {
        $('._helpPup').fadeIn('slow'); isOpenHelp = true;
    }
    else
    {
        $('._helpPup').fadeOut('slow'); isOpenHelp = false;
    }
});
var isMenuVisible = false;
$('._menuBarBtn').click(function(){
    if(!isMenuVisible)
        $("._menuBarPup").fadeIn('slow');
    else
        $("._menuBarPup").fadeOut('slow');
    isMenuVisible = !isMenuVisible;
});
$('._contentsRtBtn').click(function(){
    $('._contentsPlayAndStopBtn>img').hide();
    document.location.href = contentsData.menus[Number(currentPageNo)].action;
});
var clickAtOnce = false;
$('._contentsPlayAndStopBtn').click(function(){
    clickAtOnce = true;
    var valume = { type: 0, name : 'playPause', val : $( "#amount" ).val() };
    response(valume);
    if($('._contentsPlayAndStopBtn>img').is(':visible'))
        $('._contentsPlayAndStopBtn>img').show();
    else
        $('._contentsPlayAndStopBtn>img').hide();
});
var visibleSoundToggle = true;
$('._soundBtn').click(function(){
    if(visibleSoundToggle)
    {
        $( "#slider-vertical" ).show(); $('.sound-slider-bg').show();
    }
    else
    {
        $( "#slider-vertical" ).hide(); $('.sound-slider-bg').hide();
    }
    visibleSoundToggle = !visibleSoundToggle;
});
var isFullSize = false;

$('._totPageNo>div').text(contentsData.menus.length);
$('._presPageNo>div').text(currentPageNo+1);
$( "#slider-vertical>div" ).hide();
$('._prevBtn').click(function(){
    if(currentPageNo < 1) {
        openbeforeNextPup(8);
        return;
    }
    gotoMenu(Number(currentPageNo)-1);
});
$('._seekBar').click(function (event) {
    var x = event.pageX;
    var x0 = $('._seekBar').offset().left;
    var x100 = $('._seekBar').width();
    var tgx = x - $('._seekBar').offset().left;
//    console.log('percent : '+((tgx / x100)*100) + ' %');
    var setMovieTime = {
        name : 'setCurrentTime'
        ,val : ((tgx / x100))
    };
    response(setMovieTime);
 });
$('._nextBtn').click(function(){
    if(Number(currentPageNo)+1 >= contentsData.menus.length){
        openbeforeNextPup(9);
        return;
    }
    gotoMenu(Number(currentPageNo)+1);
});
setMenuPup();

function getQuery(){
    var url = document.location.href;
    var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = decodeURIComponent(qs[i][1]);
    }
    return result;
}

$( function() {
    $( "#slider-vertical" ).slider({
        orientation: "vertical",
        range: "min",
        min: 0,
        max: 100,
        value: 60,
        slide: function( event, ui ) {
        $( "#amount" ).val( ui.value );
        setValumeMain();
        }
    });
    $( "#amount" ).val( $( "#slider-vertical" ).slider( "value" ) );
    setTimeout(function(){
        $( "#slider-vertical>div" ).attr('style','height: 66%; background:#a9adb2 50% 50% repeat-x;');
        $( "#slider-vertical>span" ).attr('style','display: none;');
    }, 200);
});