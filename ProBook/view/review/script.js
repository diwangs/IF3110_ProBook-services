function changeStarToBlank(id) {
    star_id = 'star' + id;
    var star = document.getElementById(star_id).src="/assets/images/blank-star-64.png";
}

function changeStarToFill(id) {
    star_id = 'star' + id;
    var star = document.getElementById(star_id).src="/assets/images/full-star-64.png";
}

function fillStarUntil(id) {
    for (var i = 1; i <= id; i++) {
        changeStarToFill(i);
    }
    for (var i = id+1; i <= 5; i++) {
        changeStarToBlank(i);
    }
}

function fillStarUntil1() {fillStarUntil(1);}
function fillStarUntil2() {fillStarUntil(2);}
function fillStarUntil3() {fillStarUntil(3);}
function fillStarUntil4() {fillStarUntil(4);}
function fillStarUntil5() {fillStarUntil(5);}

function starMouseOut() {
    var rating = document.getElementsByName('rating');
    var star = 0;
    for (var i = 0; i < rating.length; i++) {
        if (rating[i].checked) {
            star = i+1;
            break;
        }
    }
    fillStarUntil(star);
}

function validateRating() {
    var rating = document.getElementsByName('rating');
    var checked = false;
    for (var i = 0; i < rating.length; i++) {
        if (rating[i].checked) {
            checked = true;
        }
    }
    var ratingValidation = document.getElementById('rating-validation');
    if (! checked) {
        ratingValidation.innerText = 'This field is required';
        return false;
    } else {
        ratingValidation.innerText = '';
        return true;
    }
}

function validateComment() {
    var comment = document.getElementById('comment').value;
    var commentValidation = document.getElementById('comment-validation');
    if (comment.length === 0) {
        commentValidation.innerText = 'This field is required';
        return false;
    } else {
        commentValidation.innerText = '';
        return true;
    }
}

var rating = document.getElementsByName('rating');
var comment = document.getElementById('comment');

var star1 = document.getElementById('star1');
var star2 = document.getElementById('star2');
var star3 = document.getElementById('star3');
var star4 = document.getElementById('star4');
var star5 = document.getElementById('star5');

var star_all = document.getElementsByClassName('rating-img');

var reviewForm = document.getElementById('review-form');

rating.onclick = validateRating;
comment.onchange = validateComment;

star1.onmouseover = fillStarUntil1;
star2.onmouseover = fillStarUntil2;
star3.onmouseover = fillStarUntil3;
star4.onmouseover = fillStarUntil4;
star5.onmouseover = fillStarUntil5;

star1.onmouseout = starMouseOut;
star2.onmouseout = starMouseOut;
star3.onmouseout = starMouseOut;
star4.onmouseout = starMouseOut;
star5.onmouseout = starMouseOut;



reviewForm.onsubmit = () => {
    validateRating();
    validateComment();
    if (!(validateRating() && validateComment())) {
        return false;
    } else {
        return true;
    }
}

var backButton = document.getElementById('back');

backButton.onclick = () => {
    window.location.href = "/view/history";
}