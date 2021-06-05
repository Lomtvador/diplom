const form = document.getElementById('pageForm')
form.onsubmit = function (ev) {
    ev.preventDefault()
    let url = new URL(window.location.href)
    let page = form.firstElementChild.value
    url.searchParams.set('page', page)
    window.location.href = url.href
    return false
}