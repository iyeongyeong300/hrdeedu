<?
$MenuType = "";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	
            <div class="main_wrap">
				<div class="mainImg">
					<img src="/hrd_manager/images/img_main.png" alt="main">
				</div>			
				<div class="mainInfo">
					<p class="txt01"><strong><?=$LoginAdminName?></strong> 님<br> 반갑습니다!</p>
					<p class="txt02">상단의 메뉴를 눌러 이동하시기 바랍니다.</p>
					<p class="txt03">
						로그인 시간 : <?=$LoginDate?><br />
						접속 IP : <?=$UserIP?><br />
						연결된 서버 IP : <?=$ServerIP?><br />
					</p>
				</div>
			</div>
			
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>