        
function response(e){
    var bla = e;
    console.log(bla);
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
            $('#video1')[0].currentTime = bla.val * $('#video1')[0].duration;
            break;
    }
}
$('#_skipBtn').hide();

function frmReady(){
    var duration = { type: 0, name : 'videoLen', val : $('#video1')[0].duration };
    processFn(duration);
}

function frmSeekChg(){
    var duration = { type: 0, name : 'seekBarChange', val : $('#video1')[0].currentTime };
    processFn(duration);
}

var conIdxPdf = 0;
var conIdxHwp = 0;
function commonMovieAction(){
    // 영상 공통 버튼 노출 확인
    if(contents.lateBtn)
    {
        var isPrintable = false;
        var isDownloadablePdf = false;
        var isDownloadableHwp = false;

		for(var inx=0; inx<contents.lateBtn.length; inx++)
        {
            if(contents.lateBtn[inx].stt_time < $('#video1')[0].currentTime 
				&& $('#video1')[0].currentTime < contents.lateBtn[inx].end_time)
            {
                if(contents.lateBtn[inx].pause && !contents.lateBtn[inx].isUsed)
                {
                    sendPause(0);
                    contents.lateBtn[inx].isUsed = true;
                    $('#video1')[0].pause();
					$('#_downloadPdfBtn').show(); //20210118 추가
					$('#_downloadHwpBtn').show(); //20210118 추가
					$('#_nextPlay').show();       //20210118 추가
                }
                if(contents.lateBtn[inx].type == 'print') 
                {
                    $('#_printBtn').off().on('click', function(){ window.print(); });
                    isPrintable = true;
                }
                if(contents.lateBtn[inx].type == 'pdf') 
                {
                    conIdxPdf = inx;
                    $('#_downloadPdfBtn').off().on('click', function(){ window.open(contents.lateBtn[conIdxPdf].file); });
                    isDownloadablePdf = true;
                }
                if(contents.lateBtn[inx].type == 'hwp') 
                {
                    conIdxHwp = inx;
                    $('#_downloadHwpBtn').off().on('click', function(){ window.open(contents.lateBtn[conIdxHwp].file); });
                    isDownloadableHwp = true;
                }
            }else {
                contents.lateBtn[inx].isUsed = false;
            }
        }
        if(!isPrintable) $('#_printBtn').hide(); 
		else $('#_printBtn').show();
        //if(!isDownloadablePdf) $('#_downloadPdfBtn').hide(); else $('#_downloadPdfBtn').show();
        //if(!isDownloadableHwp) $('#_downloadHwpBtn').hide(); else $('#_downloadHwpBtn').show();
    }
}
function run(){
    setContentStage(1);
    $('#_skipBtn').hide();
    $('#video1>source').attr('src', contents.target);
    $('#video1')[0].load();
    sendPause(1);
    $('#video1')[0].onloadeddata = function() {
        frmReady();
        $('#video1')[0].play();
        setInterval(function() {
            frmSeekChg();
            commonMovieAction();
        }, 100);
    };
    $('#video1')[0].onended = function() {
        completeStudy(targetNumber);
        sendPause(0);
    };
}