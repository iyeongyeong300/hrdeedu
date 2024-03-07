
var is_play = false;

document.addEventListener("DOMContentLoaded", () => {
	const inputField = document.getElementById("input");
	inputField.addEventListener("keydown", (e) => {
	if (e.isComposing) return //한글 두번입력때문에 제한
	if (e.code === "Enter") {
		let input = inputField.value;
		//input = input.replace(" ","");

		//한글체크추가
		const korean = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/;		 
		if( korean.test(input) ){
			inputField.value = "";
			execute_output(input);
		}else{
			alert("한글이 없습니다. 질문을 한글로 입력해주세요.");
			inputField.value = "";
			return;
		}
	}
	});
});




function execute_output(input) {
	
	var product;

	var text = input //입력문장


	console.log( search_nouns )
	var matched_nouns = []
	for (var x = 0; x < search_nouns.length; x++) {
		//console.log( search_nouns[x] )
		if( text.includes( search_nouns[x] ) ){
			matched_nouns.push( search_nouns[x] );
		}
	}
	console.log( "매칭된 명사 : " + matched_nouns ); //매칭된 명사
	//return
	//console.log( prompts )
	//console.log( replies )

	//return;
	if ( compare(prompts, replies, text) ) {  //질문 답변 상에서 정확하게 일치된것 찾기
		// Search for exact match in `prompts`
		product = compare(prompts, replies, text);
		// Update DOM
		addChat(input, product);

	} else { //질문 답변 상에서 정확하게 fuzzy 매치한것을 찾기

		product = compare_recommend(prompts, replies, text, matched_nouns);
		if( product.length ){
			addChatRecommend(input, product)
			const enterKey = 13
			const event = new KeyboardEvent('keydown',{'key':enterKey})
			document.dispatchEvent(event)
		}else{
			// If all else fails: random alternative
			//product = alternative[Math.floor(Math.random() * alternative.length)];
			//product = `안녕하세요 학습을 도와드리는 러비입니다. 질문을 입력해주세요.\n\n`;
			product = alternative[1]; //답변불능의 경우
			// Update DOM
			addChat(input, product);
		}
	}


}

//질문 답변 상에서 정확하게 fuzzy 매치한것을 찾기 - 답변추천하기
function compare_recommend(promptsArray, repliesArray, text, matched_nouns) {

	var reply;
	var replyFound = false;
	
	var matched_titles = []
	console.log( matched_nouns.length )
	console.log( matched_nouns )
	//return
	matched_nouns.sort(function(a, b){
	  // ASC  -> a.length - b.length
	  // DESC -> b.length - a.length
	  return b.length - a.length;
	});
	if( matched_nouns.length  ){ //단수처리		
		//for (var a = 0; a < matched_nouns.length; a++) {
		for (var a = 0; a < 1; a++) {
			console.log( "비교 : " + matched_nouns[a] )
			for (var x = 0; x < promptsArray.length; x++) {
				
				//console.log( getStringInBetween( matched_nouns[a], '<span style=display:none>' , '</span>') )
				//if( promptsArray[x][0].includes( matched_nouns[a] ) ){
				if( matched_nouns[a] == getStringInBetween( promptsArray[x][0], '<span style=display:none>' , '</span>') ){
					matched_titles.push( promptsArray[x][0] );
					console.log( "문장 : " + text  )
					console.log( "매칭 : " + promptsArray[x][0]  )
					//break;
				}
				
			}
		}
	}

	matched_titles = matched_titles.filter((value, index, matched_titles) => index === matched_titles.indexOf(value));
	console.log( matched_titles )
	console.log('추천하기');
	//return
	return matched_titles
}

//질문 답변 상에서 찾기
function compare(promptsArray, repliesArray, search) {

	var reply;
	var replyFound = false;

	//단수처리
	for (var x = 0; x < promptsArray.length; x++) {

		//console.log( promptsArray[x] )
		//console.log( "검색어 : " + search + " : 검색어" )

		if (promptsArray[x][0] === search) {
			reply = repliesArray[x]
			replyFound = true;
			// Stop inner loop when input value matches prompts
			break;
		}
		if (replyFound) {
			// Stop outer loop when reply is found instead of interating through the entire array
			break;
		}
	}


	/*
		복수처리
	for (var x = 0; x < 1; x++) {
		for (var y = 0; y < promptsArray[x].length; y++) {

			console.log( promptsArray[x][y] )
			console.log( "검색어 : " + search + " : 검색어" )

			if (promptsArray[x][y] === search) {
				var replies = repliesArray[x];
				reply = replies[Math.floor(Math.random() * replies.length)];
				replyFound = true;
				// Stop inner loop when input value matches prompts
				break;
			}
		}
		if (replyFound) {
			// Stop outer loop when reply is found instead of interating through the entire array
			break;
		}
	}
	*/
	return reply;
}

