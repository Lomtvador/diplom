const rating = document.getElementById('rating')
if (rating !== null) {
    rating.selectedIndex = rating.dataset.value
}

const category = document.getElementById('category')
if (category !== null) {
    const value = category.dataset.value
    let options = category.getElementsByTagName('option')
    for (let option of options) {
        if (option.textContent === value) {
            option.selected = true
            break
        }
    }
}