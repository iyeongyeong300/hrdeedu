
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
            setValume($('#audio1')[0], bla.val/100.0);
            setValume($('#audio2')[0], bla.val/100.0);
            setValume($('#audio3')[0], bla.val/100.0);
            setValume($('#sndCorrect')[0], bla.val/100.0);
            setValume($('#sndInCorrect')[0], bla.val/100.0);
            console.log('음량 - ' + bla.val);
            break;
        case 'playPause':
            if(isVideoStage)
            {
                setValume($('#video1')[0], bla.val/100.0);
                playPause($('#video1')[0]); // 자동재생 안됨.
            }
            break;
        case 'responseContent':
            contentsRun(bla.val);
            break;
        case 'setCurrentTime':
            if(!isVideoStage) return;
            $('#video1')[0].currentTime = bla.val * $('#video1')[0].duration;
            break;
    }
}
var isVideoStage = false;
function frmReady(){
    var duration = { type: 0, name : 'videoLen', val : $('#video1')[0].duration };
    processFn(duration);
}

var currentQuestion = -1;
var isWrong = false;
var wrongCnt = 0;
var isOpenedPup = false;
var isCorrectAtLast = false;
var isShownSolution = false;
function showSolution(){
    $('#_coverCorrectPup').hide();
    $('#_coverWrongPup').hide();

    if(isCorrectAtLast || isWrong)
    {
        isWrong = false;
        wrongCnt = 0;
        isOpenedPup = true;
        isShownSolution = true;
        {
            if(currentQuestion+1 >= oxResource.questionCnt)
            {
                $('#_nextBtn').hide();
                $('#_lastBtn').show();
                setContentStage(4);
            }else{
                if(currentQuestion == 0) $('#_nextBtn').show();
                $('#_lastBtn').hide();
                setContentStage(3);
            }
        }
//        playPause($('#audio3')[0]);
        $('#_answer').show();
        $('#_answer').attr("style", "background:url('./src/img/answer"+(currentQuestion+1)+".png') no-repeat; background-size: 100% 100%;");
    }
}
function openCoverPup(isCorrect, sec){
    if(isOpenedPup) return;
    if(isCorrect)
    {
        $('#_coverCorrectPup').show();
        if($('#sndCorrect')[0].currentTime)
        $('#sndCorrect')[0].currentTime = 0;
        $('#sndCorrect')[0].play();
    	$('#sndCorrect')[0].onended = function() {
            if($('#audio2')[0].currentTime)
            $('#audio2')[0].currentTime = 0;
        	$('#audio2')[0].play();
    	};
    }
    else{
        wrongCnt++;
        $('#_coverWrongPup').show();
        if($('#sndInCorrect')[0].currentTime)
        $('#sndInCorrect')[0].currentTime = 0;
        $('#sndInCorrect')[0].play();
    	$('#sndInCorrect')[0].onended = function() {
            if($('#audio2')[0].currentTime)
            $('#audio2')[0].currentTime = 0;
        	$('#audio2')[0].play();
    	};
    }
    isCorrectAtLast = isCorrect;
    if(allowMaxIncorrectCnt < wrongCnt) isWrong = true;
    $('#_btnO').hide();
    $('#_btnX').hide();
    $('#audio1')[0].pause();
    $('#audio2')[0].pause();
    $('#audio3')[0].pause();
    setContentStage(3);

    $('#_coverCorrectPup').click(function(){
        $('#_coverCorrectPup').hide();
        if(!isShownSolution)
            showSolution();
    });
    $('#_coverWrongPup').click(function(){
        $('#_coverWrongPup').hide();
        if(!isShownSolution)
            showSolution();
    });

    setTimeout(function(){
        if(!isShownSolution)
            showSolution();
    }, sec);
}
function nextQuestion(){
    if(currentQuestion+1 >= oxResource.questionCnt)
    {
        return;
    }else{
        currentQuestion++;
    }
    setContentStage(2);
    isShownSolution = false;
    isOpenedPup = false;
    $('#_btnO').show();
    $('#_btnX').show();

    $('#_chooseO').hide();
    $('#_chooseX').hide();
    $('#_nextBtn').hide();
    $('#_lastBtn').hide();
    $('#audio1')[0].pause();
    $('#audio2')[0].pause();
    $('#audio3')[0].pause();
    $('#sndCorrect')[0].pause();
    $('#sndInCorrect')[0].pause();

    $('#_questionNo1').hide();
    $('#_questionNo2').hide();
    if(oxResource.questionCnt > 1)
        $('#_questionNo'+(currentQuestion+1)).show();
    $('#audio1').attr('src', oxResource.audio[currentQuestion*3]);
    $('#audio1')[0].load();
    $('#audio1')[0].onloadeddata = function() {
        $('#audio1')[0].play();
    };
    $('#audio2').attr('src', oxResource.audio[currentQuestion*3+1]);
    $('#audio2')[0].load();
    $('#audio3').attr('src', oxResource.audio[currentQuestion*3+2]);
    $('#audio3')[0].load();
    $('#_question').show();
    if(currentQuestion == 0)
    {
        $('#_question').attr("style", "background:url('./src/img/quiz"+(currentQuestion+1)+".png') no-repeat; background-size: 1200px;");
        $('#_example').attr("style", "background:url('./src/img/example"+(currentQuestion+1)+".png') no-repeat; background-size: 1200px;");
    } else {

		//$('#_question').attr("style", $('#_question').attr("style").replace("url('./src/img/quiz"+(currentQuestion)+".png') no-repeat;","url('./src/img/quiz"+nextQuestionVariable+".png') no-repeat;"));
        //$('#_example').attr("style", $('#_example').attr("style").replace("url('./src/img/example"+(currentQuestion)+".png') no-repeat;","url('./src/img/example"+nextQuestionVariable+".png') no-repeat;"));
		/**
		* Date  : 2020.09.11
		* 수정사항 : 익스플로러 버전 11.1082.18362.0  replace 가 제대로 작동하지 않는 문제로 인하여 자바스크립트로 대체 
		*/
		
		var nextQuestionVariable = Number(currentQuestion) +1 ;
		document.getElementById('_question').style.backgroundImage = "url(./src/img/quiz"+nextQuestionVariable+".png)";
		document.getElementById('_example').style.backgroundImage = "url(./src/img/example"+nextQuestionVariable+".png)";
        
    }
    $('#_answer').hide();
}