function addChat(input, product) {
  const messagesContainer = document.getElementById("messages");

  let userDiv = document.createElement("div");
  userDiv.id = "user";
  userDiv.className = "user response";
  userDiv.innerHTML = `<span>${input}</span><img src="/new/chatbot/user.png" class="avatar">`;
  messagesContainer.appendChild(userDiv);

  let botDiv = document.createElement("div");
  let botImg = document.createElement("img");
  let botText = document.createElement("span");
  botDiv.id = "bot";
  botImg.src = "/new/chatbot/bot-mini.gif";
  botImg.className = "avatar";
  botDiv.className = "bot response";
  botText.innerHTML = "입력중...";
  botDiv.appendChild(botImg);
  botDiv.appendChild(botText);
  messagesContainer.appendChild(botDiv);
  // Keep messages at most recent
  messagesContainer.scrollTop = messagesContainer.scrollHeight - messagesContainer.clientHeight;

  // Fake delay to seem "real"
  setTimeout(() => {
    botText.innerHTML = `${product}`;
  }, 2000
  )

}


function addChatRecommend(input, product) {
  const messagesContainer = document.getElementById("messages");

  let userDiv = document.createElement("div");
  userDiv.id = "user";
  userDiv.className = "user response";
  userDiv.innerHTML = `<img src="/new/chatbot/user.png" class="avatar"><span>${input}</span>`;
  messagesContainer.appendChild(userDiv);

  let botDiv = document.createElement("div");
  let botImg = document.createElement("img");
  let botText = document.createElement("span");
	botDiv.setAttribute(
	  'style',
	  'margin-left: auto;'
	);
  
  botDiv.id = "bot";
  botImg.src = "/new/chatbot/bot-mini.gif";
  botImg.className = "avatar";
  botDiv.className = "bot response";
  botText.innerHTML = "입력중...";
  botDiv.appendChild(botImg);
  botDiv.appendChild(botText);
  messagesContainer.appendChild(botDiv);
  // Keep messages at most recent
  messagesContainer.scrollTop = messagesContainer.scrollHeight - messagesContainer.clientHeight;
	
	var result = ""
	for (var a = 0; a < product.length; a++) {
		result+= "<button class='recommend' onclick='execute_output(\""+product[a]+"\");'>"+product[a]+"</button>"
	}
	console.log(result)
  // Fake delay to seem "real"
  setTimeout(() => {
    botText.innerHTML = result;
  }, 2000
  )

}

function fn_chat_recommend(chat_recommend){
	console.log(chat_recommend)
	document.getElementById('input').value = chat_recommend
}


//채팅창 초기화
function initChat() {

	document.getElementById("messages").innerHTML = "";
	const messagesContainer = document.getElementById("messages");

	let botDiv = document.createElement("div");
	let botImg = document.createElement("img");
	let botText = document.createElement("span");
	

	botDiv.id = "bot";
	botImg.src = "/new/chatbot/bot-mini.gif";
	botImg.className = "avatar";
	botDiv.className = "bot response";
	botText.innerText = "";
	botDiv.appendChild(botImg);  
	botDiv.appendChild(botText);

	messagesContainer.appendChild(botDiv);
	// Keep messages at most recent
	messagesContainer.scrollTop = messagesContainer.scrollHeight - messagesContainer.clientHeight;

	// Fake delay to seem "real"
	//botText.innerText = `안녕하세요 학습을 도와드리는 러비입니다. 질문을 입력해주세요.\n\n`;
	botText.innerText = alternative[0];
	console.log(botText.innerText)

	if(!is_play){
		var audio = new Audio('/new/chatbot/intro.mp3');
		audio.play();
		is_play = true;
	}
	/*
	setTimeout(() => {
		botText.innerText = `안녕하세요 학습을 도와드리는 러비입니다. 질문을 입력해주세요.\n\n`;
	}, 1000
	)
	*/
}



function getStringInBetween(string, start , end) {
    // start and end will be excluded
    var indexOfStart = string.indexOf(start)
    indexOfStart = indexOfStart + start.length;
    var newString = string.slice(indexOfStart)
    var indexOfEnd = newString.indexOf(end)
    return newString.slice(0, indexOfEnd)
}