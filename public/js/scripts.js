$(document).ready(function () {
    $('.ui.sidebar').sidebar({
        context: $('.bottom.segment')
    })
        .sidebar('attach events', '.menu .item');



    // effet photo
    $('.photoslide')
        .animate('slide-right')
});

$(document).ready(function () {
    let typed = new Typed("#typetxt", {
        strings: ["Développement Web", " Marketing Digital"],
        typeSpeed: 50,
        backSpeed: 50,
        loop: true
    });
});


