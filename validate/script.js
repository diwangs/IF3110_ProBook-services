var searchDelay = null

function validate(id) {
    clearTimeout(searchDelay)
    setTimeout(() => {
        req = new XMLHttpRequest()
        req.onload = () => {
            // Apa yg dilakukan setelah mendapat jawaban
            document.getElementById("isValid").innerHTML = JSON.parse(req.responseText).result
        }
        req.open("GET", "http://localhost:3000/api/validate_customer/" + encodeURIComponent(id), true)
        req.send()
    }, 1000)
}