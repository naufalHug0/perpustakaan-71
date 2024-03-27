const toggleDropdown = (button, dropdown_list) => {
    button
    .addEventListener('click', e => {
        dropdown_list.classList.toggle((dropdown_list.classList.contains('show-dropdown') ? 'hide' : 'show')+'-dropdown')
        document.body.classList.toggle('freeze-page')
    })
}

const toggleModal = (button, modal) => {
    button
    .addEventListener('click', e => {
        modal.classList.toggle((modal.classList.contains('show-dropdown') ? 'hide' : 'show')+'-dropdown')
        document.querySelector('.overlay').style.display = modal.classList.contains('show-dropdown') ? 'block' : 'none'
    })
}

const closeModal = (modal) => {
    modal.classList.toggle('hide-dropdown')
    document.querySelector('.overlay').style.display = 'none'
}

const msg_container = document.querySelector('.alert')

const showAlert = () => {
    msg_container.classList.add('float-in')
    msg_container.classList.remove('float-out')

    setTimeout(() => {
        msg_container.classList.remove('float-in')
        msg_container.classList.add('float-out')
    }, 2800)
}

const itemType = {
    KATEGORI: 'KATEGORI',
    ANGGOTA: 'ANGGOTA',
    BUKU: 'BUKU',
    PEMINJAMAN: 'PEMINJAMAN',
    ADMIN: 'ADMIN',
}

const deleteItem = () => {
    const type = sessionStorage.getItem('delete_type')
    const id = sessionStorage.getItem('selected_id')

    location.href = `delete.php?type=${type}&id=${id}`
}

const setDeleteItem = (id, type) => {
    sessionStorage.setItem('selected_id',id)
    sessionStorage.setItem('delete_type', type)
}