function run(){
    setContentStage(1);
    $('#stage2').hide();
    $('#stage3').hide();
    // stage1
    $('#video1>source').attr('src', contents.target[0]);
    $('#video1')[0].load();
    $('#video1')[0].onloadeddata = function() {
        frmReady();
        $('#video1')[0].play();
        isVideoStage = true;
        setInterval(function(){
            frmSeekChg();
        }, 100);
    };
    
    $('#audio1')[0].onended = function() {
        playPause($('#audio3')[0]);
    };
    var stage1Timer = setInterval(function(){
        if($('#video1')[0].currentTime < 1)
            $('#_skipBtn').hide();
        else if($('#video1')[0].currentTime > $('#video1')[0].duration - 0.1)
        {
            isVideoStage = false;
            $('#_skipBtn').hide();
            clearInterval(stage1Timer);
            $('#stage2').show();
            $('#stage1').hide();
            $('#stage3').hide();
            setContentStage(2);

            // stage2
            $('#body').removeClass('bg2');
            $('#body').addClass('bg1');
            oxResource.choosen.length = oxResource.questionCnt;
            nextQuestion();
            $('#_answer').click(function(){
                playPause($('#audio2')[0]);
            });
            $('#_answerEnd').click(function(){
                playPause($('#audio2')[0]);
            });
            $('#_question').click(function(){
                playPause($('#audio1')[0]);
            });
            $('#_nextBtn').click(function(){
                nextQuestion();
            });
            $('#btnQuestion').click(function(){
                if(!isShownSolution)
                {
                    playPause($('#audio1')[0]);
                    $('#audio2')[0].pause();
                    if($('#audio2')[0].currentTime)
                    $('#audio2')[0].currentTime = 0;
                    $('#audio3')[0].pause();
                    if($('#audio3')[0].currentTime)
                    $('#audio3')[0].currentTime = 0;
                }
            });
            $('#btnExample').click(function(){
                if(!isShownSolution)
                {
                    $('#audio1')[0].pause();
                    if($('#audio1')[0].currentTime)
                    $('#audio1')[0].currentTime = 0;
                    $('#audio2')[0].pause();
                    if($('#audio2')[0].currentTime)
                    $('#audio2')[0].currentTime = 0;
                    playPause($('#audio3')[0]);
                }
            });
            
            $('#_lastBtn').click(function(){
                setContentStage(5);
                $('#stage1').hide();
                $('#stage2').hide();
                $('#stage3').show();
                $('#audio1')[0].pause();
                $('#audio2')[0].pause();
                $('#audio3')[0].pause();
                $('#sndCorrect')[0].pause();
                $('#sndInCorrect')[0].pause();
                // 점수 계산 총 점수 questionCnt
                var cntCorrect = 0;
                for(var inx=0; inx<oxResource.questionCnt; inx++)
                {
                    if(oxResource.answers[inx] == oxResource.choosen[inx])
                        cntCorrect++;
                }
                $('#body').removeClass('bg1');
                $('#body').addClass('bg2');
                $('#_lyrTotQst').show();
                $('#_lyrCorrectQst').show();
                $('#_lyrTotQst').attr("style", $('#_lyrTotQst').attr("style") + " background:url('./src/img/total_numbers/"+(oxResource.questionCnt)+".png') no-repeat; background-size: 100%;");
                $('#_lyrCorrectQst').attr("style", $('#_lyrCorrectQst').attr("style") + " background:url('./src/img/correct_numbers/"+(cntCorrect)+".png') no-repeat; background-size: 100%;");
                
                completeStudy(targetNumber);
                $('#_nextBalloon').show();
            });
            $('#_btnO').click(function(){
                $('#_chooseX').hide();
                oxResource.choosen[currentQuestion] = 1;
                if(oxResource.answers[currentQuestion] == 1)
                {
                    $('#_chooseO').show();
                    openCoverPup(true, 1400);
                } else {
                    $('#_chooseO').show();
                    openCoverPup(false, 900);
                }
            });
            $('#_btnX').click(function(){
                $('#_chooseO').hide();
                oxResource.choosen[currentQuestion] = 0;
                if(oxResource.answers[currentQuestion] == 0)
                {
                    $('#_chooseX').show();
                    openCoverPup(true, 1400);
                } else {
                    $('#_chooseX').show();
                    openCoverPup(false, 900);
                }
            });
            $('#_nextBalloon').hide();
        }
        else
            $('#_skipBtn').show();
    }, 100);
    $('#_skipBtn').click(function(){
        $('#video1')[0].currentTime = $('#video1')[0].duration - 1;
    });
}