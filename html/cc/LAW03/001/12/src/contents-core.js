function playPause(myVideo){ 
    if (myVideo.paused) 
    {
        var playPromise = myVideo.play(); 
        if (playPromise !== null){
            playPromise.catch(function() { myVideo.play(); })
        }
    }
    else 
        myVideo.pause(); 
};
function setValume(myVideo, val){
    myVideo.volume = val;
}
function receiveParentMessage(e) {
    response(e);
    
    var bla = event.data;
    switch(bla.name){
        case 'playMovie':
            if($('#video1')[0]) $('#video1')[0].play();
            break;
        case 'pauseMovie':
            if($('#video1')[0]) $('#video1')[0].pause();
            break;
    }
}
function contentsRun(content){
    contents = content;
    run();
}
function contentsBoot(){
    var reqContent = { type: 0, name : 'reqContent', val : targetNumber };
    processFn(reqContent);
}
function movieReset(){
    location.reload();
}
function frmSeekChg(){
    var duration = { type: 0, name : 'seekBarChange', val : $('#video1')[0].currentTime };
    processFn(duration);
}
function sendPause(val){
    var sendPlayVal = { type: 0, name : 'sendPause', val : val };
    processFn(sendPlayVal);
}
function setContentStage(val){
    var contentStage = { type: 0, name : 'setContentStage', val : val };
    processFn(contentStage);
}
function sendPrint(){
    var printAction = { type: 0, name : 'printPage', val : 0 };
    processFn(printAction);
}

function completeStudy(tg){
    var duration = { type: 0, name : 'completeStudy', val : tg };
    processFn(duration);
    
    if(contents.lastNo-1 > targetNumber)
    {
        $('#_nextBalloon').show();
        $('#_lastBalloon').hide();
    }
    else
    {
        $('#_nextBalloon').hide();
        $('#_lastBalloon').show();
    }
}
$(document).ready(function(){
    contentsBoot();
    sendPause(1);
    setContentStage(0);
});