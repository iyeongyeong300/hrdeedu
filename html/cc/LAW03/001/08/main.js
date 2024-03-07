var contentsData = {
    // 메인 타이틀 
    title1 : {
        main : '법정의무교육'                       // 주 타이틀명 
        , sub : '직장내 장애인 인식개선'    // 서브 타이틀명
    } 
    // 메뉴 그룹 관리
    ,group : [
        {
            no : 1
            , name : '시작하기'
            , icon : './src/img/icon1.png'
        },
        {
            no : 2
            , name : '학습하기'
            , icon : './src/img/icon2.png'
        },
        {
            no : 3
            , name : '정리하기'
            , icon : './src/img/icon3.png'
        }
    ],
    // 컨텐츠 메뉴 관리 
    menus : [
        {
            no : 1                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '01_인트로'                // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 1
            , type : 0                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true                          // 완강 구분자 : 무시하고 다음으로 넘어갈도 되면 true
            , visible : true                            // 메뉴에 출력여부
            , action : '../01/index.html'       // 실제 서브 화면
            , content : {
                target : './video/int_main.mp4'  //
                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 2                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '02_사례로 보는 직장내 장애인 인식개선'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../02/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []
                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 3                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '03_알쓸신법_장애인과 함께 일하기'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../03/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []
                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 4                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '04_학습목표1'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../04/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 5                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '05_학습목표2'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../05/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 6                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '06_학습목표3'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../06/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }
       
        , {
            no : 7                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '07_돌발퀴즈'                // 돌발퀴즈 신규 개발
            , grpNo : 2
            , type : 4                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true                          // 완강 구분자 : 무시하고 다음으로 넘어갈도 되면 true
            , visible : true                            // 메뉴에 출력여부
            , action : '../07/index.html'       // 실제 서브 화면
            , content : {
                target : ['./video/int_quiz.mp4']  //
                , lastNo : 12                       // 총수량
            }
        }

        
              , {
            no : 8                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '08_학습목표4'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../08/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }
              , {
            no : 9                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '09_학습목표5'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../09/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 10                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '10_학습목표6'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../10/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }

              , {
            no : 11                              // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '11_학습목표7'            // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 2
            , type : 1                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible  : true
            , action   : '../11/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content  : {
                target : './video/lect_p.mp4'
                // 강의 영상 도중 다운로드 버튼 및 출력하기 버튼 생성. (수량 제한 없음.)
                , lateBtn : []


                , lastNo : 12                       // 총수량
            }
        }
        
        , {
            no : 12                             // 페이지번호 : 플레이어에서 이 번호를 기준으로 이동함
            , name : '12_아웃트로'              // 우측 메뉴바에 나타날 메뉴명 : 이 명칭도 최대한 중복되지 않도록 해야함
            , grpNo : 3
            , type : 0                          // 단순 영상 0, 학습영상 1, 진단 2, 고민하기 3, 퀴즈 4, 고민해결하기 5
            , complete : true
            , visible : true
            , action : '../12/index.html'     // 각 화면별 이미지나 음원, 텍스트가 어디에서 출력되어야 할지 저장되는 스크립트
            , content : {
                target : ['./video/out_next.mp4', './video/out_main.mp4']
                , lastNo : 12                      // 총수량
            }
        }      
    ]
    , bg : ''                           // 디폴트 백그라운드 이미지 (리소스가 없거나 로딩중일때 출력할 이미지)
    , loading_pup : ''                  // 디폴트 팝업 이미지 (리소스가 없거나 로딩중일때 출력할 이미지)
};