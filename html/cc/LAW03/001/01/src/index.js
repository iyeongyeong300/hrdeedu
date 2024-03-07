
function response(e){
    var bla = e;
    switch(bla.name){
        case 'videoLen':
            var time = Math.round(bla.val);
            $('.time1>div').text('00:00');
            $('.time2>div').text((time / 60) + ':' + (time % 60));
            break;
        case 'valume':
            setValume($('#video1')[0], bla.val/100.0);
            console.log('음량 - ' + bla.val);
            break;
        case 'playPause':
            setValume($('#video1')[0], bla.val/100.0);
            playPause($('#video1')[0]); // 자동재생 안됨.
            break;
        case 'responseContent':
            contentsRun(bla.val);
            break;
        case 'setCurrentTime':
            // stage 가 없는 경우
            $('#video1')[0].currentTime = bla.val * $('#video1')[0].duration;
            break;
    }
}

function movieReset(){
    var myVideo = $('#video1')[0];
    myVideo.currentTime = 0;
    $('#_skipBtn').hide();
}
function frmReady(){
    var duration = { type: 0, name : 'videoLen', val : $('#video1')[0].duration };
    processFn(duration);
}
var isSkip = false;
function run(){
    $('#video1>source').attr('src', contents.target);
    $('#video1')[0].load();
    $('#video1')[0].onloadeddata = function() {
        frmReady();
        $('#video1')[0].play();
        setInterval(function(){
            frmSeekChg();
        }, 100);
    };
    $('#video1')[0].onended = function() {
        completeStudy(targetNumber);
        if(isSkip)
        {
            var gotoPage = { type: 0, name : 'gotoMenu', val : 1 };
            processFn(gotoPage);
        }
    };
    setInterval(function() {
        if($('#video1')[0].currentTime > $('#video1')[0].duration - 2
            || $('#video1')[0].currentTime < 1)
        {
            $('#_skipBtn').hide();
        }
        else
            $('#_skipBtn').show();
    }, 100);
    $('#_skipBtn').click(function(){
        $('#video1')[0].currentTime = $('#video1')[0].duration - 1;
        isSkip = true;
    });
}