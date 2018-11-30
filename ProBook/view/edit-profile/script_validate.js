var searchDelay = null

var isCardValid = true

function validate(id) {
    isCardValid = false;
    clearTimeout(searchDelay)
    setTimeout(() => {
        req = new XMLHttpRequest()
        req.onload = () => {
            console.log(JSON.parse(req.responseText).result)
            // Apa yg dilakukan setelah mendapat jawaban
            if (!JSON.parse(req.responseText).result) {
                document.getElementById("err_msg").classList.remove('hidden');
                isCardValid = false;
            } else {
                document.getElementById("err_msg").classList.add('hidden');
                isCardValid = true;
            }
        }
        req.open("GET", "http://localhost:3000/api/validate_customer/" + encodeURIComponent(id), true)
        req.send()
    }, 1000)
}