//-------------- 第一頁index的javaScrip樣式-------------------
//-------------- 第一頁index的javaScrip樣式-------------------
//-------------- 第一頁index的javaScrip樣式-------------------
//-------------- 第一頁index的javaScrip樣式-------------------
//-------------- 第一頁index的javaScrip樣式-------------------

// 修改carousel自動撥放的速度
// interval is in milliseconds. 1000 = 1 second -> so 1000 * 10 = 10 seconds
$('.carousel').carousel({
    interval: 1000 * 5
});


//----------window視窗滾動時topBar與內容的設定--------------------
//--------超出carousel_lenth再往上滑topbar的漸變消失會失效----------------

// 設置內容的padding top
// add padding top to show content behind navbar
// $('body').css('padding-top', $('.navbar').outerHeight() + 'px')


// detect scroll top or down
if ($('.smart-scroll').length > 0) { // check if element exists

    var last_scroll_top = 0;

    $(window).on('scroll', function () {
        var scroll_top = $(this).scrollTop();

        let carouselA = document.querySelector(".carousel-fade");
        var carouselHight = carouselA.getBoundingClientRect().height - 15;
        

        // 當超過 carouselHight 範圍時
        if (carouselHight  < scroll_top) {
            // 使bar向上滾動時出現,向下滾動時消失
            // scroll_top = $(this).scrollTop();

            if (scroll_top < last_scroll_top) {
                $('.smart-scroll').removeClass('scrolled-down').addClass('scrolled-up');
                $('.shopNumber_dropdown').fadeIn(100);

            } else {
                $('.smart-scroll').removeClass('scrolled-up').addClass('scrolled-down');
                $('.shopNumber_dropdown').fadeOut(100);

            }
            last_scroll_top = scroll_top;
        }else{
            $('.smart-scroll').removeClass('scrolled-up');
            // 跟addClass("color")transition屬性撞了
            // 必須要移除Class('scrolled-up')
            // 已解決！！
        }


    });
}


let indexContentDiv1 = document.querySelector('.index-contentDiv1');
let indexContentDiv2 = document.querySelector('.index-contentDiv2');

window.addEventListener('scroll', () => {

    var x = indexContentDiv1.getBoundingClientRect().top;
    var y = indexContentDiv2.getBoundingClientRect().top;
    var bodyHight = document.documentElement.clientHeight;

    if (y < bodyHight - 15) {
        $('.index-contentDiv2').addClass('opacity-change');
    } else {
        $('.index-contentDiv2').removeClass('opacity-change');
    }


    if (x < bodyHight - 15) {
        $('.index-contentDiv1').addClass('opacity-change');
    } else {
        $('.index-contentDiv1').removeClass('opacity-change');
    }

})


$(window).on('scroll', function () {

    var scroll_top = $(this).scrollTop();
    var bar_lenth = 1;

    // 當超過 bar_lenth 範圍時
    // 使Bar變色
    if (bar_lenth < scroll_top) {
        $('.smart-scroll').addClass('color');
        $('p').addClass('p-change');

    } else {
        $('.smart-scroll').removeClass('color');
        $('p').removeClass('p-change');

    }

});
//終於修好的Top-bar的bug
//使fa-bars第一次點擊時addClass'.responsive'
//使fa-bars第二次點擊時removeClass'.responsive'
function myFunction() {
    var x = document.getElementById("smart-scroll");
    // var y = document.getElementById("smart-scroll-2");
    if (x.className === "smart-scroll") {
        x.className += " responsive";
        // } else if (y.className === "smart-scroll-2") {
        // y.className += " responsive";
    } else {
        x.className = "smart-scroll";
        // y.className = "smart-scroll-2";
    }
}

function myFunction2() {
    var y = document.getElementById("smart-scroll-2");
    if (y.className === "smart-scroll-2") {
        y.className += " responsive";

    } else {
        y.className = "smart-scroll-2";
    }
}



//-------------- 第二頁man_page的javaScrip樣式-------------------
//-------------- 第二頁man_page的javaScrip樣式-------------------
//-------------- 第二頁man_page的javaScrip樣式-------------------
//-------------- 第二頁man_page的javaScrip樣式-------------------
//-------------- 第二頁man_page的javaScrip樣式-------------------

const card = document.querySelectorAll('.shoes_head>.card-deck>.card');


