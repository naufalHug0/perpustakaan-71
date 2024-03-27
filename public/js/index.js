const flash = document.querySelector('.alert.flash')
const dropdown_dot = document.querySelectorAll('#dot-icon')
const delete_icon = document.querySelectorAll('#action-wrapper p:nth-child(2)')
const modalCloseIcon = document.querySelector('.modal header .close')

if (dropdown_dot) {
    dropdown_dot.forEach((dot,i) => {
        toggleDropdown(dot, document.querySelectorAll('#action-wrapper')[i])
    })
}

if (delete_icon) {
    document.querySelectorAll('#action-wrapper p:nth-child(2)').forEach(del => {
        toggleModal(del, document.querySelector('.modal'))
    })
}

if (modalCloseIcon) {
    document.querySelector('.modal header .close').addEventListener('click', () => {
        closeModal(document.querySelector('.modal'))
    })
}

if (flash) {
    flash.classList.remove('float-out')
    flash.classList.add('float-in')
    
    setTimeout(() => {
        flash.classList.add('float-out')
        flash.classList.remove('float-in')
    }, 4000)
}
