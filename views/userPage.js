const form = document.getElementsByTagName('form')[0]
form.style.display = 'none'
const button = document.getElementsByTagName('button')[0]
let visible = false
button.addEventListener('click', function (ev) {
    if (visible) {
        form.style.display = 'none'
        button.textContent = 'Показать'
        visible = false
    } else {
        form.style.display = 'block'
        button.textContent = 'Скрыть'
        visible = true
    }
})