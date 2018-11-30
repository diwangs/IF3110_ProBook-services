var searchDelay = null

function validate(id) {
    clearTimeout(searchDelay)
    setTimeout(() => {
        req = new XMLHttpRequest()
        req.onload = () => {
            // Apa yg dilakukan setelah mendapat jawaban
            if (!JSON.parse(req.responseText).result) {
                document.getElementById("isValid").innerHTML = "credit card number not found"
            }
        }
        req.open("GET", "http://localhost:3000/api/validate_customer/" + encodeURIComponent(id), true)
        req.send()
    }, 1000)
}