
var targetNo = 0;

function response(e){
    var bla = e;
    console.log(bla);
    switch(bla.name){
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
            $('#video1')[0].currentTime = bla.val * $('#video1')[0].duration;
            break;
    }
}
function frmReady(){
    var duration = { type: 0, name : 'videoLen', val : $('#video1')[0].duration };
    processFn(duration);
}

function run(){
    $('#video1>source').attr('src', contents.target[0]);
    $('#video1')[0].load();
    $('#video1')[0].onloadeddata = function() {
        frmReady();
        $('#video1')[0].play();
        setInterval(function () {
            frmSeekChg();
        }, 100);
    };
    $('#_AtLastBalloon').hide();
    setInterval(function () {
        if($('#video1')[0].currentTime < 1)
            $('#_skipBtn').hide();
        else if($('#video1')[0].currentTime > $('#video1')[0].duration - 1)
        {
            $('#_skipBtn').hide();
            if(targetNo == 0)
            {
                targetNo = 1;
                $('#video1>source').attr('src', contents.target[1]);
                $('#video1')[0].load();
                $('#video1')[0].onloadeddata = function() {
                    frmReady();
                    setInterval(function() {
                        frmSeekChg();
                    }, 100);
                };
                playPause($('#video1')[0]);
            } else if(targetNo == 1){
                completeStudy(targetNumber);
//                $('#_AtLastBalloon').show();
            }
        }
        else
            $('#_skipBtn').show();
    }, 100);
    $('#_skipBtn').click(function(){
        $('#video1')[0].currentTime = $('#video1')[0].duration - 1;
    });
}