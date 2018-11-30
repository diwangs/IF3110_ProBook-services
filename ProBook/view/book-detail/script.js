var xmlhttp = new XMLHttpRequest();
let order_id = 0;


function alertOrder() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        order_id = xmlhttp.responseText;
        console.log(typeof order_id)
        console.log(order_id)
        order_text = '';
        if (order_id == 0) {
            document.getElementById('success-text').innerText = 'Pemesanan gagal';
            document.getElementById('nomor-transaksi').innerText = ' ';
            order_text = 'Transaksi gagal';
        } else {
            document.getElementById('success-text').innerText = 'Pemesanan berhasil!';
            document.getElementById('nomor-transaksi').innerText = 'Nomor transaksi : ' + order_id;
        }
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
    var userBankEncoded = encodeURIComponent(document.getElementById('user-bank-id').value);
    qry = qry + '&userbankid=' + userBankEncoded;
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