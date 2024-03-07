
// 틀려도 봐주는 횟수 설정
var allowMaxIncorrectCnt = 0;

var oxResource = {
    // 문제 형식 : 1=돌발퀴즈
    type : 1
    // 퀴즈 갯수
    , questionCnt : 2
    // 답안 리스트 X=0 , O=1
    , answers : [ 0, 0 ]
    
    // 아래 음성은 매번 교체가 필요합니다. = 질문 , 답변, 예시 한쌍
    , audio : [
        './audio/문제1.mp3', './audio/해설1.mp3', './audio/예시상황1.mp3'
        , './audio/문제2.mp3', './audio/해설2.mp3', './audio/예시상황2.mp3'
    ]
    // 아래 파일은 있어야 할 경우에만 넣어주세요.
    , downloads : [
    ]
    // 학습자 입력 값
    , choosen : []
};