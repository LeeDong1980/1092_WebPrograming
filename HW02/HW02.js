
let GameState = 1;
const SETTING = 1, START = 2, FINISH = 3;

let cardNum = 0;
let cardList = [];
let cardSection = document.getElementsByClassName("card-section")[0];
let startBtn = document.getElementById("startBtn");
let stopBtn = document.getElementById("stopBtn");
let reStartBtn = document.getElementById("reStartBtn");
let hintBtn = document.getElementById("hintBtn");
let selectSheet = document.getElementById("select-sheet");
let countdown = document.getElementsByClassName("counter")[0];

let selectCard1, selectCard2;
let canFlipCard = false;

let countDownHandler;
let counter = 0;
let isStop = false;
let canHint = false;

let checkWinHandler;

function init() {
    GameState = SETTING;
    clearCard();
    createCard();
    addCardToGame();
    cardList.forEach(item => {
        item.isCompleted = false;
    });
    updateCard();
    startBtn.addEventListener("click", () => {
        if (GameState != SETTING) { alert("遊戲尚未結束，如欲重來請按「重新開始」！"); return; }
        GameState = START;
        // console.log(cardList);
        checkWinHandler = setInterval(() => {
            checkWin();
        }, 100);
        updateGameState();
    })
    stopBtn.addEventListener("click", () => {
        if (GameState != START) return;
        isStop = !isStop;
        if (isStop) {
            gameStop();
        }
        else {
            gameResume();
        }
    })
    reStartBtn.addEventListener("click", () => {
        gameReset();
    })
    hintBtn.addEventListener("click", () => {
        hint();
    })
    selectSheet.addEventListener("change", () => {
        if (GameState != SETTING) return;
        clearCard();
        createCard();
        addCardToGame();
        updateCard();
        countDownReset();
    })
    updateGameState();
}
function showCardTemp(time) {
    canHint = false;
    canFlipCard = false;
    cardList.forEach(item => {
        item.isOpen = true
    });
    updateCard();
    setTimeout(() => {
        cardList.forEach(item => {
            item.isOpen = false;
        });
        updateCard();
        canFlipCard = true;
        canHint = true;
        if(!isStop) countDownStart();
    }, time);
}

function updateGameState() {
    switch (GameState) {
        case SETTING:
            cardList.forEach(item => {
                item.isOpen = false;
                item.isCompleted = false;
            });
            selectCard1 = selectCard2 = null;
            countDownReset();
            updateCard();
            break;
        case START:
            showCardTemp(1000);
            
        break;
        case FINISH:
            countDownStop();
            break;
        default:
            break;
    }
}
function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
      let j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
}
function clearCard() {
    cardList = [];
    cardSection.innerHTML = "";
}
function createCard() {
    for (let index = 0; index < selectSheet.value; index++) {
        let card1 = {
            id: index * 2,
            type: index,
            frontImg: "./img/" + index + ".jpg",
            backImg: "./img/back.jpg",
            cardBox: new CardBox(),
            card: new Card("./img/" + index + ".jpg"),
            isOpen: false,
            isCompleted: false,
        };
        let card1Copy = {
            id: index * 2 + 1,
            type: index,
            frontImg: "./img/" + index + ".jpg",
            backImg: "./img/back.jpg",
            cardBox: new CardBox(),
            card: new Card("./img/" + index + ".jpg"),
            isOpen: false,
            isCompleted: false,
        };

        card1.cardBox.appendChild(card1.card);
        card1Copy.cardBox.appendChild(card1Copy.card);

        cardList.push(card1);
        cardList.push(card1Copy);
    }
    cardList.forEach(cardItem => {
        cardItem.cardBox.addEventListener("click", () => {
            ClickCardEvent(cardItem);
        });
    });
    shuffle(cardList);
            
}

function addCardToGame() {
    cardList.forEach(element => {
        document.getElementsByClassName("card-section")[0].appendChild(element.cardBox);
    });
}
function CardBox() {
    let cardBox = document.createElement("div");
    cardBox.setAttribute("class", "card-box");
    
    return cardBox;
}
function Card(img) {
    let card = document.createElement("img");
    card.setAttribute("class", "card");
    card.src = img;
    
    return card;
}
function updateCard() {
    cardList.forEach(cardItem => {
        cardItem.card.src = cardItem.isOpen ? cardItem.frontImg : cardItem.backImg;
    });
}
function ClickCardEvent(cardItem) {
    
    if (!canFlipCard || cardItem.isCompleted || GameState != START) return;
    if (selectCard1 === null && selectCard2 === null) {
        selectCard1 = cardItem;
        cardItem.isOpen = true;
        
    } 
    else if(selectCard1 != null && selectCard2 === null) {
        if (selectCard1.id === cardItem.id) return;
        selectCard2 = cardItem;
        cardItem.isOpen = true;
        if (selectCard1.type != selectCard2.type) {
            canFlipCard = false;
            setTimeout(() => {
                selectCard1.isOpen = selectCard2.isOpen = false;
                selectCard1 = selectCard2 = null;
                updateCard();
                canFlipCard = true;
            }, 2500);
        } else {
            canFlipCard = false;
            selectCard1.isOpen = selectCard2.isOpen = true;
            selectCard1.isCompleted = selectCard2.isCompleted = true;
            selectCard1 = selectCard2 = null;
            setTimeout(() => {
                canFlipCard = true;
            }, 500);
        }
    }
    // console.log(selectCard1, selectCard2);
    updateCard();
}
function countDownStart() {
    countDownHandler = setInterval(() => {
        counter += 1;
        let passTimeStr ="經過時間： " + Math.floor(counter / 600) + " 分 " + counter % 600 / 10 + " 秒 ";
        countdown.innerHTML = passTimeStr;
    }, 100);
}
function countDownStop() {
    clearInterval(countDownHandler);
}

function countDownReset() {
    counter = 0;
    clearInterval(countDownHandler);
    let passTimeStr ="經過時間： " + 0 + " 分 " + 0 + " 秒 ";
    countdown.innerHTML = passTimeStr;
}
function gameStop() {
    countDownStop();
    canFlipCard = false;
    console.log(canFlipCard);
    stopBtn.innerHTML = "繼續遊戲";
}
function gameResume() {
    countDownStart();
    canFlipCard = true;
    console.log(canFlipCard);
    stopBtn.innerHTML = "遊戲暫停";
}
function gameReset() {
    clearCard();
    createCard();
    addCardToGame();
    updateCard();
    cardList.forEach(item => {
        item.isCompleted = false;
    });
    clearInterval(checkWinHandler);
    isStop = false;
    countDownReset();
    canFlipCard = false;
    stopBtn.innerHTML = "遊戲暫停";
    GameState = SETTING;
    updateGameState();
}
function checkWin() {
    let isWin = true;
    for (i in cardList) {
        if (!cardList[i].isCompleted) {
            isWin = false;
            break;
        }
    }
    if (isWin) {
        GameState = FINISH;
        updateGameState();
        alert("You Win!");
        // console.log("win");
    }
}
function hint() {
    if (GameState != START || !canHint) return;
    canHint = false;
    canFlipCard = false;
    cardList.forEach(item => {
        item.isOpen = true
    });
    updateCard();
    setTimeout(() => {
        cardList.forEach(item => {
            if(!item.isCompleted) item.isOpen = false;
        });
        updateCard();
        canHint = true;
        canFlipCard = true;
    }, 1000);
}
init();
updateGameState();