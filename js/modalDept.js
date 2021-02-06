const modalView = () => {
    const modalBtn = document.querySelector('.team-modal-btn');
    const modalBg = document.querySelector('.team-modal-bg');
    const modalClose = document.querySelector('.team-modal-close');
    // const items = document.querySelectorAll("td:nth-last-child(2)");

    // items.forEach(function(elem) {
    //     elem.addEventListener('click',function() {
    //         modalBg.classList.add('bg-active');
    //     });
    // });

    modalBtn.addEventListener('click',function() {
        modalBg.classList.add('team-bg-active');
    });

    modalClose.addEventListener('click', function() {
        modalBg.classList.remove('team-bg-active');
    });
}

modalView();