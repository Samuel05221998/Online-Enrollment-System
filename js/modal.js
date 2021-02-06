const modalView = () => {
    const modalBtn = document.querySelector('.modal-btn');
    const modalBg = document.querySelector('.modal-bg');
    const modalClose = document.querySelector('.modal-close');
    // const items = document.querySelectorAll("td:nth-last-child(2)");

    // items.forEach(function(elem) {
    //     elem.addEventListener('click',function() {
    //         modalBg.classList.add('bg-active');
    //     });
    // });

    modalBtn.addEventListener('click',function() {
        modalBg.classList.add('bg-active');
    });

    modalClose.addEventListener('click', function() {
        modalBg.classList.remove('bg-active');
    });
}

modalView();