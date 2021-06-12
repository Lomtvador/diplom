const form = document.getElementById('pageForm')
if (form !== null) {
    form.onsubmit = function (ev) {
        ev.preventDefault()
        let url = new URL(window.location.href)
        let page = form.firstElementChild.value
        url.searchParams.set('page', page)
        window.location.href = url.href
        return false
    }
}
let url = new URL(window.location.href)
const category = url.searchParams.get('category')
const categoryElement = document.getElementById('category')
if (category !== null && categoryElement !== null) {
    let options = categoryElement.getElementsByTagName('option')
    for (let option of options) {
        if (option.textContent === category) {
            option.selected = true
            break
        }
    }
}