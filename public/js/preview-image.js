document.getElementById('file').addEventListener('change', (e) => {
    let file = e.target.files[0];

    if (file && file.type.match('image.*')) {
        let reader = new FileReader();
        
        reader.onload = function (e) {
            let img = document.getElementById('prev');
            if (img) {
                img.src = e.target.result;
            } else {    
                img = document.createElement('img');
                img.src = e.target.result;
                img.id = 'prev'
                document.getElementById('image-prev').appendChild(img)
                document.querySelector('.preview-img').style.display = 'flex'
            }
        };
        
        reader.readAsDataURL(file);
    }
})

toggleModal(document.querySelector('.preview-img'), document.getElementById('image-prev'))


document.querySelector('.overlay').addEventListener('click', () => {
    closeModal(document.getElementById('image-prev'))
})