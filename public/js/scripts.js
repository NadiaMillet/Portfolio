

$(document).ready(function () {
    let typed = new Typed("#typetxt", {
        strings: ["Développement Web", "Marketing Digital"],
        typeSpeed: 50,
        backSpeed: 50,
        loop: true
    });

    ////// AOS ////
    AOS.init();

    /*===== SHOW NAVBAR  =====*/
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId)

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                // show navbar
                nav.classList.toggle('show_nav')
                // change icon
                toggle.classList.toggle('bx-x')
                // add padding to body
                bodypd.classList.toggle('body-pd')
                // add padding to header
                headerpd.classList.toggle('body-pd')
            })
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')

    /*===== LINK ACTIVE  =====*/
    const linkColor = document.querySelectorAll('.nav__link')

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'))
            this.classList.add('active')
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink))


    // let details = document.querySelector("#modal-trigger")
    // for (let bouton of details) {
    //     bouton.addEventListener("click", function () {
    //         document.querySelector("#modal-trigger button").href = '/${this.dataset.id}'

    //         document.querySelector(".modal-content h5").innerText = '${this.dataset.titre}'

    //     })
    // }

});




