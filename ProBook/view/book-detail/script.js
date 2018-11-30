var xmlhttp = new XMLHttpRequest();
let order_id = 0;


function alertOrder() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        order_id = xmlhttp.responseText;
        order_text = 'Nomor transaksi : ' + order_id;
        document.getElementById('nomor-transaksi').innerText = order_text;
        document.getElementById('order-modal').style.display = "block";
    }
}

function postOrder() {
    if (!xmlhttp){
        return;
    }
    var qry = '';
    var userEncoded = encodeURIComponent(document.getElementById('user-id').value);
    qry = qry + 'userid=' + userEncoded;
    var bookEncoded = encodeURIComponent(document.getElementById('book-id').value);
    qry = qry + '&bookid=' + bookEncoded;
    var totalEncoded = encodeURIComponent(document.getElementById('total-order').value);
    qry = qry + '&totalorder=' + totalEncoded;
    
    console.log('query = ' + qry);

    var url = '/controller/book-detail.php';
    xmlhttp.open('POST', url, true);
    xmlhttp.onreadystatechange = alertOrder;
    xmlhttp.setRequestHeader(
    'Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(qry);
}

var orderForm = document.getElementById('order-form');

orderForm.onsubmit = () => {
    postOrder();
    return false;
}

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
    document.getElementById('order-modal').style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == document.getElementById('order-modal')) {    
        document.getElementById('order-modal').style.display = "none";
    }
}