// window.addEventListener('scroll', () => {

//     card.forEach((elm, idx) => {
//         // console.log(document.documentElement.clientHeight);
//         // 視窗高度 518-15=503
//         // card[0].getBoundingClientRect().top = 
//         // 424.0000305175781
//         // 429.0000305175781

//         var shoesTop = card[idx].getBoundingClientRect().top;
//         // console.log(shoesTop);
//         if (shoesTop < document.documentElement.clientHeight -15) {
//             card[idx].classList.add("shoesUp");
//         } else {
//             card[idx].classList.remove("shoesUp");
//         }

//     })
// });

// Setup our function to run on various events
var someFunction = function (event) {
    // Do something...
    card.forEach((elm, idx) => {
        // console.log(document.documentElement.clientHeight);
        // 視窗高度 518-15=503
        // card[0].getBoundingClientRect().top = 
        // 424.0000305175781
        // 429.0000305175781

        var shoesTop = card[idx].getBoundingClientRect().top;
        // console.log(shoesTop);
        if (shoesTop < document.documentElement.clientHeight - 15) {
            card[idx].classList.add("shoesUp");
        } else {
            card[idx].classList.remove("shoesUp");
        }

    })
};

// Add our event listeners
window.addEventListener('scroll', someFunction, false);
window.addEventListener('load', someFunction, false);
window.addEventListener('change', someFunction, false);



$(document).ready(function () {
    $('.buttonDiv>button:nth-of-type(1)').css({
        'color': 'black',
    });
    $('.buttonDiv>button:nth-of-type(1)').prop('disabled', true); //按鈕已經禁用//
});


$(".smaller").click(function () {

    $('.card').fadeTo("slow", 0).delay(500).fadeTo(500, 1);
    setTimeout(function () {
        $('.card').attr('id', 'card-change');
        $('.card-img-top').attr('id', 'card-img-top-change');
        // change the image
    }, 1000);



    $('.buttonDiv>button:nth-of-type(1)').css({
        'color': '',
    });
    $('.buttonDiv>button:nth-of-type(1)').prop('disabled', false); //按鈕已經啟用//
    $('.buttonDiv>button:nth-of-type(2)').css({
        'color': 'black',
    });
    $('.buttonDiv>button:nth-of-type(2)').prop('disabled', true); //按鈕已經禁用//

});

$(".bigger").click(function () {

    $('.card').fadeTo("slow", 0).delay(500).fadeTo(500, 1);
    setTimeout(function () {
        $('.card').removeAttr('id', 'card-change');
        $('.card-img-top').removeAttr('id', 'card-img-top-change');
        // change the image
    }, 1000);



    $('.buttonDiv>button:nth-of-type(1)').css({
        'color': 'black',
    });
    $('.buttonDiv>button:nth-of-type(1)').prop('disabled', true); //按鈕已經禁用//
    $('.buttonDiv>button:nth-of-type(2)').css({
        'color': '',
    });
    $('.buttonDiv>button:nth-of-type(2)').prop('disabled', false); //按鈕已經啟用//

});



// 
//-------------- 第三頁product_page的javaScrip樣式-------------------
//-------------- 第三頁product_page的javaScrip樣式-------------------
//-------------- 第三頁product_page的javaScrip樣式-------------------
//-------------- 第三頁product_page的javaScrip樣式-------------------
//-------------- 第三頁product_page的javaScrip樣式-------------------




// setTimeout(function addBag() {
//     var i = document.getElementById('shopNumberTable');
//     i.className += " responsive";
//     $('.darkDiv').css({ 'display': 'block', });
// }, 500);
// function addBag() {
//     var i = document.getElementById('shopNumberTable');
//     i.className += " responsive";
//     $('.darkDiv').css({ 'display': 'block', });
// };


function shopDropdown() {
    var i = document.getElementById('shopNumberTable');

    if (i.className === 'shopNumberTable') {
        i.className += " responsive";
        $('.darkDiv').css({
            'display': 'block',
        })

    } else {
        i.className = "shopNumberTable";
        $('.darkDiv').delay(500).hide(0);
    }
}




function BGdark() {
    var i = document.getElementById('shopNumberTable');
    i.className = "shopNumberTable";
    $('.darkDiv').delay(500).hide(0);
}